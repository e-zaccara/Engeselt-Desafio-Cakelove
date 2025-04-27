<?php

use App\Http\Controllers\MinhasConfeitariasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConfeitariaController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ROTAS RELACIONADAS A CRIAÇÃO E GERENCIAMENTO DAS CONFEITARIAS
Route::post('/cadastroconfeitarias', [ConfeitariaController::class, 'store']);
Route::get('/minhasconfeitarias', [App\Http\Controllers\MinhasConfeitariasController::class, 'index'])->middleware('auth')->name('minhasconfeitarias');
Route::put('/minhasconfeitarias/edit/{id}', [MinhasConfeitariasController::class, 'update'])->name('confeitaria.update');
Route::get('/minhasconfeitarias/edit/{id}', [MinhasConfeitariasController::class, 'edit'])->name('confeitarias.edit')->middleware('auth');
Route::delete('/confeitarias/excluir/{id}', [ConfeitariaController::class, 'destroy'])->name('confeitarias.destroy');

// ROTAS RELACIONADAS A VISUALIZAÇÃO DE CONFEITARIAS
Route::get('/confeitariasparceiras', [App\Http\Controllers\ConfeitariasParceirasController::class, 'index'])->name('confeitariasparceiras');
Route::get('/confeitariasparceiras/{id}', [App\Http\Controllers\ConfeitariasParceirasController::class, 'show'])->name('confeitariasparceiras.show');


// ROTAS RELACIONADAS A PRODUTOS
Route::get('/produtos', [App\Http\Controllers\ProdutoController::class, 'index'])->name('produtos');
Route::post('/cadastroprodutos', [App\Http\Controllers\ProdutoController::class, 'store'])->name('produtos.store');
Route::delete('/produtos/remover/{id}', [App\Http\Controllers\ProdutoController::class, 'destroy'])->name('produtos.destroy');
