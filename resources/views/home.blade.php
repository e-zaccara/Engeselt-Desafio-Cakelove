@extends('layouts.app')

@section('content')
    <!-- TOKEN CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="container">
        <header class="d-flex justify-content-center mb-2">
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="{{ Route('minhasconfeitarias') }}" class="nav-link">Minhas confeitarias</a></li>
            </ul>
        </header>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- CRIA VARIÁVEL DE PRUDUTOS COM IMAGENS RELACIONADAS-->
                @php
                    use App\Models\Produto;
                    $produtos = Produto::with('imagens')->get();
                @endphp

                <!-- RENDERIZA O VUE DE PRODUTOS E ENVIA A VARÍAVEL -->
                <div id="vue-pp" data-produtos='@json($produtos)'></div>
            </div>
        </div>
    </div>
@endsection
