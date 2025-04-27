<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Confeitaria extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'll',
        'cep',
        'endereco',
        'end_numero',
        'telefone',
        'logo',
        'user_id',
    ];

    // RELACIONA PRODUTO COM CONFEITARIA
    public function produtos()
    {
        return $this->hasMany(Produto::class, 'confeitaria_id');
    }
}
