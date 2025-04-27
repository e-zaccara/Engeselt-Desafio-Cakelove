@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="container px-4 px-lg-5">
                    <div class="row gx-4 gx-lg-5 align-items-center my-5">
                        <div class="col-lg-7"><img class="shadow img-fluid rounded mb-4 mb-lg-0"
                                src="../{{ $confeitaria->logo }}" alt="..." /></div>
                        <div class="col-lg-5">
                            <h2 class="font-weight-light">{{ $confeitaria->nome }}</h1>
                                <p>{{ $confeitaria->endereco }} | N° {{ $confeitaria->end_numero }}</p>
                                <p>Parceira desde {{ $confeitaria->created_at->format('d/m/Y') }}</p>
                                <a type="button" class="" data-bs-toggle="modal" data-bs-target="#modalMapa"
                                    data-lat="{{ strpos($confeitaria->ll, ',') !== false ? explode(',', $confeitaria->ll)[0] : '' }}"
                                    data-lng="{{ strpos($confeitaria->ll, ',') !== false ? explode(',', $confeitaria->ll)[1] : '' }}"
                                    data-nome="{{ $confeitaria->nome }}">
                                    Mostrar Mapa
                                </a><br>

                                <a class="btn btn-primary mt-2" href="tel:{{ $confeitaria->numero }}">Ligar
                                    ({{ $confeitaria->telefone }})</a>
                        </div>
                    </div>

                    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
                        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
                    <!-- BOOTSTRAP CSS -->
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
                    <!-- USO LOCALMENTE -->
                    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

                    <!-- Modal do mapa-->
                    <div class="modal fade" id="modalMapa" tabindex="-1" aria-labelledby="modalMapaLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered"> <!-- Centralizado -->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalMapaLabel">Localização</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Fechar"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="mapa" style="height: 400px; width: 100%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <h3 class="text-black m-0 mb-3">Produtos:</h3>
                    </div>

                    <div class="d-flex flex-wrap gap-3">
                        @foreach ($produtos as $produto)
                            @php
                                $imagem = $produto->imagens->first();
                            @endphp
                            <li class="list-unstyled">
                                <div class="card shadow-sm">
                                    @if ($imagem)
                                        <img src="{{ asset($imagem->caminho) }}" alt="Imagem Produto"
                                            style="max-width: 250px; max-height: 250px" @endif
                                        class="shadow" />
                                        <div class="card-body">
                                            <p class="card-text">
                                                {{ $produto->nome }}
                                            </p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                                                        data-bs-target="#modalProduto"
                                                        data-produto='@json($produto)'>Comprar  </button>
                                                </div>
                                                <small class="text-body-secondary">R$ {{ $produto->valor }}</small>
                                            </div>
                                        </div>
                                </div>
                            </li>
                        @endforeach
                    </div>
                </div>
            </div>




            <!-- Modal de Produto -->
            <div class="modal fade" id="modalProduto" tabindex="-1" aria-labelledby="modalProdutoLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalProdutoLabel">Detalhes do Produto</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex justify-content-between align-items-top">
                                <div class="me-3">
                                    <div id="carouselProduto" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner" id="carouselProdutoImages"></div>
                                        <button class="carousel-control-prev" type="button"
                                            data-bs-target="#carouselProduto" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon"></span>
                                        </button>
                                        <button class="carousel-control-next" type="button"
                                            data-bs-target="#carouselProduto" data-bs-slide="next">
                                            <span class="carousel-control-next-icon"></span>
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <p><strong>Descrição:</strong> <span id="produtoDescricao"></span></p>
                                    <p><strong>Valor:</strong> R$ <span id="produtoValor"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary">Comprar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
