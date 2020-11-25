<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
    
use App\Models\EventLog;
class eventLogController extends Controller
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
        $field  = $request->get('field')  != '' ? $request->get('field') : 'nomeContato';
        $sort   = $request->get('sort')   != '' ? $request->get('sort')  : 'asc';

        $codEstado    = $request->get('codEstado')    != '' ? $request->get('codEstado')    : '';
        $codMunicipio = $request->get('codMunicipio') != '' ? $request->get('codMunicipio') : '';
        $tipoContato  = $request->get('tipoContato')  != '' ? $request->get('tipoContato')  : '';
        $listaDivulgacao  = $request->get('listaDivulgacao')   != '' ? $request->get('listaDivulgacao')  : 'A';
        $informativoFeira = $request->get('informativoFeira')  != '' ? $request->get('informativoFeira') : 'A';
        

        $events = DB::table('contatos')->
                    select('contatos.*','municipios.*',
                        DB::raw('(SELECT COUNT(*) FROM wishlistprodutos where wishlistprodutos.idContato=contatos.idContato) as wishList')
                    )->leftjoin('municipios', function ($join) {
                            $join->on('contatos.codEstado'   , '=', 'municipios.codEstado')
                                    ->on('contatos.codMunicipio', '=', 'municipios.codMunicipio');
                    
                    })->where([
                        ['codEmpresa','=', Session::get('codEmpresa')],
                        ['nomeContato', 'like', '%' . $search . '%'],
                    ])
                    
                    ->where(function ($query) use ($tipoContato) {
                        if ($tipoContato){
                            $query->where('contatos.tipoContato', '=' , $tipoContato);
                        } 
                    })

                    ->where(function ($query) use ($codEstado) {
                        if ($codEstado){
                            $query->where('contatos.codEstado', '=' , $codEstado);
                        } 
                    })

                    ->where(function ($query) use ($codMunicipio) {
                        if ($codMunicipio){
                            $query->where('contatos.codMunicipio', '=' , $codMunicipio);
                        } 
                    })

                    ->where(function ($query) use ($informativoFeira) {
                        if ($informativoFeira=='N' || $informativoFeira=='S'){
                            $query->where('idConviteFeiras', '=' , $informativoFeira);
                        } 
                    })

                    ->where(function ($query) use ($listaDivulgacao) {
                        if ($listaDivulgacao=='N' || $listaDivulgacao=='S'){
                            $query->where('idListaDivulga', '=' , $listaDivulgacao);
                        } 
                    })

                    ->orderBy($field, $sort)
                    ->orderBy('nomeContato', 'asc')
                    ->get();

        return view("logs")->with('logs', $logs);
    }


}