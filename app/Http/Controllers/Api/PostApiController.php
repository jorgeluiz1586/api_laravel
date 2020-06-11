<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\MasterApiController;
use Illuminate\Http\Request;
use App\Models\Post;

class PostApiController extends MasterApiController
{

    protected $model;
    protected $path = 'static';
    protected $upload = 'capa';
    protected $width = 375;
    protected $height = 234;
    protected $totalPage = 20;

    public function __construct(Post $post, Request $request)
    {
        $this->model = $post;
        $this->request = $request;
    }

    public function index()
    {
        $data = $this->model->paginate($this->totalPage);
        return response()->json($data);
    }

    public function image($id)
    {
        if (!$data = $this->model->with('image')->find($id)) {
            return response()->json(['error', 'Nada foi encontrado'], 404);
        } else {
            return response()->json($data);
        }
    }
}
