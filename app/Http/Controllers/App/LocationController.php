<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\App\Location;
use Illuminate\Http\Request;
use App\Models\App\Catalogue;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $locations = Location::with('type')->with('parent')->with(['children' => function ($province) {
            $province->with('parent')->with(['children' => function ($canton) {
                $canton->with('parent')->with(['children' => function ($parish) {
                    $parish->with('parent')->with('children');
                }]);
            }]);
        }])->get();
        return response()->json([
            'data' => $locations,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

    public function show(Catalogue $catalogue)
    {
        return response()->json([
            'data' => [
                'catalogue' => $catalogue
            ]], 200);
    }

    public function store(Request $request)
    {
        $data = $request->json()->all();
        $dataCatalogue = $data['catalogue'];
        $dataParentCode = $data['parent_code'];

        $catalogue = new Catalogue();
        $catalogue->code = $dataCatalogue['code'];
        $catalogue->name = $dataCatalogue['name'];
        $catalogue->icon = $dataCatalogue['icon'];
        $catalogue->type = $dataCatalogue['type'];

        $state = State::firstWhere('code', State::ACTIVE);
        $parentCode = Catalogue::findOrFail($dataParentCode['id']);

        $catalogue->state()->associate($state);
        $catalogue->parentCode()->associate($parentCode);

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

    public function getCountries(Request $request)
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        $locations = Location::whereHas('type', function ($type) use ($catalogues) {
            $type->where('type', $catalogues['catalogue']['location']['type'])
                ->where('code', $catalogues['catalogue']['location']['country']);
        })->get();
        return response()->json([
            'data' => $locations,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

    public function getLocations(Request $request)
    {
        $locations = Location::with('type')
            ->with(['children' => function ($province) {
            $province->with('type')->with(['children' => function ($canton) {
                $canton->with('type')->with(['children' => function ($parish) {
                    $parish->with('type');
                }]);
            }]);
        }])->get();
        return response()->json([
            'data' => $locations,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }
}
