<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\Usuario;  
use App\Notifications\FaleConosco;
use App\Services\eventLogServices;
class FaleConoscoController extends Controller
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
        return view('faleConosco');
    }


    public function enviar(Request $request) 
    {
        $param = DB::table('parameters')->where('name', '=', 'email')->first();
        $user =  Usuario::where('email', '=', $param->value )->first();
        $user->notify( new FaleConosco($request->all()) );

        return response()->json(['code'=>'200']);
    }    

}