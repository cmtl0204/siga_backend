<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\App\Status;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        if ($request->user()->status_id === Status::where('code', $catalogues['status']['inactive'])->first()->id) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Su usuario se encuentra inactivo',
                    'detail' => 'Comuníquese con el administrador',
                    'code' => '4030'
                ]
            ], 403);
        }

        if ($request->user()->status_id === Status::where('code', $catalogues['status']['locked'])->first()->id) {
            return response()->json([
                'data' => null,
                'msg' => [
                    'summary' => 'Su usuario se encuentra bloqueado',
                    'detail' => 'Comuníquese con el administrador',
                    'code' => '423'
                ]
            ], 423);
        }
        return $next($request);
    }
}
