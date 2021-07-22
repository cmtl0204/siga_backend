<?php

namespace App\Http\Controllers\Cecy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Cecy\Registration\DeleteRegistrationRequest;
use App\Http\Requests\Cecy\Registration\IndexRegistrationRequest;
use App\Http\Requests\Cecy\Registration\StoreRegistrationRequest;
use App\Http\Requests\Cecy\Registration\UpdateRegistrationRequest;

use App\Models\Cecy\Registration;
use App\Models\Cecy\Course;
use App\Models\Cecy\DetailPlanification;
use App\Models\Cecy\DetailRegistration;
use App\Models\Cecy\Topic;
use App\Models\App\Status;
use App\Models\App\Catalogue;
use App\Models\Authentication\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RegistrationsExport;
use App\Exports\NeedCourseExport;
use App\Exports\RegisterPothograficExport;
use App\Exports\ProgramationMensualExport;
use App\Exports\RegistrationParticipantsExport;

class RegistrationController extends Controller
{
    function index(IndexRegistrationRequest $request)
    {
        // $regitration = Registration::all();

        // return response()->json([
        //     'data' => $regitration,
        //     'msg' => [
        //         'summary' => 'success',
        //         'detail' => ''
        //     ]], 200);

            // if($request->has('search')){
            //     $registration = $registration
            // }

            $detailPlanification = DetailPlanification::with(['course'=> function ($courses){
                $courses->with(['modality'])
                ->with(['participantType'])
                ->with(['personProposal'])
                ->with(['courseType']);
            }])->get();

            return response()->json([
                'data'=>$detailPlanification,
                'msg'=>[
                    'sumary'=>'success',
                    'detail'=>''
                ]
                ],200);
    }

    function show(Registration $registration)
    {
        return response()->json([
            'data' => $registration,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code'=> '200'
            ]], 200);
    }

    function store(StoreRegistrationRequest $request)
    {
        $data = $request->json()->all();
        // $dataRegistration = $data['registration'];
        // $dataParticipant = $data['participant_id'];
        // $dataStatu = $data['status_id'];
        // $dataType = $data['type_id'];
        // $planification = Planification::find($request->input('registration.planification_id'));
        // $status = Status::find($request->input('registration.status_id'));
        // $type = Catalogue::find($request->input('registration.type_id'));
        $status = $data['registration']['status'];
        $type = $data['registration']['type'];
        

        $registration = new Registration();
         $registration->date_registration = $request->input('registration.date_registration');
        $registration->number = $request->input('registration.number');
        $registration->planification_id = $request->input('registration.planification_id');
        // $registration->status_id = $request->input('registration.status_id');
        // $registration->type_id = $request->input('registration.type_id');
        // $registration->planification()->assosiate($planification);
        $registration->status()->associate(Status::findOrFail($status['id']));
        $registration->type()->associate(Catalogue::findOrFail($type['id']));
        $registration->save();

        return response()->json([
            'data' => $registration->fresh(),
            'msg' => [
                'summary' => 'Registro actualizada',
                'detail' => 'El registro fue actualizado',
                'code' => '201'
            ]], 201);
    }

    function update(UpdateRegistrationRequest $request, Registration $registration)
    {
        $data = $request->json()->all();

        $status = $data['registration']['status'];
        $type = $data['registration']['type'];

        // $registration->date = $request->input('registration.date');
        $registration->date_registration = $request->input('registration.date_registration');
        $registration->number = $request->input('registration.number');
        $registration->planification_id = $request->input('registration.planification_id');
        // $registration->status_id = $request->input('registration.status_id');
        // $registration->type_id = $request->input('registration.type_id');
        $registration->status()->associate(Status::findOrFail($status['id']));
        $registration->type()->associate(Catalogue::findOrFail($type['id']));

        $registration->save();

        return response()->json([
            'data' => $registration->fresh(),
            'msg' => [
                'summary' => 'Registro actualizada',
                'detail' => 'El registro fue actualizado',
                'code' => '201'
            ]], 201);
    }

    function delete(DeleteRegistrationRequest $request)
    {
        Registration::destroy($request->input('ids'));

        return response()->json([
            'data' => null,
            'msg' => [
                'summary' => 'Registro(s) eliminado(s)',
                'detail' => 'Se eliminó correctamente',
                'code' => '201'
            ]], 201);
    }

    function exportTest(Request $request){
        $detailPlanification = DetailPlanification::with(['course'=> function ($courses){
            $courses->with(['modality'])
            ->with(['participantType'])
            ->with(['personProposal'])
            ->with(['courseType']);
        }])->find($request['id']);

        // return response()->json([
        //     'data'=>[
        //         'detail_planification'=>$detailPlanification
        //     ]
        //     ],200);
        $pdf = \PDF::loadView('reports.cecy.need-course', compact('detailPlanification'));
    
        return $pdf->download('Informe de nececidades del curso.pdf');
    }

    function exportRegisterParticipant(){
        $detailRegistration = DetailRegistration::with(['detailPlanification'=> function ($detailPlanification){
            $detailPlanification->with(['course'=> function($query){
                $query->with(['cantonDictate'])
                ->with(['courseType'])
                ->with(['modality']);
            }])
            ->with(['instructor' => function($instructor){
                $instructor->with(['responsible'=> function($sex){
                    $sex->with(['sex']);
                }]);
            }]);
        }])
        ->with(['additionalInformation'])
        ->with(['registration'=> function($planification){
            $planification->with(['planification'=> function($status){
                $status->with(['state']);
            }]);
        }])
        ->get();

        // return response()->json([
        //     'data'=>[
        //         'detail_registration'=>$detailRegistration
        //     ]
        //     ],200);

        $pdf = \PDF::loadView('reports.cecy.register-participant', compact('detailRegistration'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('registro de participantes.pdf');
    }

    function exportProgramationMensual(){

        $detailPlanification = DetailPlanification::with(['course'=> function($user){
            $user->with(['personProposal'=> function($addres){
                $addres->with(['Address'=> function($sector){
                    $sector->with(['sector']);
                }]);
            }])->with(['area'])->with(['courseType']);
        }])->get();

        // return response()->json([
        //     'data'=>[
        //         'detail_registration'=>$detailPlanification
        //     ]
        // ],200);

        $pdf = \PDF::loadView('reports.cecy.programation-mensual', compact('detailPlanification'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('programacion mensual.pdf');
    }

    function exportRegisterPothografic(){

        $topic = Topic::with(['course'])->with(['type'])->get();

        // return response()->json([
        //     'data'=>[
        //         'topic'=>$topic
        //     ]
        // ],200);

        $pdf = \PDF::loadView('reports.cecy.potografic-registre', compact('topic'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Registro fotografico.pdf');
    }

    // private $excel;

    // public function _construc(Excel $excel)
    // {
    //     $this->excel = $excel;
    // }

    public function exportNeedCourse(Request $request)
    {
        return Excel::download(new NeedCourseExport($request->input('id')),'need-course.xlsx');
    }

    public function exportExeclRegisterPothografic()
    {
        return Excel::download(new RegisterPothograficExport(),'registro-fotografico.xlsx');
    }

    public function exportExeclProgramationMensual()
    {
        return Excel::download(new ProgramationMensualExport(),'programacion-mensual.xlsx');
    }

    public function exportExeclRegisterParticipant()
    {
        return Excel::download(new RegistrationParticipantsExport(),'registro-participantes.xlsx');
    }
}