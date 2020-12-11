<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            
            $events = DB::table('event_log')
                      ->join('usuario', 'usuario.id','=', 'event_log.user_id')
                      ->where(function ($query) use ($search) {
                      $query->where([
                            ['name', 'like' , '%' . $search . '%'],
                            ])->orWhere([
                                ['mensagem', 'like', '%' . $search . '%'],
                            ]);
                       })
                       ->orderBy($field, $sort)
                       ->get();
            return view('eventLog')->with('events', $events);

        } else {    
            
            $boletos = array();
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
                    //$string .= '<cnpj_cliente>63536825</cnpj_cliente>';
                    //$string .= '<cnpj_cliente>61565222</cnpj_cliente>';
                    $string .= '<cnpj_cliente>72381957</cnpj_cliente>';
                    $string .= '<num_id_titulo></num_id_titulo>';
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


                    $client = new SoapClient( $url->value.'/wsdl?targetURI=urn:paramount', array('trace' => 1)); 
                    $client->__setLocation( $url->value );
                    $response = $client->consultaBoletos($params);

                    $response = json_encode($response);
                    $response = json_decode($response, true);

                    $xml = new SimpleXMLElement($response['lcXmlOutput']);
                    $xml = json_encode($xml);
                    $xml = json_decode($xml, true);
                    
                    //log::Debug($xml);
                    //log::Debug($client->__getFunctions());
                    //log::Debug($client->__getLastRequest());

                    
                } catch (\Exception $e) {
                    //eventLogServices::create(Auth::user()->id, 'Erro de comunicação: '.$e->getMessage());
                    log::Debug($e->getMessage());
                }
                return view('boletosWSDL')->with('boletos', $xml);
                    

            } else {

                $search = $request->get('search');
                $field  = $request->get('field') ?? 'emissao';
                $sort   = $request->get('sort')  ?? 'asc';
                
                $boletos = DB::table('boletos')
                          ->orderBy('empresa', 'asc')
                          ->orderBy($field, $sort)
                          ->get();
                return view('boletos')->with('boletos', $boletos);
            }

        }
    }
}
