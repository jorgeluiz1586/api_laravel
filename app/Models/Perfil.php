<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $fillable = [
        'nome',
        'foto',
        'profissao',
        'descricao',
    ];

    public function rules()
    {
        return [
            'nome' => 'required',
            'profissao' => 'required',
            'descricao' => 'required',
        ];
    }
}
