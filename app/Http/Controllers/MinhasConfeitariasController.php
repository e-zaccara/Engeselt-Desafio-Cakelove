<?php

namespace App\Http\Controllers;

use App\Models\Confeitaria;
use App\Models\Produto;
use Illuminate\Http\Request;

class MinhasConfeitariasController extends Controller
{
    public function index()
    {
        return view('minhasconfeitarias.index');
    }

    //BUSCA CONFEITARIA E PRODUTOS RELACIONADOS PARA EDIÇÃO
    public function edit(string $id)
    {
        $confeitaria = Confeitaria::where('user_id', auth()->id())->findOrFail($id);
        $produtos = Produto::where('confeitaria_id', $confeitaria->id)->with('imagens')->get();
        return view('minhasconfeitarias.edit', compact('confeitaria', 'produtos'));
    }

    //SALVAR EDIÇÕES FEITAS NA CONFEITARIA
    public function update(Request $request, $id)
    {
        // BUSCA A CONFEITARIA A SER EDITADA
        $confeitaria = Confeitaria::find($id);

        //VERIFICAÇÃO CASO NÃO ENCONTRE CONFEITARIA
        if (!$confeitaria) {
            return response()->json(['error' => 'Confeitaria não encontrada'], 404);
        }

        try {
            // ATUALIZA TODOS OS CAMPOS INPUTS
            // OBS: FORMULÁRIO PRÉ-PREENCHIDO
            $confeitaria->nome = $request->input('nome');
            $confeitaria->ll = $request->input('ll');
            $confeitaria->endereco = $request->input('endereco');
            $confeitaria->end_numero = $request->input('end_numero');
            $confeitaria->cep = $request->input('cep');
            $confeitaria->telefone = $request->input('telefone');

            // VERIFICA O ENVIO DE UMA NOVA LOGO
            if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
                // APAGA A LOGO ANTIGO
                if ($confeitaria->logo && file_exists(public_path($confeitaria->logo))) {
                    unlink(public_path($confeitaria->logo));  // Remove a logo antiga
                }

                // CRIA O DIRETÓRIO DA LOGO, "CASO NÃO EXISTA"
                $confeitariaDir = public_path('images/' . $confeitaria->id);
                if (!file_exists($confeitariaDir)) {
                    mkdir($confeitariaDir, 0777, true);
                }

                // OBTÉM NOME ORIGINAL DA LOGO E ENVIA PARA O DIRETÓRIO
                $fileName = $request->file('logo')->getClientOriginalName();
                $request->file('logo')->move($confeitariaDir, $fileName);

                // ATUALIZA O CAMINHO DA LOGO NO BANCO DE DADOS
                $confeitaria->logo = 'images/' . $confeitaria->id . '/' . $fileName;
            }

            // SALVA AS ALTERAÇÕES
            $confeitaria->save();

            return response()->json(['message' => 'Atualização bem-sucedida'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar', 'message' => $e->getMessage()], 500);
        }
    }


}
