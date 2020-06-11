<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\MasterApiController;
use Illuminate\Http\Request;
use App\Models\Perfil;

class PerfilApiController extends MasterApiController
{

    protected $model;
    protected $path = 'static';
    protected $upload = 'image';
    protected $width = 150;
    protected $height = 150;
    protected $totalPage = 20;

    public function __construct(Perfil $perfil, Request $request)
    {
        $this->model = $perfil;
        $this->request = $request;
    }

    public function index()
    {
        $data = $this->model->paginate($this->totalPage);
        return response()->json($data);
    }
}
