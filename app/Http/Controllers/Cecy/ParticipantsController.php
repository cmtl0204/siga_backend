<?php

namespace App\Http\Controllers\Cecy;

// Controllers
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Cecy\Participants\IndexParticipantsRequest;


use App\Models\Cecy\Participant;
use App\Models\Authentication\User;
use App\Models\App\Catalogue;




//Form Request


class ParticipantsController extends Controller
{

  function index(IndexParticipantsRequest $request)
  {
      $participants = Participant::all();

      return response()->json([
          'data' => $participants,
          'msg' => [
              'summary' => 'success',
              'detail' => ''
          ]], 200);
  }
    // obtener un único objeto o registro
    function show(Participant $participants){
      $participants = Participant::all();

      return response()->json([
        'data' => $participants,
        'msg' => [
            'summary' => 'success',
            'detail' => '',
            'code'=> '200'
        ]], 200);
    }

    
}
