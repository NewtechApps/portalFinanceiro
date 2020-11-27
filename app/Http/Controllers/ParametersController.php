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

    
use App\Services\eventLogServices;
class ParametersController extends Controller
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
        $param = DB::table('parameters')->get();
        return view('parameters')->with('param', $param);
    }


    public function update(Request $request) 
    {

        DB::table('parameters')
        ->where('name', '=', 'email')
        ->update(['value' => $request->email]);

        DB::table('parameters')
        ->where('name', '=', 'wsdlBoletos')
        ->update(['value' => $request->wsdlBoletos]);

        eventLogServices::create(Auth::user()->id, 'Alteração das Configurações do Portal realizada!');
        return redirect('/home');
    }    

}