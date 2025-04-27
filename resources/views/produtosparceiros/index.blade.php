@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @php
                    use App\Models\Produto;
                    $produtos = Produto::with('imagens')->get();
                @endphp
                <div id="vue-pp" data-produtos='@json($produtos)'></div>
            </div>
        </div>
    </div>
    
@endsection
