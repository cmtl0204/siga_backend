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
     * Ruta pública
     * Obtiene ofertas con status ACTIVE(code=1).
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

        // por input de busqueda
        if (!is_null($request->input('generalSearch'))) {
            $offers = Offer::aditionalInformation($request->input('generalSearch'))
                ->location($request->input('generalSearch'))
                ->orWhere
                ->position($request->input('generalSearch'))
                ->categoryName($request->input('generalSearch'))
                ->status(1)
                ->paginate($request->input('per_page'));

            return response()->json([$offers, 'hola'], 200);
        }

        $offers = Offer::province($request->input('searchProvince'))
            ->canton($request->input('searchCanton'))
            ->position($request->input('searchPosition'))
            ->idCategories($request->input('searchIdCategory'))
            ->parentCategory($request->input('searchParentCategory'))
            ->status(1)
            ->paginate($request->input('per_page'));

        return response()->json($offers, 200);
    }

    /**
     * Ruta privada
     * Obtiene ofertas con status ACTIVE(code=1).
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

        // por input de busqueda
        if (!is_null($request->input('generalSearch'))) {
            $offers = Offer::professional($professional)
                ->aditionalInformation($request->input('generalSearch'))
                ->location($request->input('generalSearch'))
                ->orWhere
                ->position($request->input('generalSearch'))
                ->categoryName($request->input('generalSearch'))
                ->status(1)
                ->paginate($request->input('per_page'));

            return response()->json([$offers, 'hola'], 200);
        }

        $offers = Offer::professional($professional)
            ->status(1)
            ->province($request->input('searchProvince'))
            ->canton($request->input('searchCanton'))
            ->position($request->input('searchPosition'))
            ->idCategories($request->input('searchIdCategory'))
            ->parentCategory($request->input('searchParentCategory'))
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
     * Obtiene las categorias
     *
     * @return JsonResponse
     */
    function getCategories(): JsonResponse
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
