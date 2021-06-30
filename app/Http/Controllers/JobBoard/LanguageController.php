<?php

namespace App\Http\Controllers\JobBoard;

// Controllers
use App\Http\Controllers\Controller;

// Models
use App\Models\App\Catalogue;
use App\Models\JobBoard\Professional;
use App\Models\JobBoard\Language;

// FormRequest

use App\Http\Requests\JobBoard\Language\IndexLanguageRequest;
use App\Http\Requests\JobBoard\Language\UpdateLanguageRequest;
use App\Http\Requests\JobBoard\Language\CreateLanguageRequest;
use App\Http\Requests\JobBoard\Language\StoreLanguageRequest;
use App\Http\Requests\JobBoard\Language\DeleteLanguageRequest;
use App\Http\Controllers\App\FileController;
use App\Http\Requests\App\File\UpdateFileRequest;
use App\Http\Requests\App\File\UploadFileRequest;
use App\Http\Requests\App\File\IndexFileRequest;


use Illuminate\Database\Eloquent\Model;

class LanguageController extends Controller
{
    function index(IndexLanguageRequest $request)
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
            $languages = $professional->languages()->get();
        } else {
            $languages = $professional->languages()->paginate($request->input('per_page'));
        }

        if ($languages->count() === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron Cursos',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]
            ], 404);
        }
        return response()->json($languages, 200);
    }

    function show(Language $language)
    {
        return response()->json([
            'data' => $language,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]
        ], 200);
    }

    function store(StoreLanguageRequest $request)
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
        // Crea una instanacia del modelo Professional para poder insertar en el modelo lenguage.
      //  $professional = Professional::getInstance($request->input('language.professional.id'));
        $idiom = Catalogue::getInstance($request->input('language.idiom.id'));
        $written_level = Catalogue::getInstance($request->input('language.written_level.id'));
        $spoken_level = Catalogue::getInstance($request->input('language.spoken_level.id'));
        $read_level = Catalogue::getInstance($request->input('language.read_level.id'));

        $language = new Language();
        $language->professional()->associate($professional);
        $language->idiom()->associate($idiom);
        $language->written_level()->associate($written_level);
        $language->spoken_level()->associate($spoken_level);
        $language->read_level()->associate($read_level);
        $language->save();

        return response()->json([
            'data' => $language,
            'msg' => [
                'summary' => 'Lenguaje creada',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]
        ], 201);
    }

    function update(UpdateLanguageRequest $request, Language $language)
    {
        $idiom = Catalogue::getInstance($request->input('language.idiom.id'));
        $written_level = Catalogue::getInstance($request->input('language.written_level.id'));
        $spoken_level = Catalogue::getInstance($request->input('language.spoken_level.id'));
        $read_level = Catalogue::getInstance($request->input('language.read_level.id'));

      //  $language = Language::find($languageId);

        // Valida que exista el registro, si no encuentra el registro en la base devuelve un mensaje de error
        if (!$language) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Lenguaje no encontrada',
                    'detail' => 'Vuelva a intentar',
                    'code' => '404'
                ]], 404);
        }

        $language->idiom()->associate($idiom);
        $language->written_level()->associate($written_level);
        $language->spoken_level()->associate($spoken_level);
        $language->read_level()->associate($read_level);
        $language->save();

        return response()->json([
            'data' => $language,
            'msg' => [
                'summary' => 'Habilidad actualizada',
                'detail' => 'El registro fue actualizado',
                'code' => '201'
            ]
        ], 201);
    }

  /*  function destroy(Language $language)
    {
        $language->delete();

        return response()->json([
            'data' => $language,
            'msg' => [
                'summary' => 'Lenguaje eliminado',
                'detail' => 'El registro fue eliminado',
                'code' => '201'
            ]
        ], 201);
    }*/
    function delete(DeleteLanguageRequest $request)
    {
        // Es una eliminación lógica
        Language::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Idioma(s) eliminada(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]], 201);
    }
    function uploadFiles(UploadFileRequest $request)
    {
        return (new FileController())->upload($request, Language::getInstance($request->input('id')));
    }

    function deleteFile($fileId)
    {
        return (new FileController())->delete($fileId);
    }

    function indexFile(IndexFileRequest $request)
    {
        return (new FileController())->index($request, Language::getInstance($request->input('id')));
    }

    function ShowFile($fileId)
    {
        return (new FileController())->show($fileId);
    }
}