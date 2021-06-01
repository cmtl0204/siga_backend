<?php

namespace App\Http\Controllers\JobBoard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\App\FileController;
use App\Http\Controllers\App\ImageController;
use App\Models\App\Catalogue;
use App\Models\JobBoard\Category;
use App\Http\Requests\JobBoard\Category\StoreCategoryRequest;
use App\Http\Requests\JobBoard\Category\IndexCategoryRequest;
use App\Http\Requests\JobBoard\Category\UpdateCategoryRequest;
use App\Http\Requests\JobBoard\Category\DeleteCategoryRequest;
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
            $categories = Category::
                code($request->input('search'))
                ->name($request->input('search'))
                ->paginate($request->input('per_page'));
        } else {
            $categories = Category::paginate($request->input('per_page'));
        }

        if ($categories->count() === 0) {
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

    function show(Category $category)
    {
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
        $category->code = $request->input('category.code');
        $category->name = $request->input('category.name');
        $category->save();

        return response()->json([
            'data' => $category,
            'msg' => [
                'summary' => 'Categoria creada',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]], 201);
    }

    function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->code = $request->input('category.code');
        $category->name = $request->input('category.name');
        $category->save();

        return response()->json([
            'data' => $category->fresh(),
            'msg' => [
                'summary' => 'Categoria actualizada',
                'detail' => 'El registro fue actualizado',
                'code' => '201'
            ]], 201);
    }

    function delete(DeleteCategoryRequest $request)
    {
        // Es una eliminación lógica
        Category::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Categoria(s) eliminada(s)',
                'detail' => 'Se eliminó correctamente',
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
