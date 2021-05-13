<?php

namespace App\Http\Controllers\JobBoard;

// Controllers
use App\Http\Controllers\Controller;
use App\Http\Controllers\App\FileController;
use App\Http\Controllers\App\ImageController;

// Models
use App\Http\Requests\JobBoard\Category\StoreCategoryRequest;
use App\Models\App\Catalogue;
use App\Models\JobBoard\Company;
use App\Models\JobBoard\Professional;
use App\Models\JobBoard\Category;

// FormRequest
use App\Http\Requests\JobBoard\Category\IndexCategoryRequest;
use App\Http\Requests\JobBoard\Category\UpdateCategoryRequest;
use App\Http\Requests\App\Image\UpdateImageRequest;
use App\Http\Requests\App\Image\UploadImageRequest;
use App\Http\Requests\App\File\UpdateFileRequest;
use App\Http\Requests\App\File\UploadFileRequest;
use App\Http\Requests\App\File\IndexFileRequest;
use App\Http\Requests\App\Image\IndexImageRequest;

class CategoryController extends Controller
{
    
    function index(IndexCategoryRequest $request)
{

    if ($request->has('search')) {
        $categories = $category->categories()
            ->code($request->input('search'))
            ->name($request->input('search'))
            ->paginate($request->input('per_page'));
    } else {
        $categories = $category->categories()->paginate($request->input('per_page'));
    }

    if (sizeof($categories) === 0) {
        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'No se encontraron Categorias',
                'detail' => 'Intente de nuevo',
                'code' => '404'
            ]], 404);
    }

    return response()->json($categories, 200);
}

    function show($categoryId)
    {
        // Valida que el id se un número, si no es un número devuelve un mensaje de error
        if (!is_numeric($categoryId)) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'ID no válido',
                    'detail' => 'Intente de nuevo',
                    'code' => '400'
                ]], 400);
        }
        $category = Category::find($categoryId);

        // Valida que exista el registro, si no encuentra el registro en la base devuelve un mensaje de error
        if (!$category) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Categoria no encontrada',
                    'detail' => 'Vuelva a intentar',
                    'code' => '404'
                ]], 404);
        }

        return response()->json([
            'data' => $category,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

    function store(StoreCategoryRequest $request)
    {

        $category = new Category();
        $category->name = $request->input('category.name');
        $category->code = $request->input('category.code');
        $category->save();

        return response()->json([
            'data' => $category,
            'msg' => [
                'summary' => 'Categoria creada',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]], 201);
    }

    function update(UpdateCategoryRequest $request, $categoryId)
    {
       

        // Valida que exista el registro, si no encuentra el registro en la base devuelve un mensaje de error
        if (!$category) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Habilidad no encontrada',
                    'detail' => 'Vuelva a intentar',
                    'code' => '404'
                ]], 404);
        }

        $category->name = $request->input('category.name');
        $category->code = $request->input('category.code');
        $category->save();

        return response()->json([
            'data' => $skill,
            'msg' => [
                'summary' => 'Categoria actualizada',
                'detail' => 'El registro fue actualizado',
                'code' => '201'
            ]], 201);
    }

    function destroy($categoryId)
    {
        // Valida que el id se un número, si no es un número devuelve un mensaje de error
        if (!is_numeric($categoryId)) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'ID no válido',
                    'detail' => 'Intente de nuevo',
                    'code' => '400'
                ]], 400);
        }
        $category = Category::find($categoryId);

        // Valida que exista el registro, si no encuentra el registro en la base devuelve un mensaje de error
        if (!$category) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Categoria no encontrada',
                    'detail' => 'Vuelva a intentar',
                    'code' => '404'
                ]], 404);
        }

        // Es una eliminación lógica
        $category->delete();

        return response()->json([
            'data' => $category,
            'msg' => [
                'summary' => 'Categoria eliminada',
                'detail' => 'El registro fue eliminado',
                'code' => '201'
            ]], 201);
    }

    function uploadImages(UploadImageRequest $request)
    {
        return (new ImageController())->upload($request, Skill::getInstance($request->input('id')));
    }

    function updateImage(UpdateImageRequest $request, $imageId)
    {
        return (new ImageController())->update($request, $imageId);
    }

    function deleteImage($imageId)
    {
        return (new ImageController())->delete($imageId);
    }

    function indexImage(IndexImageRequest $request)
    {
        return (new FileController())->index($request, Skill::getInstance($request->input('id')));
    }

    function ShowImage($fileId)
    {
        return (new FileController())->show($fileId);
    }

    function uploadFiles(UploadFileRequest $request)
    {
        return (new FileController())->upload($request, Skill::getInstance($request->input('id')));
    }

    function updateFile(UpdateFileRequest $request, $fileId)
    {
        return (new FileController())->update($request, $fileId);
    }

    function deleteFile($fileId)
    {
        return (new FileController())->delete($fileId);
    }

    function indexFile(IndexFileRequest $request)
    {
        return (new FileController())->index($request, Skill::getInstance($request->input('id')));
    }

    function ShowFile($fileId)
    {
        return (new FileController())->show($fileId);
    }
}
