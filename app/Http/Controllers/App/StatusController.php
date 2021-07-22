<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\App\Status;
use Illuminate\Http\Request;
use App\Http\Requests\App\Status\IndexStatusRequest;

class StatusController extends Controller
{
    
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index(IndexStatusRequest $request)
        {
            // nombre, modalidad,
           // $status = Status::with('name')
             //   ->get();
             if ($request->has('search')) {
                $status = Status::title($request->input('search'))
                    ->description($request->input('search'));
            } else {
                $status = Status::all();
            }
            if ($status->count() == 0) {
                return response()->json([
                    'data' => null,
                    'msg' => [
                        'summary' => 'No se encontraron Status',
                        'detail' => 'Intentalo de nuevo',
                        'code' => '404'
                    ]
                ], 404);
            }
            else{
                return response()->json([
                    'data' => $status,
                    'msg' => [
                        'code' => '200'
                    ]
                ], 200);
            }
        }
    
        
    
        /**
         * Store a newly created resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        {
            //
        }
    
        /**
         * Display the specified resource.
         *
         * @param \App\Status $status
         * @return \Illuminate\Http\Response
         */
        public function show(Status $status)
        {
            //
        }
    
        /**
         * Update the specified resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         * @param \App\Status $status
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, Status $status)
        {
            //
        }
    
        /**
         * Remove the specified resource from storage.
         *
         * @param \App\Status $status
         * @return \Illuminate\Http\Response
         */
        public function destroy(Status $status)
        {
            //
        }
    //
}
