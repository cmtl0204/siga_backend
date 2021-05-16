<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
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
        $file = Storage::download($path);
        return $file;
        return response()->json([
            'data' => $file,
            'msg' => [
                'summary' => 'Archivo no encontrado',
                'detail' => 'Intente de nuevo',
                'code' => '200'
            ]], 200);
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
                'files',
                $newFile->fullName,
                'private'
            );

            $newFile->directory = 'files';
            $newFile->save();
        }
        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Archivo subido',
                'detail' => 'El archivo fue subido correctamente',
                'code' => '201'
            ]], 201);
    }

    public function update(UpdateFileRequest $request, $fileId)
    {
        $file = File::find($fileId);
        // Valida que exista el archivo, si no encuentra el registro en la base devuelve un mensaje de error
        if (!$file) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Archivo no encontrado',
                    'detail' => 'El archivo no pudo ser modificado',
                    'code' => '404'
                ]], 404);
        }

        $request->file('file')->storeAs(
            'files',
            $file->fullName,
            'private'
        );
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

    public function delete($fileId)
    {
        $file = File::find($fileId);
        // Valida que exista el archivo, si no encuentra el registro en la base devuelve un mensaje de error
        if (!$file) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Archivo no encontrado',
                    'detail' => 'El archivo ya ha sido eliminada',
                    'code' => '404'
                ]], 404);
        }
        // Es una eliminación lógica
        $file->state = false;
        $file->save();

        // Elimina los archivos del servidor
        Storage::delete('files\\' . $file->fullName);

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Archivo eliminado',
                'detail' => 'El archivo fue eliminada correctamente',
                'code' => '201'
            ]], 201);
    }

    public function index(IndexFileRequest $request, $model)
    {
        if ($request->has('search')) {
            $files = $model->files()
                ->name($request->input('search'))
                ->description($request->input('search'))
                ->get();
        } else {
            $files = $model->files()->paginate($request->input('per_page'));
        }

        if (sizeof($files) === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron archivos',
                    'detail' => 'Intente de nuevo',
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
