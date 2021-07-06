<?php

namespace App\Http\Controllers\JobBoard;

// Controllers
use App\Http\Controllers\Controller;
use App\Models\Authentication\User;
// Models
use App\Models\JobBoard\Company;
use App\Models\JobBoard\Professional;
use App\Models\JobBoard\Offer;
use App\Models\JobBoard\Category;

use Illuminate\Http\Request;

class WebProfessionalController extends Controller
{
    function total()
    {
        $totalCompanies = Company::all()->count();
        $totalProfessionals = Professional::all()->count();
        $toalOffers = Offer::all()->count();

        return response()->json([
            'data' => [
                'totalCompanies' => $totalCompanies,
                'totalProfessionals' => $totalProfessionals,
                'totalOffers' => $toalOffers
            ],
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]
        ], 200);
    }

    function getProfessionals(Request $request)
    {
        if ($request->input('ids') == null && $request->input('search') == null) {
            // Consulta todos los profesionales
            $professionals = Professional::with(['academicFormations' => function ($academicFormations) {
                $academicFormations->with('professionalDegree');
            }])->paginate($request->input('per_page'));
        } 
        else if ($request->input('ids') != null && $request->input('search') == null) {
            // Consulta todos los profesionales que concuerden con el id (categoría hija) 
            $professionals = Professional::whereHas('academicFormations', function($academicFormations) use ($request) {
                $academicFormations->whereHas('professionalDegree')
                    ->whereIn('professional_degree_id', $request->input('ids'));
            })->with(['academicFormations' => function ($academicFormations) use ($request) {
                $academicFormations->whereHas('professionalDegree', function($professionalDegree) use ($request) {
                    $professionalDegree->whereIn('id', $request->input('ids'));
                })->with(['professionalDegree' => function ($professionalDegree) use ($request) {
                    $professionalDegree->whereIn('id', $request->input('ids'));
                }]);
            }])->paginate($request->input('per_page'));
        }
        else if ($request->input('ids') == null && $request->input('search') != null) {
            // Consulta todos los profesionales que coincidan con search
            $professionals = Professional::whereHas('academicFormations', function($academicFormations) use ($request) {
                $academicFormations->whereHas('professionalDegree', function($professionalDegree) use ($request) {
                    $professionalDegree->where('name', 'ilike', "%{$request->input('search')}%");
                });
            })->with(['academicFormations' => function($academicFormations) use ($request) {
                $academicFormations->whereHas('professionalDegree', function($professionalDegree) use ($request) {
                    $professionalDegree->where('name', 'ilike', "%{$request->input('search')}%");
                })->with(['professionalDegree' => function($professionalDegree) use ($request) {
                    $professionalDegree->where('name', 'ilike', "%{$request->input('search')}%");
                }]);
            }])->paginate($request->input('per_page'));
        }
        else if ($request->input('ids') != null && $request->input('search') != null) {
            // Consulta todos los profesionales que concuerden con el id (categoría hija) y con search
            $professionals = Professional::whereHas('academicFormations', function($academicFormations) use ($request) {
                $academicFormations->whereHas('professionalDegree', function($professionalDegree) use ($request) {
                    $professionalDegree->where('name', 'ilike', "%{$request->input('search')}%");
                })->whereIn('professional_degree_id', $request->input('ids'));
            })->with(['academicFormations' => function ($academicFormations) use ($request) {
                $academicFormations->whereHas('professionalDegree', function($professionalDegree) use ($request) {
                    $professionalDegree->whereIn('id', $request->input('ids'))
                        ->where('name', 'ilike', "%{$request->input('search')}%");
                })->with(['professionalDegree' => function ($professionalDegree) use ($request) {
                    $professionalDegree->whereIn('id', $request->input('ids'))
                        ->where('name', 'ilike', "%{$request->input('search')}%");
                }]);
            }])->paginate($request->input('per_page'));
        }
        else {
            // Para revenir errores futuros
            $professionals = [];
        }

        return response()->json($professionals);
    }

    function filterCategories()
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

    function applyProfessional(Request $request)
    {
        $professional = Professional::find($request->input('professional_id'));
        $company = User::find($request->user()->id)->company();

        if (!$company) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'error',
                    'detail' => '',
                    'code' => '404'
                ]
            ], 404);
        }
        
        $company->professionals()->attach($professional->id);

        return response()->json([
            'msg' => [
                'summary' => 'success',
                'detail' => 'Profesional contactado con éxito',
                'code' => '201'
            ]
        ], 201);
    }
}
