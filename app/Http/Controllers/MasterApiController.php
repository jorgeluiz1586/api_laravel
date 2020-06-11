<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Validator;

class MasterApiController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $data = $this->model->all();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->model->rules());

        $dataForm = $request->all();

        if ($request->has($this->upload) && strpos($dataForm[$this->upload], ';base64')) {
            $base64 = $dataForm[$this->upload];
            //obtem a extensão
            $extension = explode('/', $base64);
            $extension = explode(';', $extension[1]);
            $extension = '.' . $extension[0];
            //gera o nome
            $name = time() . $extension;
            //obtem o arquivo
            $separatorFile = explode(',', $base64);
            $file = $separatorFile[1];
            //envia o arquivo
            // Storage::put($this->path . $name, base64_decode($file));
            $upload = Image::make(base64_decode($file))->resize($this->width, $this->height)->save(storage_path("app/public/{$this->path}/{$name}", 70));

            if (!$upload) {
                return response()->json(['error' => 'Falha ao fazer upload'], 500);
            } else {
                $dataForm[$this->upload] = $name;
            }
        } else {
            return response()
                ->json(['message' => 'Envie o atributo file no formato base64'], 422);
        }

        $data = $this->model->create($dataForm);

        return response()->json($data, 201);
    }

    public function show($id)
    {
        if (!$data = $this->model->find($id)) {
            return response()->json(['error', 'Nada foi encontrado'], 404);
        } else {
            return response()->json($data);
        }
    }

    public function update(Request $request, $id)
    {

        $arquivo = $this->model->arquivo($id);

        if (!$data = $this->model->find($id)) {
            return response()->json(['error', 'Nada foi encontrado'], 404);
        }
        $this->validate($request, $this->model->rules());

        $dataForm = $request->all();

        if ($request->has($this->upload) && strpos($dataForm[$this->upload], ';base64')) {
            if ($arquivo) {
                Storage::disk('public')->delete("/{$this->path}/$arquivo");
            }

            $base64 = $dataForm[$this->upload];
            //obtem a extensão
            $extension = explode('/', $base64);
            $extension = explode(';', $extension[1]);
            $extension = '.' . $extension[0];
            //gera o nome
            $name = time() . $extension;
            //obtem o arquivo
            $separatorFile = explode(',', $base64);
            $file = $separatorFile[1];
            //envia o arquivo
            // Storage::put($this->path . $name, base64_decode($file));
            $upload = Image::make(base64_decode($file))->resize($this->width, $this->height)->save(storage_path("app/public/{$this->path}/{$name}", 70));

            if (!$upload) {
                return response()->json(['error' => 'Falha ao fazer upload'], 500);
            } else {
                $dataForm[$this->upload] = $name;
            }
        }

        $data->update($dataForm);

        return response()->json($data);
    }

    public function destroy($id)
    {
        if ($data = $this->model->find($id)) {
            if (method_exists($this->model, 'arquivo')) {
                Storage::disk('public')->delete("/{$this->path}/{$this->model->arquivo($id)}");
            }
            $data->delete();
            return response()->json(['success' => 'item deletado com sucesso']);
        } else {
            return response()->json(['error', 'Nada foi encontrado'], 404);
        }
    }
}
