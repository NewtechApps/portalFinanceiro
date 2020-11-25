<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Log;

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

}
