<?php

namespace App\Http\Controllers\Cecy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Cecy\Topic\DeleteTopicRequest;
use App\Http\Requests\Cecy\Topic\IndexTopicRequest;
use App\Http\Requests\Cecy\Topic\StoreTopicRequest;
use App\Http\Requests\Cecy\Topic\UpdateTopicRequest;


use App\Models\App\Catalogue;
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

        public function store(StoreTopicRequest $request)
    {
        $data = $request -> json() -> all();
        $type  = $data ['topics'] ['type'];
       // Crea una instanacia del modelo Professional para poder insertar en el modelo skill.
       //$parentCode = ParentCode::getInstance($request->input('parent_code.id'));

       // Crea una instanacia del modelo Catalogue para poder insertar en el modelo skill.
       //$type = Catalogue::getInstance($request->input('type.id'));

        $topic = new Topic();
        
        $topic->description = $request->input('topics.description');
        $topic->parent_code_id = $request->input('topics.parent_code_id');
        $topic->course_id = $request -> input ('topics.course_id');
        $topic->type()->associate(Catalogue::findOrFail($type['id']));
        $topic->save();

        return response()->json([
            'data' => $topic->fresh(),
            'msg' => [
                'summary' => 'Topic creada',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]], 201);
    }

    function update(UpdateTopicRequest $request, Topic $topic)
    {
        $data = $request -> json() -> all();
        $type  = $data ['topics'] ['type'];
       // Crea una instanacia del modelo Professional para poder insertar en el modelo skill.
       //$parentCode = ParentCode::getInstance($request->input('parent_code.id'));

       // Crea una instanacia del modelo Catalogue para poder insertar en el modelo skill.
       //$type = Catalogue::getInstance($request->input('type.id'));


        $topic->description = $request->input('topics.description');
        $topic->parent_code_id = $request->input('topics.parent_code_id');
        $topic->course_id = $request -> input ('topics.course_id');
        $topic->type()->associate(Catalogue::findOrFail($type['id']));
        $topic->save();

        return response()->json([
            'data' => $topic->fresh(),
            'msg' => [
                'summary' => 'Topic creada',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]], 201);
    }

    function delete(DeleteTopicRequest $request)
    {
        Topic::destroy($request->input("ids"));
        // Es una eliminación lógica
        //$topic->delete();

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Topic eliminada',
                'detail' => 'El registro fue eliminado',
                'code' => '201'
            ]], 201);
    }
}


    