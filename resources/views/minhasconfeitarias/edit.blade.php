@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="container px-4 px-lg-5">
                    <div class="row gx-4 gx-lg-5 align-items-center my-5">
                        <div class="col-lg-7"><img class="shadow img-fluid rounded mb-4 mb-lg-0"
                                src="{{ asset($confeitaria->logo) }}" alt="..." /></div>
                        <div class="col-lg-5">
                            <h2 class="font-weight-light">{{ $confeitaria->nome }}</h1>
                                <p>{{ $confeitaria->endereco }} | N° {{ $confeitaria->end_numero }}</p>
                                <p>Parceira desde {{ $confeitaria->created_at->format('d/m/Y') }}</p>
                                <p>Em breve {{ $confeitaria->ll }}</p>
                                <a class="btn btn-primary" href="tel:{{ $confeitaria->numero }}">Ligar
                                    ({{ $confeitaria->telefone }})</a>
                                <a class="ms-5" style="color: black" href="#" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                        <path
                                            d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3" />
                                    </svg>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#"
                                            onclick="abrirModalComDados({{ Js::from($confeitaria) }})">Editar</a></li>
                                    <li><a class="dropdown-item" href="#"
                                            onclick="event.preventDefault(); document.getElementById('form-delete-{{ $confeitaria->id }}').submit();">Excluir</a>
                                    </li>
                                    <form id="form-delete-{{ $confeitaria->id }}"
                                        action="{{ route('confeitarias.destroy', $confeitaria->id) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </ul>
                        </div>
                    </div>
                    <div class="card text-white bg-secondary my-5 py-4 text-center">
                        <div class="card-body">
                            <a id="openModalBtn" class="btn btn-outline-light">Adicionar produto</a>
                            <a onclick="abrirModalComDados({{ Js::from($confeitaria) }})"
                                class="btn btn-outline-light mx-2 my-3 my-md-0">
                                Editar informações
                            </a>
                            <a href="{{ route('confeitariasparceiras.show', $confeitaria->id) }}"
                                class="btn btn-outline-light mx-2">
                                Visualizar confeitaria
                            </a>
                            <div id="vue-modal"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-5">
            <table class="table">
                <h5>Produtos:</h5>
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Descrição</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Editar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produtos as $produto)
                        <tr>
                            <td scope="row">{{ $produto->nome }}</td>
                            <td>{{ $produto->descricao }}</td>
                            <td>{{ $produto->valor }}</td>
                            <td><a style="color: black" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                        <path
                                            d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3" />
                                    </svg>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Editar</a></li>
                                    <li><a class="dropdown-item" href="#"
                                            onclick="event.preventDefault(); document.getElementById('form-delete-{{ $produto->id }}').submit();">Excluir</a>
                                    </li>
                                    <form id="form-delete-{{ $produto->id }}"
                                        action="{{ route('produtos.destroy', $produto->id) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <th scope="row">Total de produtos:</th>
                        <td colspan="2"></td>
                        <td class="valorG">{{ count($produtos) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>



        <div id="modalProduto" class="modal fade show d-none" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5)"
            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-3">
                    <div class="modal-header">
                        <h5 class="modal-title">Cadastrar produto</h5>
                        <button type="button" class="btn-close" id="closeModalBtn" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ Route('produtos.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <input name="nome" type="text" class="form-control" placeholder="Nome do produto"
                                    required />
                            </div>

                            <div class="mb-3">
                                <input name="descricao" type="text" class="form-control"
                                    placeholder="Descrição do produto" required />
                            </div>
                            <div class="mb-3">
                                <input name="valor" type="text" class="form-control" placeholder="Valor do produto"
                                    required />
                            </div>
                            <input type="hidden" name="confeitaria_id" value="{{ $confeitaria->id }}">
                            <div class="mb-3">
                                <label class="form-label">Imagens</label>
                                <input name="imagens[]" type="file" class="form-control" multiple required />
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Cadastrar</button>
                                <button type="button" class="btn btn-secondary" id="closeModalBtn2">Fechar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            // SELECIONA VARIAVEL COM OS ELEMENTOS RELACIONADOS
            const openModalBtn = document.getElementById('openModalBtn');
            const modalProduto = document.getElementById('modalProduto');
            const closeModalBtns = document.querySelectorAll('#closeModalBtn, #closeModalBtn2');

            // FUNÇÃO PARA ABRIR MODAL
            openModalBtn.addEventListener('click', () => {
                modalProduto.classList.remove('d-none');
                modalProduto.classList.add('d-block');
            });

            // FUNÇÃO PARA FECHAR MODAL
            closeModalBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    modalProduto.classList.add('d-none');
                    modalProduto.classList.remove('d-block');
                });
            });
        </script>
    </div>
@endsection
