@extends('layouts.layoutPadrao')

@section('content')
{!! Form::open( array('id'=>'frm_upd_param', 'action'=>'parametersController@update', ) ) !!}
{{ csrf_field() }}
<div class="container-fluid" style="margin-top: 10vh;">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card border border-dark rounded">
   
                <div class="card-header">Configurações do Portal</div>

                <div class="card-body">
                <div class="col-md-12 border border-dark rounded pl-4 pr-4 pt-1 pb-3 ml-0">
                    <div class="form-row pl-3 pr-3">

                        <div class="col-md-12">
                        {!! Form::label("email", "E-mail", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::text("email", $param[0]->value, ["class"=>"form-control", 'maxLength'=>'255']) !!}
                        </div>

                        <div class="col-md-12">
                        {!! Form::label("wsdlBoletos", "WSDL Boletos", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::text("wsdlBoletos", $param[1]->value, ["class"=>"form-control", 'maxLength'=>'255' ]) !!}
                        </div>

                        <!--
                        <div class="col-md-12">
                        {!! Form::label("imagemFundo", "Imagem de Fundo", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::file("imagemFundo", ["class"=>"form-control form-control-file pl-0 pr-0 pt-0 pb-0", "accept"=>"image/x-png,image/gif,image/jpeg" ]) !!}
                        </div>
                        -->

                    </div>
                </div>
                </div>

               
                <div class="card-footer" style="background-color: white;">
                    <div class="row justify-content-end">
                    <button type="button" class="btn btn-sm btn-secondary mr-1" id="insert-canc-btn" onclick="window.location='{{ url("/home") }}' ">Cancelar</button>
                    <button type="button" class="btn btn-sm btn-secondary"      id="insert-conf-btn" onclick='javascript:$("#frm_upd_param").submit();'>Salvar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}


<script type='text/javascript'>
    $(document).ready(function(){
        $('#email').focus();
    });
</script>

@endsection