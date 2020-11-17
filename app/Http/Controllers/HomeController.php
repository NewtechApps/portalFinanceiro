<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SoapClient;
use Auth;
use Log;

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
    public function index()
    {

        if(Auth::user()->tipo=="A"){
            
            
            /*
            
            $string = '<?xml version="1.0"?>
                        <ConsultaBoletos xmlns="urn:boleto" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
                        <ConsultaBoletos xmlns=""><transacao>boleto</transacao>
                        <data_inicial></data_inicial>
                        <data_final></data_final>
                        <cnpj_empresa></cnpj_empresa><cnpj_cliente></cnpj_cliente>
                        <num_id_titulo></num_id_titulo>
                        <data_boleto>'.date("d/m/y").'</data_boleto>
                        <idioma></idioma>
                        <usuario>'.Auth::user()->login.'</usuario>
                        <opcao></opcao>
                        <estab_ini></estab_ini><estab_fim></estab_fim>
                        <unid_neg_ini></unid_neg_ini><unid_neg_fim></unid_neg_fim>
                        <cidade_ini></cidade_ini><cidade_fim></cidade_fim>
                        <num_titulo_ini></num_titulo_ini>
                        <num_titulo_fim></num_titulo_fim>
                        <dt_vencto_ini></dt_vencto_ini><dt_vencto_fim></dt_vencto_fim>
                        <vl_original_ini></vl_original_ini><vl_original_fim></vl_original_fim>
                        </ConsultaBoletos>
                        </ConsultaBoletos>';
            $params = array('lcXmlInput'=>$string);
            
            $url    = "http://200.185.49.67:8280/wsa/wsappbnteste/wsdl?targetURI=urn:paramount";
            log::Debug( file_get_contents($url)) ;
            $client = new SoapClient( $url, array('trace' => 1)); 

            //$response= $client->consultaBoletos();
            $response  = $client->__soapCall('consultaBoletos', $params);
            //$soap    = simplexml_load_string(utf8_encode($teste['lcXmlOutput']));            
            //log::Debug($response);

            */

            $boletos = '';
            return view('boletos')->with('boletos', $boletos);
        }
    }
}
