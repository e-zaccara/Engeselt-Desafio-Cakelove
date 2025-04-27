<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = [
        'confeitaria_id',
        'nome',
        'descricao',
        'valor'
    ];

    // PRODUTO SE RELACIONA COM CONFEITARIA
    public function confeitaria()
    {
        return $this->belongsTo(Confeitaria::class);
    }

    // RELACIONA IMAGENS COM PRODUTO
    public function imagens()
    {
        return $this->hasMany(ProdutoImagem::class);
    }
}
