<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Confeitaria;
use Illuminate\Support\Facades\File;

class ConfeitariaController extends Controller
{
    public function store(Request $request)
    {
        // VALIDAÇÃO DO FORMULÁRIO
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'll' => 'required|string',
            'cep' => 'required|string',
            'endereco' => 'string',
            'end_numero' => 'required|string',
            'telefone' => 'required|string',
            'logo' => 'nullable|file|image|max:2048',  // VALIDAR LOGO COMO ARQUIVO DE IMAGEM
            'user_id',
        ]);

        // RELACIONA CONFEITARIA COM USUÁRIO LOGADO
        $validated['user_id'] = auth()->id();

        // CRIAÇÃO DA CONFEITARIA
        $confeitaria = Confeitaria::create($validated);

        // VERIFICA E TRATA A LOGO | CRIA PASTA E IMAGES E DIRETÓRIO DE IMAGENS DA CONFEITARIA
        if ($request->hasFile('logo')) {
            $confeitariaDir = public_path('images/' . $confeitaria->id);

            if (!file_exists($confeitariaDir)) {
                mkdir($confeitariaDir, 0777, true);
            }
            $fileName = $request->file('logo')->getClientOriginalName();
            $request->file('logo')->move($confeitariaDir, $fileName);
            $confeitaria->logo = 'images/' . $confeitaria->id . '/' . $fileName;
            $confeitaria->save();
        }


        // RETORNO APOS CADASTRO
        return response()->json(['message' => 'Cadastro bem-sucedido'], 200);
    }

    public function destroy($id)
    {
        try {
            // BUSCA A CONFEITARIA A SER DELETADA
            $confeitaria = Confeitaria::findOrFail($id);

            // DELETA PRODUTOS E IMAGENS ASSOCIADAS
            foreach ($confeitaria->produtos as $produto) {
                foreach ($produto->imagens as $imagem) {
                    // DELETA ARQUIVO FÍSICO DA IMAGEM
                    $imagemPath = public_path($imagem->caminho);
                    if (file_exists($imagemPath)) {
                        unlink($imagemPath);
                    }

                    // DELETA REGISTRO DE IMAGEM NO BANCO
                    $imagem->delete();
                }

                // DELETA PRODUTO
                $produto->delete();
            }

            // DELETA IMAGEM FíSICA DA CONFEITARIA
            if ($confeitaria->logo) {
                $logoPath = public_path($confeitaria->logo);
                if (file_exists($logoPath)) {
                    unlink($logoPath);
                }
            }

            // DELETA A PASTA DA CONFEITARIA
            $confeitariaFolder = public_path('images/' . $confeitaria->id);
            if (File::exists($confeitariaFolder)) {
                File::deleteDirectory($confeitariaFolder);
            }

            // DELETA A CONFEITARIA
            $confeitaria->delete();

            return redirect()->route('minhasconfeitarias')->with('success', 'Confeitaria, produtos e imagens apagados com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao apagar a confeitaria: ' . $e->getMessage());
        }
    }


}

