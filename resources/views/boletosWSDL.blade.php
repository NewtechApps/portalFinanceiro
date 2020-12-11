@extends('layouts.layoutPadrao')

@section('header')

    {!! Form::open(['method'=>'get']) !!}
    <nav class="navbar navbar-expand-sm navbar-light bg-light">    
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto font-weight-bold pl-2">
                <li><span class="linhaMestra">Listagem de Boletos</span></li>                
            </ul>

            <form class="form-inline my-2 my-lg-2">
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
            </form>
        </div>
    </nav>
    @include('boletosFiltro')
    {!! Form::close() !!}

@endsection


@section('content')
<div class="container-fluid pt-2 pb-2">
    <div id="main-table" class="table-responsive border border-dark rounded pb-0 pt-0 pr-0 pl-0" style='background: white'>
        <table class="table table-hover table-sm table-striped tablesorter mb-0">
            <thead class="thead-dark">
            <tr>
                <th></th>
                <th><a class="linktd" href='#' onClick="tablesorter('empresa');">Empresa</a></th>
                <th><a class="linktd" href='#' onClick="tablesorter('CNPJ');">CNPJ</a></th>
                <th><a class="linktd" href='#' onClick="tablesorter('cidade');">Município</a></th>
                <th><a class="linktd" href='#' onClick="tablesorter('estado');">UF</a></th>
                <th><a class="linktd" href='#' onClick="tablesorter('titulo');">Nr.Título</a></th>
                <th><a class="linktd" href='#' onClick="tablesorter('emissao');">Data Emissão</a></th>
                <th><a class="linktd" href='#' onClick="tablesorter('vencimento');">Data Vencto.</a></th>
                <th><a class="linktd" href='#' onClick="tablesorter('prorrogacao');">Novo Vencto.</a></th>
                <th class="text-right">Valor Original</th>
                <th class="text-right">Saldo</th>
                <th class="text-right">Valor Boleto</th>
            </tr>
            </thead>

            <tbody>     
                @foreach($boletos['RetornaBoletos'] as $boleto)
                <tr>
                    <td><a class='fas fa-print' title="Imprimir" href="#" target="_blank"></a>
                    <td>{{ $boleto['nome_cliente'] }}</td>
                    <td>{{ $boleto['cnpj_cliente'] }}</td>
                    <td></td>
                    <td></td>
                    <td>{{ $boleto['titulo'].'/'.$boleto['parcela'] }}</td>
                    <td>{{ $boleto['data_boleto'] }}</td>
                    <td>{{ $boleto['data_vencimento'] }}</td>
                    <td></td>
                    <td class="text-right">{{ 'R$ '.$boleto['val_original'] }}</td>
                    <td class="text-right">{{ 'R$ '.number_format( 0, 2, ',', '.') }}</td>
                    <td class="text-right">{{ 'R$ '.$boleto['val_calculado'] }}</td>
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
    $('#dataTituloDe').focus(); 
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
