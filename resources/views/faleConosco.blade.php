@extends('layouts.layoutPadrao')

@section('content')
{!! Form::open( array('id'=>'frm_conosco', 'action'=>'FaleConoscoController@enviar') ) !!}
{{ csrf_field() }}
<div class="container-fluid" style="margin-top: 7vh;">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card border border-dark rounded">
   
                <div class="card-header">Fale Conosco</div>

                <div class="card-body">
                <div class="col-md-12 border border-dark rounded pl-4 pr-4 pt-1 pb-3 ml-0">
                    <div class="form-row pl-3 pr-3">

                        <div class="col-md-12">
                        {!! Form::label("email", "E-mail", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::text("email", Auth::user()->email, ["class"=>"form-control", 'readonly']) !!}
                        </div>

                        <div class="col-md-12">
                        {!! Form::label("assunto", "Assunto:", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::text("assunto", null, ["class"=>"form-control"]) !!}
                        </div>

                        <div class="col-md-12">
                        {!! Form::label("descricao", "Descreva sua necessidade:", ["class"=>"col-form-label pl-0"]) !!}
                        {!! Form::textArea("descricao", null, ["class"=>"form-control", 'rows' => 4, 'cols' => 54, 'style' => 'resize:none']) !!}
                        </div>
                    </div>
                </div>
                </div>

               
                <div class="card-footer" style="background-color: white;">
                    <div class="row justify-content-end">
                    <button type="button" class="btn btn-sm btn-secondary mr-1" id="insert-canc-btn" onclick="window.location='{{ url("/home") }}' ">Cancelar</button>
                    <button type="button" class="btn btn-sm btn-secondary"      id="insert-conf-btn" onclick='javascript:$("#frm_conosco").submit();'>Enviar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}


<script type='text/javascript'>
$(document).ready(function(){
    $('#assunto').focus();
});
</script>

@endsection