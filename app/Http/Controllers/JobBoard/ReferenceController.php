<?php

namespace App\Http\Controllers\JobBoard;
// Controllers
use App\Http\Controllers\Controller;
// FormRequests
use App\Http\Requests\JobBoard\Reference\CreateReferenceRequest;
use App\Http\Requests\JobBoard\Reference\IndexReferenceRequest;
use App\Http\Requests\JobBoard\Reference\UpdateReferenceRequest;
use App\Http\Requests\JobBoard\Reference\StoreReferenceRequest;
use App\Http\Requests\JobBoard\Reference\DeleteReferenceRequest;
use App\Http\Requests\JobBoard\Reference\GetReferenceRequest;

use App\Http\Controllers\App\FileController;
use App\Http\Requests\App\File\UpdateFileRequest;
use App\Http\Requests\App\File\UploadFileRequest;
use App\Http\Requests\App\File\IndexFileRequest;

// Models
use App\Models\JobBoard\Reference;
use App\Models\JobBoard\Professional;

use App\Models\App\Catalogue;

use Illuminate\Http\Request;

class ReferenceController extends Controller
{
    function  test(Request $request)
    {
        return Professional::select('about_me', 'has_travel')->with('course')->get();
    }

    function index(IndexReferenceRequest $request)
    {
        // Crea una instanacia del modelo Professional para poder consultar en el modelo course.
      
        $professional = $request->user()->professional()->first();
        if (!$professional) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraró al profesional',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]
            ], 404);
        }
        //$professional = Professional::getInstance($request->input('professional_id'));
        if ($request->has('search')) {
            $references = $professional->references()
                ->institution($request->input('search'))
                ->position($request->input('search'))
                ->contactName($request->input('search'))
                ->contactPhone($request->input('search'))
                ->contactEmail($request->input('search'))
                ->get();
        } else {
            $references = $professional->references()->paginate($request->input('per_page'));
        }

        if ($references->count() === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron Referencias',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]
            ], 404);
        }

        return response()->json($references, 200);
    }

    function show(Reference $reference)
    {
        
        return response()->json([
            'data' => $reference,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]
        ], 200);
    }


/*function get(GetReferenceRequest $request)
    {
        $reference = $request->user()->reference()
            ->with(['institution'=>function($institution){
                $user->with('name');      
            }])->first();
        if(!$reference){
            return response()->json([
                'data' => $reference,
                'msg' => [
                    'summary' => 'reference no encontrada',
                    'detail' => 'Vuelva a intentar',
                    'code' => '404',
                ]], 404);
        }
        return response()->json([
            'data' => $reference,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200',
            ]], 200);
    }
*/

    function store(CreateReferenceRequest $request)
    {
        
        $professional = $request->user()->professional()->first();
        if (!$professional) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraró al profesional',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]
            ], 404);
        }
        //$professional = Professional::getInstance($request->input('professional.id'));
        $institution = Catalogue::find($request->input('reference.institution.id'));
        $reference = new Reference();
        //$reference->institution = $request->input('reference.institution');
        $reference->position = $request->input('reference.position');
        $reference->contact_name = $request->input('reference.contact_name');
        $reference->contact_phone = $request->input('reference.contact_phone');
        $reference->contact_email = $request->input('reference.contact_email');
        $reference->professional()->associate($professional);
        $reference->institution()->associate($institution);
        $reference->save();

        return response()->json([
            'data' => $reference,
            'msg' => [
                'summary' => 'Referencia creada',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]
        ], 201);
    }

/*function store(CreateReferenceRequest $request)
    {
        $professional = Professional::getInstance($request->input('professional.id'));

        $reference = new Reference();
        $reference->professional()->associate($professional);
        $reference->institution = $request->input('reference.institution');
        $reference->position = $request->input('reference.position');
        $reference->contact_name = $request->input('reference.contact_name');
        $reference->contact_phone = $request->input('reference.contact_phone');
        $reference->contact_email = $request->input('reference.contact_email');

        $reference->save();

        return response()->json([
            'data' => $reference,
            'msg' => [
                'summary' => 'Referencia creada',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]], 201);
    }*/
    function update(UpdateReferenceRequest $request, Reference $reference)
    {
        $institution = Catalogue::find($request->input('reference.institution.id'));

       // $reference = Reference::find($id);

        if (!$reference) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Referencia no encontrada',
                    'detail' => 'Vuelva a intentar',
                    'code' => '404'
                ]], 404);
        }

   //     $reference->institution = $request->input('reference.institution');
        $reference->position = $request->input('reference.position');
        $reference->contact_name = $request->input('reference.contact_name');
        $reference->contact_phone = $request->input('reference.contact_phone');
        $reference->contact_email = $request->input('reference.contact_email');
        $reference->institution()->associate($institution);
        $reference->save();

        return response()->json([
            'data' => $reference,
            'msg' => [
                'summary' => 'Referencia actualizada',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]
        ], 201);
    }

  /*  function destroy(DeleteReferenceRequest $reference)
    {
        $reference->deletee();

        return response()->json([
            'data' => $reference,
            'msg' => [
                'summary' => 'Oferta eliminada',
                'detail' => 'El registro fue eliminado',
                'code' => '201'
            ]
        ], 201);
    }*/
    
    function delete(DeleteReferenceRequest $request)
    {
        // Es una eliminación lógica
        Reference::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Referencia(s) eliminada(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]], 201);
    }
    function deleteFile($fileId)
    {
        return (new FileController())->delete($fileId);
    }

    function uploadFiles(UploadFileRequest $request)
    {
        return (new FileController())->upload($request, Reference::getInstance($request->input('id')));
    }

    function indexFile(IndexFileRequest $request)
    {
        return (new FileController())->index($request, Reference::getInstance($request->input('id')));
    }

    function ShowFile($fileId)
    {
        return (new FileController())->show($fileId);
    }
   
}

