<?php

namespace App\Http\Controllers\JobBoard;

use App\Http\Controllers\Controller;
use App\Models\App\Status;
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
        $offers = Offer::select('description', 'activities', 'requirements')->paginate($request->input('per_page'));

        if ($offers === null) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'no data',
                    'detail' => '',
                    'code' => '200'
                ]], 200);
        }

        return response()->json([
            'data' => $offers,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

    /**
     * Enlista ofertas con status ACTIVE(code=1).
     * Ruta privada y muestra toda la oferta.
     *
     * @param Request $request
     * @return JsonResponse
     */
    function getOffers(Request $request): JsonResponse
    {
        $offers = Offer::whereHas('status')->with(['status' => function ($status) {
            $status->where('code', '1');
        }])->paginate($request->input('per_page'));

        $status = Status::where('code', '1')->get();

        return response()->json([
            'data' => $offers,
            'status' => $status,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

    /**
     * Aplica a las ofertas
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
                    'summary' => 'Oferta aplicada',
                    'detail' => '',
                    'code' => '200'
                ]], 200);
        } else {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Sin ID de oferta',
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
    function index(Request $request): JsonResponse
    {
        // filtrado por código.
        if ( !is_null($request->input('searchCode')) ) {
            $code = $request->input('searchCode');
            $offers = Offer::where('code', 'ILIKE', "%$code%")->where('status_id', 1)->paginate($request->input('per_page'));;

            return response()->json([
                'data' => $offers,
                'msg' => [
                    'summary' => 'success',
                    'detail' => 'Filtrado por codigo',
                    'code' => '200'
                ]], 200);
        }

        // filtrado por ubicación.
        if ( !is_null($request->input('searchLocation')) ){
            $searchLocation = $request->input('searchLocation');

            $offers = Offer::whereHas('location', function ($locations) use ($searchLocation){
                $locations->whereIn('location.id', $searchLocation);
            })->where('status_id', 1)->paginate($request->input('per_page'));

            return response()->json([
                'data' => $offers,
                'msg' => [
                    'summary' => 'success',
                    'detail' => 'Filtrado por localización',
                    'code' => '200'
                ]], 200);
        }

        // filtrado por campo especifica (categoría hija)
        if ( !is_null($request->input('searchSpecificField')) ) {
            $specificField = $request->input('searchSpecificField');

            $offers = Offer::whereHas('categories', function ($categories) use ($specificField) {
                $categories->whereIn('categories.parent_id', $specificField);
            })->where('status_id', 1)->paginate($request->input('per_page'));

            return response()->json([
                'data' => $offers,
                'msg' => [
                    'summary' => 'success',
                    'detail' => 'Filtrado por categorias con campo especifico',
                    'code' => '200'
                ]], 200);
        }

        // filtrado por campo amplio (categoría padre)
        if ( !is_null($request->input('searchWideField')) ){
            $wideFields = $request->input('searchWideField');

            $offers = Offer::whereHas('categories', function ($categories) use ($wideFields) {
                $categories->whereIn('categories.id', $wideFields);
            })->where('status_id', 1)->paginate($request->input('per_page'));

            return response()->json([
                'data' => $offers,
                'msg' => [
                    'summary' => 'success',
                    'detail' => 'Filtrado por categorias con campo amplio',
                    'code' => '200'
                ]], 200);
        }


        $offers = Offer::where('status_id', 1)->paginate($request->input('per_page'));

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
