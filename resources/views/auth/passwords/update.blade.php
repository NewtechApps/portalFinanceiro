@extends('layouts.layoutPadrao')

@section('content')
{!! Form::open( array('id'=>'frm_perfil', 'action'=>'UsersController@password') ) !!}
{{ csrf_field() }}
<div class="container-fluid" style="margin-top: 10vh;">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card border border-dark rounded">
   
                <div class="card-header">Perfil de Usuário</div>

                <div class="card-body">
                <div class="col-md-12 border border-dark rounded pl-4 pr-4 pt-1 pb-3 ml-0">
                    <div class="form-row pl-3 pr-3">

                        <div class="col-md-12">
                        {!! Form::label("nome", "Nome", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::text("nome",  Auth::user()->name, ["class"=>"form-control", "readonly" ]) !!}
                        </div>

                        <div class="col-md-12">
                        {!! Form::label("email", "E-mail", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::text("email",  Auth::user()->email, ["class"=>"form-control", "readonly" ]) !!}
                        </div>

                        <div class="col-md-6">
                        {!! Form::label("senha", "Nova Senha", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::password("senha", ["class"=>"form-control" ]) !!}
                        @if ($errors->has('senha'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('senha') }}
                            </span>
                        @endif
                        </div>

                        <div class="col-md-6">
                        {!! Form::label("senhaConfirm", "Confirmação de Senha", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::password("senhaConfirm", ["class"=>"form-control" ]) !!}
                        @if ($errors->has('senhaConfirm'))
                            <span colspan='12' style="color: red;">
                                {{ $errors->first('senhaConfirm') }}
                            </span>
                        @endif
                        </div>

                    </div>
                </div>
                </div>

               
                <div class="card-footer" style="background-color: white;">
                    <div class="row justify-content-end">
                    <button type="button" class="btn btn-sm btn-secondary mr-1" id="insert-canc-btn" onclick="window.location='{{ url("/home") }}' ">Cancelar</button>
                    <button type="button" class="btn btn-sm btn-secondary"      id="insert-conf-btn" onclick='javascript:$("#frm_perfil").submit();'>Salvar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}

<script type='text/javascript'>
$(document).ready(function(){
    $('#senha').focus();
});
</script>
@endsection