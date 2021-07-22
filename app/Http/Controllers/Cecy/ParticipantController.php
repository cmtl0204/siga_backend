<?php

namespace App\Http\Controllers\Cecy;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cecy\Participant\IndexParticipantRequest;
use App\Models\Authentication\User;
use App\Models\Cecy\Participant;

class ParticipantController extends Controller
{
    
    function index(IndexParticipantRequest $request)
    {
        
        $user = User::getInstance($request->input('user_id'));

        if ($request->has('search')) {
            $participant = $user->participants()
                ->description($request->input('search'))
                ->paginate($request->input('per_page'));
        } else {
            $participant = participant::paginate($request->input('per_page'));
        }
    
        if ($participant->count() === 0) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'No se encontraron instructores',
                    'detail' => 'Intente de nuevo',
                    'code' => '404'
                ]], 404);
        }
    
        return response()->json($participant, 200);
        
    }

    function show(Participant $participant )
    {
        return response()->json([
            'data' => $participant,
            'msg' => [
                'summarry' => 'success',
                'detail' =>'',
                'code' =>''
            ]], 200);

        
    }

    

    

    
}
