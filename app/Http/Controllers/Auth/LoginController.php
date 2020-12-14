<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use SimpleXMLElement;
use SoapClient;
use Log;

use App\Models\Boletos;
use App\Services\eventLogServices;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }



    public function username()
    {
        return 'login';
    }


    public function logout(Request $request) 
    {
        Auth::logout();
        return redirect('/');
    }


    protected function validateLogin(Request $data)
    {

        $this->validate($data, [
            'login'    => ['required'],
            'password' => ['required'],
        ], [], [
            'login' => 'Usuário',
            'password' => 'Senha',
        ]);
    }


    protected function login(Request $request)
    {

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }


        $usuario = DB::table('usuario')->where('login', '=', $request->login)->first();
        if(!$usuario){

            if ($this->attemptLogin($request)) {
                return $this->sendLoginResponse($request);
            }

            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            $this->incrementLoginAttempts($request);
            return $this->sendFailedLoginResponse($request);
    
        } else {

            if($usuario->primeiro=='S'){

                eventLogServices::create($usuario->id, 'Tentativa de Login pela primeira vez!');
                return view('auth.passwords.email')->with('usuario', $usuario);

            } else {
                if ($this->attemptLogin($request)) {

                    eventLogServices::create($usuario->id, 'Login efetuado com sucesso!');
                    return $this->sendLoginResponse($request);
                } 

                // If the login attempt was unsuccessful we will increment the number of attempts
                // to login and redirect the user back to the login form. Of course, when this
                // user surpasses their maximum number of attempts they will get locked out.
                $this->incrementLoginAttempts($request);
                return $this->sendFailedLoginResponse($request);

            }
        }
    }


    protected function authenticated(Request $request, $user)
    {

        if(Auth::user()->tipo=="C"){

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
                    $string .= '<cnpj_cliente>'.Auth::user()->login.'</cnpj_cliente>';
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



                    log::Debug($string);
                    $client = new SoapClient( $url->value.'/wsdl?targetURI=urn:'.env("APP_WSDL_URN") , array('trace' => 1)); 
                    $client->__setLocation( $url->value );

                    $response = $client->consultaBoletos($params);
                    $response = json_encode($response);
                    $response = json_decode($response, true);
                    log::Debug($response);

                    $xml = new SimpleXMLElement($response['lcXmlOutput']);
                    if($xml){

                        DB::table('boletos')->where('id_usuario', '=', Auth::user()->id)->delete();

                        $xml = json_encode($xml);
                        $xml = json_decode($xml, true);

                        foreach($xml['RetornaBoletos'] as $boleto){ 
                        
                            $boletos = new Boletos();
                            $boletos->valor_saldo = 0;
                            $boletos->id_usuario  = Auth::user()->id;

                            $boletos->titulo           = $boleto['titulo'].'/'.$boleto['parcela'];
                            $boletos->id_titulo        = $boleto['num_id_titulo'];
                            $boletos->CNPJ             = $boleto['cnpj_cliente'];
                            $boletos->cidade           = $boleto['cidade_cli'];
                            $boletos->estado           = $boleto['estado_cli'];
                            $boletos->empresa          = $boleto['nome_cliente'];
                            $boletos->emissao          = Carbon::parse( str_replace('/', '-', $boleto['data_emissao'] ));
                            $boletos->vencimento       = Carbon::parse( str_replace('/', '-', $boleto['data_vencimento'] ));
                            $boletos->prorrogacao      = Carbon::parse( str_replace('/', '-', $boleto['data_boleto'] ));
                            
                            $valororiginal = str_replace('.', '',  $boleto['val_original']);
                            $valororiginal = str_replace(',', '.', $valororiginal);

                            $valoratualizado = str_replace('.', '',  $boleto['val_calculado']);
                            $valoratualizado = str_replace(',', '.', $valoratualizado);

                            $boletos->valor_original  = (float) $valororiginal;
                            $boletos->valor_atualizado = (float) $valoratualizado;
                            $boletos->save();
                        }
                    }

                
                } catch (\Exception $e) {
                    log::Debug($e->getMessage());
                }
            }
        }
    }
}