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
    // Consulta el total de profesionales vinculados, empresas registradaas y ofertas laborales disponibles
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

    // Obtiene todos los profesionales cuando se accede a una ruta pública
    function getPublicProfessionals(Request $request)
    {
        if ($request->input('ids') == null && $request->input('search') == null) {
            // Consulta todos los profesionales
            $professionals = Professional::with(['academicFormations' => function ($academicFormations) {
                $academicFormations->with('professionalDegree');
            }])->paginate($request->input('per_page'));
        } 
        else {
            // Consulta a los profesionales filtrados
            $professionals = $this->getPublicProfessionalsFiltered($request);
        }

        return response()->json($professionals);
    }

    // Obtiene todos los profesionales utilizando el filtro cuando se accede a una ruta pública
    private function getPublicProfessionalsFiltered(Request $request)
    {
        if ($request->input('ids') != null && $request->input('search') == null) {
            // Devuelve todos los profesionales que concuerden con el id (categoría hija) 
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
            // Devuelve todos los profesionales que coincidan con search
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
            // Devuelve todos los profesionales que concuerden con el id (categoría hija) y con search
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
            //Devuelve vacío si no cumple las condiciones anteriores
            $professionals = [];
        }

        return $professionals;
    }

    // Obtiene todos los profesionales cuando se accede a una ruta privada (autenticación de usuario)
    function getPrivateProfessionals(Request $request)
    {
        $company = $request->user()->company()->first();

        if ($request->input('ids') == null && $request->input('search') == null) {
            // Consulta todos los profesionales
            $professionals = Professional::with(['academicFormations' => function ($academicFormations) {
                $academicFormations->with('professionalDegree');
            }])->company($company)
            ->paginate($request->input('per_page'));
        } 
        else {
            // Consulta a los profesionales filtrados
            $professionals = $this->getPrivateProfessionalsFiltered($request, $company);
        }

        return response()->json($professionals);
    }

    // Obtiene todos los profesionales utilizando el filtro cuando se accede a una ruta privada (autenticación de usuario)
    private function getPrivateProfessionalsFiltered(Request $request, Company $company)
    {
        if ($request->input('ids') != null && $request->input('search') == null) {
            // Devuelve todos los profesionales que concuerden con el id (categoría hija) 
            $professionals = Professional::whereHas('academicFormations', function($academicFormations) use ($request) {
                $academicFormations->whereHas('professionalDegree')
                    ->whereIn('professional_degree_id', $request->input('ids'));
            })->with(['academicFormations' => function ($academicFormations) use ($request) {
                $academicFormations->whereHas('professionalDegree', function($professionalDegree) use ($request) {
                    $professionalDegree->whereIn('id', $request->input('ids'));
                })->with(['professionalDegree' => function ($professionalDegree) use ($request) {
                    $professionalDegree->whereIn('id', $request->input('ids'));
                }]);
            }])->company($company)
            ->paginate($request->input('per_page'));
        }
        else if ($request->input('ids') == null && $request->input('search') != null) {
            // Devuelve todos los profesionales que coincidan con search
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
            }])->company($company)
            ->paginate($request->input('per_page'));
        }    
        else if ($request->input('ids') != null && $request->input('search') != null) {
            // Devuelve todos los profesionales que concuerden con el id (categoría hija) y con search
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
            }])->company($company)
            ->paginate($request->input('per_page'));
        }
        else {
            //Devuelve vacío si no cumple las condiciones anteriores
            $professionals = [];
        }

        return $professionals;
    }

    // Obtiene las categorías que se va user en el filtro
    function filterCategories()
    {
        $categories = Category::with(['children' => function ($children) {
            $children->orderBy('name');
        }])->whereNull('parent_id')->get();

        return response()->json([
            'data' => $categories,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]
        ], 200);
    }

    // Permite a las empresas contactar con los profesionales
    function applyProfessional(Request $request)
    {
        $professional = Professional::find($request->input('professional_id'));
        $company = Company::where('user_id', $request->user()->id)->first();

        if (!$company || !$professional) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'error',
                    'detail' => 'Error al contactar con el profesional',
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
