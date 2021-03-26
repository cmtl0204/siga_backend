<?php

namespace App\Http\Controllers\App;

use App\Events\ChatEvent;
use App\Events\DirectChatEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function sendAll(Request $request)
    {
        broadcast(new ChatEvent($request->message))->toOthers();
        return response()->json(['data' => null,
            'msg' => [
                'summary' => 'Mensaje Enviado',
                'detail' => '',
                'code' => '201',
            ]], 201);
    }

    public function sendDirect(Request $request)
    {
        event(new DirectChatEvent($request->data));
        return response()->json(['data' => null,
            'msg' => [
                'summary' => 'Mensaje Directo Enviado',
                'detail' => '',
                'code' => '201',
            ]], 201);
    }
}
