@extends('layouts.app')

@section('content')
    <!-- TOKEN CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        use App\Models\Confeitaria;
        $possuiConfeitarias = Confeitaria::where('user_id', auth()->id())->exists();
        $confeitarias = Confeitaria::where('user_id', auth()->id())->get();
    @endphp

    <div class="container">
        <header class="d-flex justify-content-center mb-2">
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="{{ Route('minhasconfeitarias') }}" class="nav-link">Minhas confeitarias</a></li>
                @if ($confeitarias->isNotEmpty())
                    <li class="nav-item"><a href="#" class="nav-link" onclick="abrirModalLogin()">Nova confeitaria</a></li>
                    <div id="vue-modal"></div>
                @else
                
                @endif
            </ul>
        </header>
    </div>

    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-8">

                <!-- VERIFICA SE O USUARIO POSSUI CONFEITARIAS -->
                @if ($confeitarias->isNotEmpty())
                    <!-- CASO TENHA CONFEITARIAS -->
                    <div id="vue-mc" data-confeitarias='@json($confeitarias)'></div>
                @else
                    <!-- CASO NÃO TENHA CONFEITARIAS -->
                    <!-- CADASTRAR LOJAS -> APLICAÇÂO DO VUE.JS | modalCadastro.vue -->
                    <div class="card">
                        <div class="card-header">Notificações</div>
                        <div class="card-body">
                            <p>Você não possui nenhuma confeitaria cadastrada. <a href="javascript:void(0);"
                                    onclick="abrirModalLogin()">Deseja criar uma?</a></p>
                        </div>
                        <div id="vue-modal"></div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
