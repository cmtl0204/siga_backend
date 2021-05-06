<?php

namespace App\Http\Controllers\JobBoard;

use App\Http\Controllers\Controller;
use App\Models\JobBoard\Offer;
use App\Models\JobBoard\Professional;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebOfferController extends Controller
{

    /**
     * Enlista ofertas con status ACTIVE(code=1).
     * Ruta publica y muestra descripcion y activiades.
     *
     * @param Request $request
     * @return JsonResponse
     */
    function getPublicOffers(Request $request): JsonResponse
    {
        $offers = Offer::select('description', 'activities')->paginate($request->input('per_page'));

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
        $offers = Offer::with(['status' => function ($table) {
            $table->where('code', 1);
        }])->paginate($request->input('per_page'));

        return response()->json([
            'data' => $offers,
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
        $offer = Offer::find($request->input('id'));
        $professional = $request->user();

        $applyOffer = $professional->offers()->attach($offer);

        return response()->json([
            'data' => $applyOffer,
            'msg' => [
                'summary' => 'Oferta aplicada',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }

    /**
     * Enlista y filtra ofertas.
     *
     * @param Request $request
     * @return JsonResponse
     */
    function index(Request $request): JsonResponse
    {

        if ($request->has('searchCode')) {
            if ($request->input('searchCode') === 'code') {
                $offers = Offer::
                where('code' === $request->input('search'))
                    ->paginate($request->input('per_page'));
            } else {
                // codido para filtraciones por otros parametros.
            }
        }

        $offers = Offer::paginate($request->input('per_page'));

        return response()->json([
            'data' => $offers,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200);
    }
}
