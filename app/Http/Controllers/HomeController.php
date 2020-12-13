<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleXMLElement;
use SoapClient;
use Carbon\Carbon;
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
            
            $boletos = DB::table('boletos')
                        ->where('id_usuario','=', Auth::user()->id)
                        ->orderBy('empresa', 'asc')
                        ->orderBy($field, $sort)
                        ->get();
            return view('boletos')->with('boletos', $boletos);

        }
    }


    public function getDownload()
    {
        //PDF file is stored under project/public/download/info.pdf
        $file= public_path(). "/downloads/info.pdf";
        $headers = array('Content-Type: application/pdf');
        return Response::download($file, 'titulo.pdf', $headers);
    }

}
