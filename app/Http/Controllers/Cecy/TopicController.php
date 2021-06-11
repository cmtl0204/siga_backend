<?php

namespace App\Http\Controllers\Cecy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Cecy\Registration\DeleTopicRequest;
use App\Http\Requests\Cecy\Registration\IndexTopicRequest;
use App\Http\Requests\Cecy\Registration\StoreTopicRequest;
use App\Http\Requests\Cecy\Registration\UpdateTopicRequest;

use App\Models\Cecy\Topic;
// use App\Models\JobBoard\Category;
// use App\Models\JobBoard\Professional;
use App\Exports\TopicsExport;

class TopicController extends Controller
{
    function index(IndexTopicRequest $request)
    {
        // Crea una instanacia del modelo Professional para poder insertar en el modelo skill.
        $parentCode = ParentCode::getInstance($request->input('parent_code_id'));
    
        if ($request->has('search')) {
            $topic = $parentCode->topic()
                ->description($request->input('search'))
                ->paginate($request->input('per_page'));
        } else {
            $topic = $parentCode->topic()->paginate($request->input('per_page'));
        }

        if ($topics->count() === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron Habilidades',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]], 404);
        }
    
        return response()->json($topics, 200);
    }
    function show(Topic $topic)
    {
        return response()->json([
            'data' => $topic,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code'=> '200'
            ]], 200);
    }

    function store(StoreTopicRequest $request)
    {
       // Crea una instanacia del modelo Professional para poder insertar en el modelo skill.
       $parentCode = ParentCode::getInstance($request->input('parent_code.id'));

       // Crea una instanacia del modelo Catalogue para poder insertar en el modelo skill.
       $type = Catalogue::getInstance($request->input('type.id'));

        $topic = new Topic();
        $topic->description = $request->input('topic.description');
        $topic->course()->associate($course);
        $topic->type()->associate($type);
        $topic->save();

        return response()->json([
            'data' => $topic->fresh(),
            'msg' => [
                'summary' => 'Habilidad creada',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]], 201);
    }

    function update(UpdateTopicRequest $request, Topic $topic)
    {
        // Crea una instanacia del modelo Catalogue para poder insertar en el modelo skill.
        $type = Catalogue::getInstance($request->input('topic.type.id'));

        $topic->description = $request->input('topic.description');
        $topic->course()->associate($course);
        $topic->type()->associate($type);
        $topic->save();

        return response()->json([
            'data' => $skill->fresh(),
            'msg' => [
                'summary' => 'Habilidad actualizada',
                'detail' => 'El registro fue actualizado',
                'code' => '201'
            ]], 201);
    }

    function destroy(Skill $skill)
    {
        // Es una eliminación lógica
        $skill->delete();

        return response()->json([
            'data' => $skill,
            'msg' => [
                'summary' => 'Habilidad eliminada',
                'detail' => 'El registro fue eliminado',
                'code' => '201'
            ]], 201);
    }

    function uploadImages(UploadImageRequest $request)
    {
        return (new ImageController())->upload($request, Skill::getInstance($request->input('id')));
    }

    function updateImage(UpdateImageRequest $request, $imageId)
    {
        return (new ImageController())->update($request, $imageId);
    }

    function deleteImage($imageId)
    {
        return (new ImageController())->delete($imageId);
    }

    function indexImage(IndexImageRequest $request)
    {
        return (new FileController())->index($request, Skill::getInstance($request->input('id')));
    }

    function ShowImage($fileId)
    {
        return (new FileController())->show($fileId);
    }

    function uploadFiles(UploadFileRequest $request)
    {
        return (new FileController())->upload($request, Skill::getInstance($request->input('id')));
    }

    function updateFile(UpdateFileRequest $request, $fileId)
    {
        return (new FileController())->update($request, $fileId);
    }

    function deleteFile($fileId)
    {
        return (new FileController())->delete($fileId);
    }

    function indexFile(IndexFileRequest $request)
    {
        return (new FileController())->index($request, Skill::getInstance($request->input('id')));
    }

    function ShowFile($fileId)
    {
        return (new FileController())->show($fileId);
    }
}
