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
                        <input type="hidden" value="{{request('field')}}" id="field" name="field"/>
                        <input type="hidden" value="{{request('sort')}}"  id="sort"  name="sort"/>
                    </div>
                </div>
            </ul>
            </form>
        </div>
    </nav>
    {!! Form::close() !!}

@endsection


@section('content')
<div class="container-fluid" style="margin-top: 20vh;">

    <div class="row justify-content-center">
        <div class="col-md-4">


        </div>
    </div>
</div>
@endsection