@extends('layouts.layoutPadrao')

@section('header')
    {!! Form::open(['method'=>'get']) !!}
    <nav class="navbar navbar-expand-sm navbar-light bg-light pl-4">    
        <a class='fas fa-plus' title="Adicionar Registro" id="addRegister" href="#" onclick="$('#insert').modal('show')"></a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto font-weight-bold pl-2">
                <li><span class="linhaMestra">Usuários</span></li>                
            </ul>

            <form class="form-inline my-2 my-lg-2">
            <ul class="navbar-nav input-group input-group-sm col-md-6">
                {!! Form::label("status" , "Status",["class"=>"col-form-label col-md-2 offset-md-2 text-right"]) !!}
                {!! Form::select('status', ['S'=>'Ativo', 'N'=>'Inativo', 'A'=>'Ambos'], request('status') ? request('status') :'0', 
                    ['class'=>'form-control col-md-2', 
                    'style'=>"border-top-right-radius: 0.25rem; border-bottom-right-radius: 0.25rem;", 
                    "onchange"=>"$('#search_btn').click();" ]) !!}
                <div class="input-group-append col-md-6 pr-0">

                    <input id="search" class="form-control" name="search" value="{{ request('search') }}" type="text" 
                    placeholder="Pesquisar..." onkeydown="javascript:if(event.keyCode==13){ $('#search_btn').click(); };" aria-label="Search"/>
                    <button type="submit" id="search_btn" class="btn btn-sm btn-light"><i class="fas fa-search"></i></button>
                    <input type="hidden" value="{{request('field')}}" id="field" name="field"/>
                    <input type="hidden" value="{{request('sort')}}"  id="sort"  name="sort"/>
                </div>
            </ul>
            </form>
        </div>
    </nav>
    {!! Form::close() !!}
@endsection


@section('content')
<div id="main" class="container-fluid pt-2 pb-5">
    <div id="list" class="row border border-dark rounded pb-1" style='background: white'>
        <div class="table-responsive col-md-12">
            <table class="table table-hover table-sm table-striped tablesorter mb-0" cellspacing="0" cellpadding="0">
                <thead class="thead-dark">
                <tr>
                    <th><a class="linktd" href='#' onClick="tablesorter('id');">Código</a></th>
                    <th><a class="linktd" href='#' onClick="tablesorter('login');">Login</a></th>
                    <th><a class="linktd" href='#' onClick="tablesorter('name');">Nome</a></th>
                    <th><a class="linktd" href='#' onClick="tablesorter('email');">E-mail</a></th>
                    <th><a class="linktd">Status</a></th>
                    <th class="text-right"></th>
                </tr>
                </thead>

                <tbody>     
                    @foreach($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->id }}</td>
                        <td>{{ $usuario->login }}</td>
                        <td>{{ $usuario->name }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td>{{ $usuario->ativo=='N' ? "Inativo" : "Ativo" }}</td>
                        <td class="text-right" style="vertical-align: middle">
                        <form id="frm_del_usuario_{{ $usuario->id }}" action="{{ url('usuarios/delete') }}" method="post">
    
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <input name="id_usuario" id="id_usuario" value="{{ $usuario->id }}" type="hidden"></input>                
                            <a class='fas fa-eraser' title="Deletar" href="#delete" data-toggle="modal" data-codigo   ="{{ $usuario->id }}"
                                                                                                        data-descricao="{{ $usuario->name }}"></a>
                        </form>
                        </td>

                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div> 
</div> 



<div class="modal fade" id="delete">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" role='document'>
            <div class="modal-header pl-4">
                <span class="linhaMestra" class="modal-title" id="modal-title">Exclusão de Registro!</span>
            </div>
            <div class="modal-body pl-4">
                <div class="row col-md-12" id="intro">
                    Você tem certeza que deseja excluir o registro?
                </div>
                <div class="row col-md-12" id="description"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-sm btn-secondary" id="delete-btn" >Excluir</button>
            </div>
        </div>
    </div>
</div>



{!! Form::open( array('id'=>'frm_incUsuario') ) !!}
<div class="modal fade" id="insert">
   <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" role='document'>
            <div class="modal-header">
                <span class="linhaMestra" class="modal-title font-weight-bold" id="modal-title">Inserir Usuário</span>
            </div>

            <div class="modal-body">
                <div class="col-md-12 border border-dark rounded pl-4 pr-4 pt-1 pb-3 ml-0">
                        
                    <div class="form-row col-md-12 pl-3 pr-3">
                        <div class="col-md-8">
                        {!! Form::label("name", "Nome", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::text("name",  null,   ["class"=>"form-control", "maxLength"=>"255" ]) !!}
                        </div>

                        <div class="col-md-4">
                        {!! Form::label("login", "Login", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::text("login",     null, ["class"=>"form-control", "maxLength"=>"20" ]) !!}
                        </div>

                        <div class="col-md-8">
                        {!! Form::label("email", "E-mail", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::email("email",  null, ["class"=>"form-control",  "maxLength"=>"255" ]) !!}
                        </div>

                        <div class="col-md-4">
                        {!! Form::label("tipo","Tipo de Usuário",["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::select('tipo', ['A'=>'Administrador','C'=>'Cliente'], "C", ['class'=>'form-control']) !!}
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <span colspan='10' id='erros' style="color: red; font-weight: bold; padding-right: 2rem;"></span>
                <button type="button" class="btn btn-sm btn-secondary" id="insert-canc-btn" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-sm btn-secondary" id="insert-conf-btn" onclick='gravaUsuario();'>Salvar</button>
            </div>
        </div>
    </div>

</div>
{!! Form::close() !!}



<script type='text/javascript'>

    $(document).ready(function(){

        $('#search').focus();
        $('#insert').on('shown.bs.modal', function(e) {
        $('#name').focus();
        });

        $('#delete').on('show.bs.modal', function(e) {
            var codigo   = $(e.relatedTarget).data("codigo");
            var descricao= $(e.relatedTarget).data("descricao");

            $('#delete').find("#description").html('Usuário: '+codigo+' - '+descricao);
            $('#delete').find("#delete-btn").attr('onclick',"javascript: $('#frm_del_usuario_"+codigo+"').submit()");
        });   
    });


    function gravaUsuario(){
        
        $.ajax({
            url: 'usuarios/create',
            type: 'POST',
            data: $('#frm_incUsuario').serialize(),
            success: function(response){

                if(response.code=='200'){   
                    $('#insert').modal('hide');
                    location.reload();            
                } else {
                    $.each(response.erros, function (index) {
                        $('#insert #erros').css("color", 'red');
                        $('#insert #erros').html(response.erros[index]);
                        return false;
                    });
                }
            }
        });
    };


</script>
@endsection