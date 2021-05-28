<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\File\DeleteFileRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\App\File\DownloadFileRequest;
use App\Http\Requests\App\File\UpdateFileRequest;
use App\Http\Requests\App\File\UploadFileRequest;
use App\Http\Requests\App\File\IndexFileRequest;
use App\Models\App\File;

class FileController extends Controller
{
    public function download(DownloadFileRequest $request)
    {
        $path = $request->input('full_path');
        if (!Storage::exists($path)) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Archivo no encontrado',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]], 404);
        }
        return Storage::download($path);
    }

    public function upload(UploadFileRequest $request, $model)
    {
        foreach ($request->file('files') as $file) {
            $newFile = new File();
            $newFile->name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $newFile->description = $request->input('description');
            $newFile->extension = $file->getClientOriginalExtension();
            $newFile->fileable()->associate($model);
            $newFile->save();

            $file->storeAs(
                '',
                $newFile->full_path,
                'private'
            );

            $newFile->directory = 'files';
            $newFile->save();
        }
        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Archivo(s) subido(s)',
                'detail' => 'Su petición se procesó correctamente',
                'code' => '201'
            ]], 201);
    }

    public function update(UpdateFileRequest $request, File $file)
    {
        $file->name = $request->input('name');
        $file->description = $request->input('description');
        $file->save();

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Archivo actulizado',
                'detail' => 'El archivo fue actualizado correctamente',
                'code' => '201'
            ]], 201);

    }

    public function delete(DeleteFileRequest $request)
    {
        foreach ($request->input('ids') as $id) {
            $file = File::find($id);
            if ($file) {
                $file->delete();
                Storage::delete('files\\' . $file->partial_path);
            }
        }

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Archivo(s) eliminado(s)',
                'detail' => 'Su petición se procesó correctamente',
                'code' => '201'
            ]], 201);
    }

    public function forceDelete()
    {
        $filesDeleted = File::onlyTrashed()->get();

        foreach ($filesDeleted as $file) {
            if ($file) {
                $file->forceDelete();
                Storage::delete('files\\' . $file->partial_path);
            }
        }

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Archivo(s) eliminado(s)',
                'detail' => 'Su petición se procesó correctamente',
                'code' => '201'
            ]], 201);
    }

    public function index(IndexFileRequest $request, $model)
    {
        if ($request->has('search')) {
            $files = $model->files()
                ->name($request->input('search'))
                ->description($request->input('search'))
                ->paginate($request->input('per_page'));
        } else {
            $files = $model->files()->paginate($request->input('per_page'));
        }

        if ($files->count() === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No tiene archivos subidos',
                    'detail' => 'Empiece a subir sus archivos',
                    'code' => '404'
                ]], 404);
        }

        return response()->json($files, 200);
    }

    public function show($fileId)
    {
        // Valida que el id se un número, si no es un número devuelve un mensaje de error
        if (!is_numeric($fileId)) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'ID no válido',
                    'detail' => 'Intente de nuevo',
                    'code' => '400'
                ]], 400);
        }
        $file = File::firstWhere('id', $fileId);

        // Valida que exista el registro, si no encuentra el registro en la base devuelve un mensaje de error
        if (!$file) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Archivo no encontrado',
                    'detail' => 'Vuelva a intentar',
                    'code' => '404'
                ]], 404);
        }

        return response()->json([
            'data' => $file,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }
}
