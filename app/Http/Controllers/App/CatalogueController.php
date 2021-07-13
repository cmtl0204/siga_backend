<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\App\Catalogue;

use Illuminate\Http\Request;

class CatalogueController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('parent_id')) {
            $parent = Catalogue::firstWhere('parent_id', $request->parent_id);
            $catalogues = $parent->children()->where('type', $request->type)->get();
        } else {
            $catalogues = Catalogue::where('type', $request->type)->get();
        }
        return response()->json([
            'data' => $catalogues,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]
        ], 200);
    }

    public function show(Catalogue $catalogue)
    {
        return response()->json([
            'data' => [
                'catalogue' => $catalogue
            ]
        ], 200);
    }

    public function store(Request $request)
    {
        $data = $request->json()->all();
        $dataCatalogue = $data['catalogue'];
        //$dataParentCode = $data['parent_code'];

        $catalogue = new Catalogue();
        $catalogue->code = $dataCatalogue['code'];
        $catalogue->name = $dataCatalogue['name'];
        $catalogue->icon = $dataCatalogue['icon'];
        $catalogue->type = $dataCatalogue['type'];

        //$state = State::firstWhere('code', State::ACTIVE);
        //$parentCode = Catalogue::findOrFail($dataParentCode['id']);

        //$catalogue->state()->associate($state);
        //$catalogue->parentCode()->associate($parentCode);

        $catalogue->save();

        return response()->json([
            'data' => [
                'catalogues' => $catalogue
            ]
        ], 201);
    }

    public function update(Request $request, Catalogue $catalogue)
    {

        $data = $request->json()->all();
        $dataCatalogue = $data['catalogue'];
        //        $dataParentCode = $data['parent_code'];

        //        $catalogue->code = $dataCatalogue['code'];
        $catalogue->name = $dataCatalogue['name'];
        $catalogue->icon = $dataCatalogue['icon'];
        $catalogue->type = $dataCatalogue['type'];

        //        $parentCode = Catalogue::findOrFail($dataParentCode['id']);

        //        $catalogue->parentCode()->associate($parentCode);
        $catalogue->save();
        return response()->json([
            'data' => [
                'catalogue' => $catalogue
            ]
        ], 201);
    }

    public function destroy(Catalogue $catalogue)
    {
        //        $catalogue->delete();
        $state = State::where('code', '3')->first();
        $catalogue->state()->associate($state);
        $catalogue->save();
        return response()->json([
            'data' => [
                'catalogue' => $catalogue
            ]
        ], 201);
    }
}
