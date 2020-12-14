<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Response;
use SimpleXMLElement;
use SoapClient;
use Auth;
use Log;

use App\Services\eventLogServices;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        if(Auth::user()->tipo=="A"){

            $search = $request->get('search');
            $field  = $request->get('field') ?? 'data_log';
            $sort   = $request->get('sort')  ?? 'desc';
            
            $dataDe  = $request->dataEventosDe  ?? Carbon::now()->firstOfMonth();
            $dataAte = $request->dataEventosAte ?? Carbon::now()->lastOfMonth();

            $events = DB::table('event_log')
                      ->join('usuario', 'usuario.id','=', 'event_log.user_id')
                      ->whereBetween('data_log', [$dataDe, $dataAte])
                      ->where(function ($query) use ($search) {
                      $query->where([
                            ['name', 'like' , '%' . $search . '%'],
                            ])->orWhere([
                            ['login', 'like', '%' . $search . '%'],
                            ])->orWhere([
                            ['mensagem', 'like', '%' . $search . '%'],
                            ]);
                       })
                       ->orderBy($field, $sort)
                       ->get();
            return view('eventLog')->with('events', $events);

        } else {    
            
            $search = $request->get('search');
            $field  = $request->get('field') ?? 'emissao';
            $sort   = $request->get('sort')  ?? 'asc';
            
            $dataEmissaoDe  = $request->dataTituloDe   ?? Carbon::now()->subYears(5);
            $dataEmissaoAte = $request->dataTitutloAte ?? Carbon::now()->today();
            $dataVenctoDe   = $request->dataVenctoDe   ?? Carbon::now()->subYears(5);
            $dataVenctoAte  = $request->dataVenctoAte  ?? Carbon::now()->addYear();

            $boletos = DB::table('boletos')
                        ->where('id_usuario','=', Auth::user()->id)
                        ->whereBetween('emissao',    [$dataEmissaoDe, $dataEmissaoAte])
                        ->whereBetween('vencimento', [$dataVenctoDe, $dataVenctoAte])
                        ->where(function ($query) use ($search) {
                            $query->where([
                            ['empresa', 'like' , '%' . $search . '%'],
                            ])->orWhere([
                            ['cidade', 'like', '%' . $search . '%'],
                            ]);
                        })
                        ->orderBy('empresa', 'asc')
                        ->orderBy($field, $sort)
                        ->get();
            return view('boletos')->with('boletos', $boletos);

        }
    }


    public function getDownload($id)
    {

        $url = DB::table('parameters')->where('name','=', 'wsdlBoletos')->first();
        ini_set('default_socket_timeout', 600); 
        ini_set('soap.wsdl_cache_enabled',0);
        ini_set('soap.wsdl_cache_ttl',0);
        if($url->value){

            try {
                $string = '<?xml version="1.0"?>';
                $string .= '<consultaBoletos xmlns="urn:'.env("APP_WSDL_URN").'" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">';
                $string .= '<consultaBoletos xmlns="">';
                $string .= '<transacao>boleto</transacao>';
                $string .= '<data_inicial></data_inicial>';
                $string .= '<data_final></data_final>';
                $string .= '<cnpj_cliente>'.Auth::user()->login.'</cnpj_cliente>';
                $string .= '<num_id_titulo>'.$id.'</num_id_titulo>';
                $string .= '<data_boleto></data_boleto>';
                $string .= '<cidade_ini></cidade_ini>';
                $string .= '<cidade_fim></cidade_fim>';
                $string .= '<estado_ini></estado_ini>';
                $string .= '<estado_fim></estado_fim>';
                $string .= '<num_titulo_ini></num_titulo_ini>';
                $string .= '<num_titulo_fim></num_titulo_fim>';
                $string .= '<dt_vencto_ini></dt_vencto_ini>';
                $string .= '<dt_vencto_fim></dt_vencto_fim>';
                $string .= '<vl_original_ini></vl_original_ini>';
                $string .= '<vl_original_fim></vl_original_fim>';
                $string .= '</consultaBoletos>';
                $string .= '</consultaBoletos>';
                $params = array('lcXmlInput'=>$string);


                log::Debug($string);
                $client = new SoapClient( $url->value.'/wsdl?targetURI=urn:'.env("APP_WSDL_URN") , array('trace' => 1)); 
                $client->__setLocation( $url->value );

                $response = $client->consultaBoletos($params);
                $response = json_encode($response);
                $response = json_decode($response, true);
                log::Debug($response);

                $xml = new SimpleXMLElement($response['lcXmlOutput']);
                if($xml){

                    $xml = json_encode($xml);
                    $xml = json_decode($xml, true);

                    $nomearquivo = $xml['RetornaBoletos']['titulo'].'-'.$xml['RetornaBoletos']['num_id_titulo'].'.pdf';
                    file_put_contents( public_path().'/downloads/'.$nomearquivo, base64_decode( $xml['RetornaBoletos']['arq_boleto']) );

                    if($nomearquivo){

                        log::Debug($nomearquivo);
                        $file = public_path(). "/downloads/".$nomearquivo;
                        $headers = array('Content-Type: application/pdf');
                        eventLogServices::create(Auth::user()->id, 'Usuário realizou download do titulo: '.$nomearquivo.'!');
                        return response()->download( $file , $nomearquivo, $headers);
                    }
            
                }

            
            } catch (\Exception $e) {
                log::Debug('ERRO: '.$e->getMessage());
            }
        }

    }

}
