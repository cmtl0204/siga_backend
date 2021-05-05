<?php

namespace App\Http\Controllers\JobBoard;

use App\Models\App\Catalogue;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\JobBoard\Category;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    //Método para obtener las categorias
    function index(Request $request): JsonResponse
    {
//        $categories = Category::with('children')->with(['type' => function ($query) {
//            $query->where('type', 'categories.type1');
//        }])->get();

        $categories = Category::all();
        return response()->json([
            'data' => [
                'categories' => $categories
            ]
        ], 200);
    }

    function show($id):JsonResponse
    {
        $category = Category::findOrFail($id);

        return response()->json([
            'data' => $category,
            'msg' => [
                'summary' => 'success',
                'detail' => ''
            ]], 200);
    }

    function store(Request $request): JsonResponse
    {

        $data = $request->json()->all();

        $dataCategories = $data['categories'];
        $dataCatalogues = $data['catalogues'];

        $category = new Category();
        $category->code = $dataCatalogues['code'];
        $category->name = $dataCatalogues['name'];
        $category->icon = $dataCatalogues['icon'];

        $category->children()->associate(Category::firstWhere($dataCategories['parent_id']));
        $category->type()->associate(Catalogue::firstWhere($dataCatalogues['id']));
        $category->save();

        return response()->json([
        'data' => null,
        'msg' => [
            'summary' => 'success',
            'detail' => ''
        ]], 200);
    }

    function update(Request $request,$id): JsonResponse
    {
        $data = $request->json()->all();

        $dataCategories = $data['categories'];
        $dataCatalogues = $data['catalogues'];

        $category = Category::findOrFail($id);
        $category->code = $dataCatalogues['code'];
        $category->name = $dataCatalogues['name'];
        $category->icon = $dataCatalogues['icon'];

        $category->children()->associate(Category::firstWhere($dataCategories['parent_id']));
        $category->type()->associate(Catalogue::firstWhere($dataCatalogues['id']));

        $category->save();

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'success',
                'detail' => ''
            ]], 200);
    }

    function destroy($id): JsonResponse
    {
        $category = Category::findOrFail($id);
        $category->state = false;
        $category->save();

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'success',
                'detail' => ''
            ]], 204);
    }

}
