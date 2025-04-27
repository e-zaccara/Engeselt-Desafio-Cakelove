<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdutoImagem extends Model
{
    protected $table = 'produto_imagens';  // Corrigido aqui
    protected $fillable = [
        'produto_id',
        'caminho'
    ];

    // IMAGENS SE RELACIONA COM PRODUTO
    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
