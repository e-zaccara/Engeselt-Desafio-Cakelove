<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\ProdutoImagem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProdutoController extends Controller
{
    public function index()
    {
        return view('produtosparceiros.index');
    }
    public function store(Request $request)
    {
        // VALIDAÇÃO DO FORMULÁRIO
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string|max:500',
            'valor' => 'required|numeric',
            'imagens' => 'nullable|array|max:5', // PERMITE ATÉ 5 IMAGENS
            'imagens.*' => 'mimes:jpeg,png,jpg,gif|max:2048', // RESTRIÇÃO DE FORMATOS E TAMANHO DE IMAGEM
            'confeitaria_id' => 'required|exists:confeitarias,id' // VALIDAÇÃO PARA GARANTIR QUE O ID DA CONFEITARIA SEJÁ VALIDO
        ]);

        //RETORNO CASO HOUVER ERRO EM ALGUMA VALIDAÇÃO
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            // CRIAÇÃO DO PRODUTO NO BANCO DE DADOS
            $produto = Produto::create([
                'nome' => $request->nome,
                'descricao' => $request->descricao,
                'valor' => $request->valor,
                'confeitaria_id' => $request->confeitaria_id,
            ]);

            // SE HOUVER IMAGENS, FAZ O UPLOAD DELAS
            if ($request->hasFile('imagens')) {
                foreach ($request->file('imagens') as $imagem) {
                    // DEFINE O DIRETÓRIO DE ONDE AS IMAGENS SERAM SALVAS
                    $directory = public_path('images/' . $request->confeitaria_id . '/produto');

                    // VERIFICA EXISTÊNCIA DA PASTA, SE NÃO EXISTIR, CRIA
                    if (!file_exists($directory)) {
                        mkdir($directory, 0777, true);  // Cria as pastas necessárias
                    }

                    // DEFINE O NOME DO ARQUIVO
                    $imageName = time() . '-' . $imagem->getClientOriginalName(); // Nome único para a imagem

                    // MOVE A PASTA
                    $imagem->move($directory, $imageName);

                    // DEFINE O CAMINHO COMPLETO DA IMAGEM
                    // OBS: CAMINHO QUE SERÁ SALVO NO BANCO DE DADOS
                    $path = 'images/' . $request->confeitaria_id . '/produto/' . $imageName;

                    // CRIAÇÃO DO RELACIONAMENTO COM A TABELA PRODUTO_IMAGENS
                    ProdutoImagem::create([
                        'produto_id' => $produto->id,
                        'caminho' => $path, // * CAMINHO DA IMAGEM ARMAZENADO NO BANCO DE DADOS
                    ]);
                }
            }

            // RETORNO DE SUCESSO
            return redirect()->back()->with('success', 'Produto criado com sucesso!');

        } catch (\Exception $e) {
            // RETORNO CASO HOUVER ERRO
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            // BUSCA O PRODUTO
            $produto = Produto::findOrFail($id);

            // DELETA IMAGENS ASSOCIADAS
            foreach ($produto->imagens as $imagem) {
                // DELETA ARQUIVO FÍSICO
                $caminhoImagem = public_path($imagem->caminho);
                if (file_exists($caminhoImagem)) {
                    unlink($caminhoImagem); // DELETA O ARQUIVO DA PASTA
                }

                // DELETA O REGISTRO DA IMAGEM NO BANCO DE DADOS
                $imagem->delete();
            }

            // DELETA O PRODUTO
            $produto->delete();

            // RETORNO DE SUCESSO
            return redirect()->back()->with('success', 'Produto deletado com sucesso!');

        } catch (\Exception $e) {
            // RETORNO CASO HOUVER ERRO
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


}
