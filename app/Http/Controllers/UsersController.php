<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Validator;

use App\Models\Usuario;    
use App\Services\eventLogServices;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        $search = $request->get('search');
        $field  = $request->get('field') ?? 'name';
        $sort   = $request->get('sort')  ?? 'asc';
        
        $usuario = DB::table('usuario')
                  ->where(function ($query) use ($search) {
                  $query->where([
                            ['name', 'like' , '%' . $search . '%'],
                        ])->orWhere([
                            ['login', 'like', '%' . $search . '%'],
                        ]);
                   })
                   ->orderBy($field, $sort)
                   ->get();
        return view('usuarios')->with('usuarios', $usuario);
    }



    public function create(Request $request)
    {

        $validator = Validator::make( $request->all(), [
            'name'  => 'required',
            'tipo'  => 'required',
            'login' => 'required|unique:usuario,login',
            'email' => 'required|email|unique:usuario,email',
             ], [], [
            'name'  => 'Nome',
            'login' => 'Login',
            'email' => 'E-mail',
            'tipo'  => 'Tipo de Usuário',
             ]);

        if ($validator->fails()) {
            return response()->json(['code'=>'401', 'erros'=>$validator->messages()]);
        } else {  

            try {

                $usuario = new Usuario();
                $usuario->name   = $request->name;
                $usuario->email  = $request->email;
                $usuario->login  = $request->login;
                $usuario->tipo   = $request->tipo;
                $usuario->password = Hash::make("123456");
                $usuario->primeiro = "S";
                $usuario->ativo  = 'A';
                $usuario->save();

            } catch (\Exception $e) {
                log::Debug('ERRO: '.$e->getMessage());
                return response()->json(['code'=>'401', 'erros'=>array(Config::get('app.messageError'))] );
            }
        }
        return response()->json(['code'=>'200']);
    }

    public function delete(Request $request)
    {
        try {
            DB::table('boletos')->where('id', '=', $request->id)->delete();
            DB::table('usuario')->where('id', '=', $request->id)->delete();
        } catch (\Exception $e) {
            log::Debug('ERRO: '.$e->getMessage());
        }
        return redirect($request->header('referer'));
    }    


    public function perfil(Request $request) 
    {
        return view('auth.passwords.update');
    }    


    public function password(Request $request) 
    {

        $validator = Validator::make( $request->all(), [
            'senha'        => 'required|min:8|required_with:senhaConfirm|same:senhaConfirm', 
            'senhaConfirm' => 'required',
        ],[],[
            'senha'        => 'Senha',
            'senhaConfirm' => 'Confirmação de Senha',
        ]);
    

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('errors', $validator->messages());
        } else {  

            try {
                DB::table('usuario')
                ->where('id', '=', Auth::user()->id)
                ->update(['password' => Hash::make($request->senha)]);

            } catch (\Exception $e) {
                log::Debug($e->getMessage());
            }

            Auth::logout();
            return redirect('/');
        }
    }    

}