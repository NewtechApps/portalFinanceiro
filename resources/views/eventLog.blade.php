@extends('layouts.layoutPadrao')

@section('header')

    {!! Form::open(['method'=>'get']) !!}
    <nav class="navbar navbar-expand-sm navbar-light bg-light">    
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto font-weight-bold pl-2">
                <li><span class="linhaMestra">Logs de Eventos do Portal</span></li>                
            </ul>

            <ul class="navbar-nav input-group input-group-sm col-md-3">
                <div class="input-group">
                    <input id="search" class="form-control" name="search" value="{{ request('search') }}" type="text" 
                    placeholder="Pesquisar..." onkeydown="javascript:if(event.keyCode==13){ $('#search_btn').click(); };" aria-label="Search"/>
                    
                    <div class="input-group-append">
                        <button type="submit" id="search_btn" class="btn btn-sm btn-light"><i class="fas fa-search"></i></button>
                        <input  type="hidden" value="{{request('field')}}" id="field" name="field"/>
                        <input  type="hidden" value="{{request('sort')}}"  id="sort"  name="sort"/>
                        <button type="button" class="btn btn-sm btn-light" data-toggle="modal" data-target="#filtro" title="Filtrar" 
                                style="border-radius: 0.25rem;"><i class="fas fa-filter"></i></button> 
                    </div>
                </div>
            </ul>
        </div>
    </nav>
    @include('eventLogFiltro')
    {!! Form::close() !!}

@endsection


@section('content')
<div class="container-fluid pt-1 pb-2">
    <div id="main-table" class="table-responsive border border-dark rounded pb-0 pt-0 pr-0 pl-0" style='background: white'>
        <table class="table table-hover table-sm table-striped tablesorter mb-0">
            <thead class="thead-dark">
            <tr>
                <th></th>
                <th><a class="linktd" href='#' onClick="tablesorter('data_log');">Data</a></th>
                <th><a class="linktd" href='#' onClick="tablesorter('name');">Usuário</a></th>
                <th>Ação</th>
                <th></th>
            </tr>
            </thead>

            <tbody>     
                @foreach($events as $event)
                <tr>
                    <td></td>
                    <td style="min-width: 200px;">{{ date('d/m/Y H:m:s', strtotime($event->data_log)) }}</td>
                    <td style="min-width: 200px;">{{ $event->name }}</td>
                    <td>{{ $event->mensagem }}</td>
                    <td></td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div> 
</div> 



<script type='text/javascript'>
$('#search').focus();
$('#main-table').height((window.innerHeight*0.75)+"px");

$('#filtro').on('shown.bs.modal', function(e) {
    $('#dataEventosDe').focus(); 
});   


function tablesorter( $field )
{
	$sort = $('#sort').val();
	$('#field').val($field);
	$('#sort').val( $sort=='asc'?'desc':'asc' );
	$('#search_btn').click();
}

</script>
@endsection
