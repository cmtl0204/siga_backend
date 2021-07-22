<?php
// controlers
namespace App\Http\Controllers\Cecy;

use App\Http\Controllers\Controller;


use Illuminate\Http\Request;

use App\Http\Requests\Cecy\Instructor\DeleteInstructorRequest;
use App\Http\Requests\Cecy\Instructor\IndexInstructorRequest;
use App\Http\Requests\Cecy\Instructor\StoreInstructorRequest;
use App\Http\Requests\Cecy\Instructor\UpdateInstructorRequest;

//models
use App\Models\App\Catalogue;
use App\Models\Authentication\User;
use App\Models\Cecy\Instructor;





class InstructorController extends Controller
{
    function index(IndexInstructorRequest $request)
    {
        
        $user = User::getInstance($request->input('user_id'));

        if ($request->has('search')) {
            $instructor = $user->instructors()
                ->description($request->input('search'))
                ->paginate($request->input('per_page'));
        } else {
            $instructor = instructor::paginate($request->input('per_page'));
        }
    
        if ($instructor->count() === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron instructores',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]], 404);
        }
    
        return response()->json($instructor, 200);
        
    }

    function show(Instructor $instructor )
    {
        return response()->json([
            'data' => $instructor,
            'msg' => [
                'summarry' => 'success',
                'detail' =>'',
                'code' =>''
            ]], 200);

        
    }

    public function store(StoreInstructorRequest $request)
    {
    
        // Crea una instanacia del modelo Professional para poder insertar en el modelo instructor.
       // $user = User::getInstance($request->input('user.id'));
       $data = $request -> json() ->all ();
       $user  = $data ['instructor'] ['user'];
       $responsible  = $data ['instructor'] ['responsible'];
       $type_instructor  = $data ['instructor'] ['type_instructor'];
        // Crea una instanacia del modelo Catalogue para poder insertar en el modelo instructor.
        //$type = Catalogue::getInstance($request->input('type.instructor.id'));

        $instructor = new Instructor();
        //$instructor->type()->associate(Catalogue::findOrFail($type["id"]));
        $instructor->user()->associate(User::findOrFail($user["id"]));
        $instructor->responsible()->associate(User::findOrFail($responsible["id"]));
        $instructor->typeInstructor()->associate(Catalogue::findOrFail($type_instructor["id"]));
        $instructor->save();


        return response()->json([
            'data' => $instructor,
            'msg' => [
                'summary' => 'Instructor creado',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]], 201);



        
    }

    public function update(UpdateInstructorRequest $request, Instructor $instructor)
    {
        // Crea una instanacia del modelo Catalogue para poder insertar en el modelo instructor.
        $data = $request -> json() ->all ();
       $user  = $data ['instructor'] ['user'];
       $responsible  = $data ['instructor'] ['responsible'];
       $type_instructor  = $data ['instructor'] ['type_instructor'];
        // Crea una instanacia del modelo Catalogue para poder insertar en el modelo instructor.
        //$type = Catalogue::getInstance($request->input('type.instructor.id'));

        
        //$instructor->type()->associate(Catalogue::findOrFail($type["id"]));
        $instructor->user()->associate(User::findOrFail($user["id"]));
        $instructor->responsible()->associate(User::findOrFail($responsible["id"]));
        $instructor->typeInstructor()->associate(Catalogue::findOrFail($type_instructor["id"]));
        $instructor->save();


        return response()->json([
            'data' => $instructor,
            'msg' => [
                'summary' => 'Instructor actulizado',
                'detail' => 'El registro fue creado',
                'code' => '201'
            ]], 201);

        
    }

    function delete(DeleteInstructorRequest $request)
    {
        Instructor::destroy($request->input("ids")); 
        // Es una eliminación lógica
        //$detailRegistration->delete();

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Detalle(es) eliminado(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]], 201);
    }
}
