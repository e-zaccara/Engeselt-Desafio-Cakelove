@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @php
                    use App\Models\Confeitaria;
                    $confeitarias = Confeitaria::all();
                @endphp
                <div id="vue-cp" data-confeitarias='@json($confeitarias)'></div>
            </div>
        </div>
    </div>
@endsection
