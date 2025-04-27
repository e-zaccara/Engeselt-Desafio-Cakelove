<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Confeitaria;

class ConfeitariasParceirasController extends Controller
{
    public function index()
    {
        return view('confeitariasparceiras.index');
    }

    public function show(string $id)
    {
        //BUSCA CONFEITARIA E PRODUTOS RELACIONADOS
        $confeitaria = Confeitaria::with('produtos')->find($id);

        //VERIFICA SE EXISTE CONFEITARIA COM ID
        if (!$confeitaria) {
            abort(404);
        }

        //RETORNA ARRAY COM CONFEITARIA E PRODUTOS RELACIONADOS
        return view('confeitariasparceiras.show', [
            'confeitaria' => $confeitaria,
            'produtos' => $confeitaria->produtos,
        ]);
    }


}
