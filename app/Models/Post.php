<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Image;

class Post extends Model
{
    protected $fillable = [
        'categoria',
        'capa',
        'titulo',
        'video',
        'descricao',
        'link',
    ];

    public function rules()
    {
        return [
            'categoria' => 'required',
            'titulo' => 'required',
            'video' => 'required',
            'descricao' => 'required',
            'link' => 'required',
        ];
    }

    public function arquivo($id)
    {
        $data = $this->find($id);
        return $data->capa;
    }

    public function image()
    {
        return $this->hasOne(Image::class, 'id_post', 'id');
    }
}
