<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\MasterApiController;
use Illuminate\Http\Request;
use App\Models\Image;

class ImageApiController extends MasterApiController
{
    protected $model;
    protected $path = 'static';
    protected $upload = 'image';
    protected $width = 1365;
    protected $height = 658;

    public function __construct(Image $image, Request $request)
    {
        $this->model = $image;
        $this->request = $request;
    }

    public function Post($id)
    {
        if (!$data = $this->model->with('post')->find($id)) {
            return response()->json(['error', 'Nada foi encontrado'], 404);
        } else {
            return response()->json($data);
        }
    }
}
