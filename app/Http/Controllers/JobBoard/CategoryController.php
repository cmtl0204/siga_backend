<?php

namespace App\Http\Controllers\JobBoard;

use App\Http\Controllers\Controller;
use App\Models\App\Catalogue;
use App\Models\JobBoard\Category;
use App\Http\Requests\JobBoard\Category\StoreCategoryRequest;
use App\Http\Requests\JobBoard\Category\IndexCategoryRequest;
use App\Http\Requests\JobBoard\Category\UpdateCategoryRequest;
use App\Http\Requests\JobBoard\Category\DeleteCategoryRequest;

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
                    'summary' => 'No se encontraron Categorías',
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
        $parent= Category::getInstance($request->input('category.parent.id'));
        
        $type = Catalogue::getInstance($request->input('category.type.id'));

        $category = new Category();
        $category->code = $request->input('category.code');
        $category->name = $request->input('category.name');
        $category->icon = $request->input('category.icon');
        $category->type()->associate($type);
            if($parent){
           $category->parent()->associate($parent);
       }
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
        $parent= Category::getInstance($request->input('category.parent.id'));
        
        $type = Catalogue::getInstance($request->input('category.type.id'));

        $category->code = $request->input('category.code');
        $category->name = $request->input('category.name');
        $category->icon = $request->input('category.icon');
        $category->type()->associate($type);
        if($parent){
            $category->parent()->associate($parent);
        }
        $category->save();

        return response()->json([
            'data' => $category,
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
}
