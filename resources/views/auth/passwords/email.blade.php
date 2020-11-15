@include('layouts.padraoLogin')
<div class="container-fluid" style="margin-top: 20vh;">

    <div class="row justify-content-center">

        <div class="card border border-dark rounded" style="width: 25rem;">
            <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="card-header pl-5 pr-5">Portal Financeiro</div>
            <div class="card-body pb-4 pl-5 pr-5">

                <div class="form-row col-md-12">
                    <div class="col-md-12">
                    {{ __('Será enviado para o e-mail abaixo, um link para o cadastramento da sua nova senha.') }}
                    </div>

                    <div class="col-md-12 pt-2">
                    <input type="hidden" name="login" id="login" value="{{ $usuario->login }}">
                    {!! Form::text("email", $usuario->email, ["class"=>"form-control pt", "readonly"]) !!}
                    </div>
                </div>
            </div>

            <div class="card-footer pl-5 pr-5">
                <div class="col-md-12">
                <button type="submit" class="btn btn-sm btn-secondary" style="width: 100px;">Enviar Senha</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
