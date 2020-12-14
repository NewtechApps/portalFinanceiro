<!DOCTYPE html>
<html>
    <head>

        <meta charset="UTF-8">
        <title>{{ config('app.name') }} - Login</title> 

        <link rel='icon' href="{{ asset('images/favicon.png') }}">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/padrao.css') }}">
        <script src="{{ asset('js/app.js') }}" defer></script>

        <style>
            html, body {

                padding-bottom: 0rem;
                background-image: url("../../images/telafundo.png");
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;

                background-size: cover;
                background-repeat: no-repeat;
                background-position: bottom;
                background-attachment: fixed;

            }
        </style>   
    </head>

    <body>
    <div id="app">

        <div class="container-fluid" style="margin-top: 23vh;">
        <div class="row justify-content-center">

            <div class="card border border-dark rounded" style="width: 23rem;">
                <form method="POST" action="{{ route('password.update') }}">
                @csrf

                    <div class="card-header pl-5 pr-5">{{ __('Portal Financeiro - Cadastrar Senha') }}</div>
                    <div class="card-body pb-4 pl-5 pr-5">

                        <div class="form-row col-md-12">

                            <div class="col-md-12">
                            <input type="hidden" name="token" value="{{ $token }}">
                            {!! Form::label("email","E-mail" , ["class"=>"col-form-label pl-0"]) !!}
                            {!! Form::email("email", "$email", ["class"=>"form-control", "readonly" ]) !!}
                            </div>

                            <div class="col-md-12">
                            {!! Form::label("password", "Senha" , ["class"=>"col-form-label pl-0"]) !!}
                            {!! Form::password("password", ["class"=>"form-control",  "autofocus" ]) !!}
                            @if ($errors->has('password'))
                                <span colspan='12' style="color: red;">
                                    {{ $errors->first('password') }}
                                </span>
                            @endif
                            </div>

                            <div class="col-md-12">
                            {!! Form::label("password-confirm", "Confirmação de Senha" , ["class"=>"col-form-label pl-0"]) !!}
                            {!! Form::password("password-confirm", ["class"=>"form-control" ]) !!}
                            </div>

                        </div>
                    </div>
                        
                    <div class="card-footer pl-5 pr-5">
                        <div class="col-md-12">
                        <button type="submit" class="btn btn-sm btn-secondary" style="width: 100px;">Cadastrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('layouts\footer')

</div>
</body>
</html>
