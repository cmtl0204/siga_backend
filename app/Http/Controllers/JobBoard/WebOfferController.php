<?php

namespace App\Http\Controllers\JobBoard;

use App\Http\Controllers\Controller;
use App\Models\JobBoard\Category;
use App\Models\JobBoard\Offer;
use App\Models\JobBoard\Professional;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WebOfferController extends Controller
{

    /**
     * Ruta publica y muestra descripcion y activiades.
     *
     * @param Request $request
     * @return JsonResponse
     */
    function getPublicOffers(Request $request): JsonResponse
    {
        // Por código.
        if (!is_null($request->input('searchCode'))) {
            $code = $request->input('searchCode');

            $offers = Offer::where('code', 'ILIKE', "%$code%")->status(1)->paginate($request->input('per_page'));

            return response()->json($offers, 200);
        }

        // por categorías.
        if (!is_null($request->input('searchIDs'))) {
            $categories = $request->input('searchIDs');

            $offers = Offer::whereHas('categories', function ($query) use ($categories) {
                $query->whereIn('categories.id', $categories);
            })->status(1)->paginate($request->input('per_page'));

            return response()->json($offers, 200);

        }

        $offers = Offer::province($request->input('searchProvince'))
            ->canton($request->input('searchCanton'))
            ->position($request->input('searchPosition'))
            ->status(1)
            ->paginate($request->input('per_page'));

        return response()->json($offers, 200);
    }

    /**
     * Enlista ofertas con status ACTIVE(code=1).
     * Ruta privada y muestra toda la oferta.
     *
     * @param Request $request
     * @return JsonResponse
     */
    function getPrivateOffers(Request $request): JsonResponse
    {
        $professional = $request->user()->professional()->first();

        // Por código.
        if (!is_null($request->input('searchCode'))) {
            $code = $request->input('searchCode');

            $offers = Offer::professional($professional)
                ->status(1)
                ->where('code', 'ILIKE', "%$code%")
                ->paginate($request->input('per_page'));

            return response()->json($offers, 200);
        }

        // por categorías.
        if (!is_null($request->input('searchIDs'))) {
            $categories = $request->input('searchIDs');

            $offers = Offer::whereHas('categories', function ($query) use ($categories) {
                $query->whereIn('categories.id', $categories);
            })->status(1)
                ->professional($professional)
                ->paginate($request->input('per_page'));

            return response()->json($offers, 200);

        }

        $offers = Offer::professional($professional)
            ->status(1)
            ->province($request->input('searchProvince'))
            ->canton($request->input('searchCanton'))
            ->position($request->input('searchPosition'))
            ->paginate($request->input('per_page'));

        return response()->json($offers, 200);
    }

    /**
     * Aplíca a las ofertas
     *
     * @param Request $request
     * @return JsonResponse
     */
    function applyOffer(Request $request): JsonResponse
    {
        if ($request->input('id')) {
            $offer = Offer::find($request->input('id'));
            $professional = Professional::where('user_id', $request->user()->id)->first();

            $professional->offers()->attach($offer->id);

            return response()->json([
                'msg' => [
                    'summary' => 'Oferta aplicada.',
                    'detail' => '',
                    'code' => '200'
                ]], 200);
        } else {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Sin ID de oferta.',
                    'detail' => '',
                    'code' => '200'
                ]], 200);
        }

    }

    /**
     * Enlista y filtra ofertas.
     *
     * @param Request $request
     * @return JsonResponse
     */
    function test(Request $request)
    {
        $professional = $request->user()->professional()->first();

        // Por campo amplio y especifico(categoría hija y padre)
        if (!is_null($request->input('searchIDs'))) {
            $categories = $request->input('searchIDs');

            $offers = Offer::whereHas('categories', function ($query) use ($categories) {
                $query->whereIn('categories.id', $categories);
            })->status(1)
                ->professional($professional)
                ->paginate($request->input('per_page'));

//            $offers = Offer::categories($categories)->status(1)
//                ->professional($professional)
//                ->paginate($request->input('per_page'));

            return response()->json($offers, 200);

        }

//        return response()->json($offers, 200);

    }

    function index2(Request $request)
    {
        $professional = $request->user()->professional()->first();

        // Por código.
        if (!is_null($request->input('searchCode'))) {
            $code = $request->input('searchCode');

            $offers = Offer::whereHas('status', function ($status) {
                $status->where('code', 1);
            })->where('code', 'ILIKE', "%$code%")->whereDoesntHave('professionals', function ($professionals) use ($professional) {
                $professionals->where('professionals.id', $professional->id);
            })->paginate($request->input('per_page'));

            return response()->json([
                'data' => $offers,
                'msg' => [
                    'summary' => 'success',
                    'detail' => 'Filtrado por codigo',
                    'code' => '200'
                ]], 200);
        }

        // Por ubicación por provicnia.
        if (!is_null($request->input('searchProvince'))) {

            $searchProvince = $request->input('searchProvince');
            $searchCanton = $request->input('searchCanton');
//            $offers = Offer::whereHas('location', function ($location) use ($searchProvince){
//                $location->where('parent_id', $searchProvince);
//            })->whereHas('status', function ($status){
//                $status->where('code', 1);
//            })->paginate($request->input('per_page'));


            $offers = Offer::professional($professional)->status(1)->province($searchProvince)->canton($searchCanton)->paginate($request->input('per_page'));


            return response()->json($offers, 200);
        }

        // canton
        if (!is_null($request->input('searchCanton'))) {

            $searchCanton = $request->input('searchCanton');

            $offers = Offer::where('location_id', $searchCanton)->whereHas('status', function ($status) {
                $status->where('code', 1);
            })->paginate($request->input('per_page'));

            return response()->json($offers, 200);
        }

        if (!is_null($request->input('searchLocation'))) {
            $searchLocation = $request->input('searchLocation');

            $offers = Offer::whereHas('location', function ($locations) use ($searchLocation) {
                $locations->whereIn('location.id', $searchLocation);
            })->whereDoesntHave('professionals', function ($professionals) use ($professional) {
                $professionals->where('professionals.id', $professional->id);
            })->where('status_id', 1)->paginate($request->input('per_page'));

            return response()->json([
                'data' => $offers,
                'msg' => [
                    'summary' => 'success',
                    'detail' => 'Filtrado por localización',
                    'code' => '200'
                ]], 200);
        }

        // Por campo amplio(categoría padre),
        if (!is_null($request->input('searchParentCategory'))) {
            $specificField = $request->input('searchParentCategory');

            $offers = Offer::whereHas('categories', function ($categories) use ($specificField) {
                $categories->whereIn('categories.parent_id', $specificField);
            })->whereHas('status', function ($status) {
                $status->where('code', 1);
            })->whereDoesntHave('professionals', function ($professionals) use ($professional) {
                $professionals->where('professionals.id', $professional->id);
            })->paginate($request->input('per_page'));

            return response()->json([
                'data' => $offers,
                'msg' => [
                    'summary' => 'success',
                    'detail' => 'Filtrado por categorias con campo especifico',
                    'code' => '200'
                ]], 200);
        }

        // Por campo amplio y especifico(categoría hija y padre)
        if (!is_null($request->input('searchIDs'))) {
            $wideFields = $request->input('searchIDs');

            $offers = Offer::whereHas('categories', function ($categories) use ($wideFields) {
                $categories->whereIn('categories.id', $wideFields);
            })->whereHas('status', function ($status) {
                $status->where('code', 1);
            })->whereDoesntHave('professionals', function ($professionals) use ($professional) {
                $professionals->where('professionals.id', $professional->id);
            })->paginate($request->input('per_page'));

            return response()->json([
                'data' => $offers,
                'msg' => [
                    'summary' => 'success',
                    'detail' => 'Filtrado por categorias con campo amplio',
                    'code' => '200'
                ]], 200);
        }

        // Sin filtros
        $offers = Offer::whereHas('status', function ($status) {
            $status->where('code', 1);
        })->professional($professional)->paginate($request->input('per_page'));


        return response()->json([
            'data' => $offers,
            'msg' => [
                'summary' => 'success',
                'detail' => 'Sin filtros',
                'code' => '200'
            ]], 200);
    }

    function getCategories()
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();

        return response()->json([
            'data' => $categories,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]
        ], 200);
    }
}
