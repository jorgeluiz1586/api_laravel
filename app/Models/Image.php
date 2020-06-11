<?php

namespace App\Models;

use App\Models\Post;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'id_post',
        'image'
    ];

    public function rules()
    {
        return [
            'id_post' => 'required',
            'image' => 'required'
        ];
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'id_post', 'id');
    }
}
