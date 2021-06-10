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
        $instructors = Instructor ::all();


    return response()->json([
        'data' => $instructors,
        'msg' => [
            'summarry' => 'success',
            'detail' =>''
        ]], 200);
        
    }

    public function show(Instructor $instructor )
    {
        return response()->json([
            'data' => $instructor,
            'msg' => [
                'summarry' => 'success',
                'detail' =>'',
                'code' =>''
            ]], 200);

        
    }

    public function store()
    {
    
        $$instructor ->save();

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'No se encontraró al profesional',
                'detail' => 'Intente de nuevo',
                'code' => '404'
            ]], 404);

        
    }

    public function update()
    {

        
    }

    public function delete()
    {
//        
    }
}
