<?php

namespace App\Http\Controllers\Cecy;
use Maatwebsite\Excel\Excel;
use App\Exports\UserMultiSheetExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cecy\DetailRegistration\StoreDetailRegistrationRequest;
use App\Http\Requests\Cecy\DetailRegistration\IndexDetailRegistrationRequest;
use App\Http\Requests\Cecy\DetailRegistration\UpdateDetailRegistrationRequest;
use App\Http\Requests\Cecy\DetailRegistration\DeleteDetailRegistrationRequest;
use App\Models\App\Status;
use App\Exports\UsersExport;
use App\Models\Cecy\Participant;
use App\Models\Cecy\DetailRegistration;
use App\Models\App\Catalogue;
use App\Models\Cecy\Registration;
use App\Models\Cecy\DetailPlanification;
use App\Exports\DetailRegistrationExport;
use Barryvdh\DomPDF\Facade as PDF;
use App\Imports\UsersImport;
class DetailRegistrationController extends Controller
{
    private $excel;

    
     public function index(Request $request)
     {
            // Crea una instanacia del modelo Professional para poder insertar en el modelo skill.
     $registration = Registration::getInstance($request->input('registration_id'));
     if ($request->has('search')) {
         $detailRegistrations = $registration->detailRegistrations()

             ->description($request->input('search'))
             ->additional_information_id($request->input('search'))
             ->detail_planification_id($request->input('search'))
             ->status_id($request->input('search'))
             ->partial_grade($request->input('search'))
            ->final_exam($request->input('search'))
             ->code_certificate($request->input('search'))
             ->status_certificate_id($request->input('search'))
             ->certificate_withdrawn($request->input('search'))
            ->location_certificate($request->input('search'))
             ->observation($request->input('search'))
             ->paginate($request->input('per_page'));
     } else {
     $detailRegistrations = $registration->detailRegistrations()->paginate($request->input('per_page'));
    }

     if ($detailRegistrations->count() === 0) {
         return response()->json([
            'data' => null,
             'msg' => [
                 'summary' => 'No se encontraron Habilidades',
                 'detail' => 'Intente de nuevo',
                 'code' => '404'
             ]], 404);
     }

     return response()->json($detailRegistrations, 200); 
     }


    public function show()
    {

        $detailRegistration = DetailRegistration::all();
        return response()->json([
            'data' => $detailRegistration,
            'msg' => [
                'summary' => 'success',
                'detail' => '',
                'code' => '200'
            ]], 200); 
    }


    public function store(StoreDetailRegistrationRequest $request)
    {

        $data = $request -> json() ->all ();
        //return $data;
        $status = $data["detailRegistration"] ["status"];
        $status_certificate = $data["detailRegistration"] ["status_certificate"];
       // Crea una instanacia del modelo Professional para poder insertar en el modelo skill.
       //$registration = Registration::getInstance($request->input('registration.id'));

       // Crea una instanacia del modelo Catalogue para poder insertar en el modelo skill.
       //$status = Catalogue::getInstance($request->input('status.id'));

       $detailRegistration = new DetailRegistration();
       $detailRegistration->partial_grade = $request->input('detailRegistration.partial_grade');
       $detailRegistration->final_exam = $request->input('detailRegistration.final_exam');
       $detailRegistration->code_certificate = $request->input('detailRegistration.code_certificate');
       $detailRegistration->certificate_withdrawn = $request->input('detailRegistration.certificate_withdrawn');
       $detailRegistration->location_certificate = $request->input('detailRegistration.location_certificate');
       $detailRegistration->observation = $request->input('detailRegistration.observation');
       $detailRegistration->additional_information_id = $request->input('detailRegistration.additional_information_id');
       $detailRegistration->detail_planification_id = $request->input('detailRegistration.detail_planification_id');
       $detailRegistration->registration_id = $request->input('detailRegistration.registration_id');
       //$detailRegistration->registration()->associate($registration);
       //$detailRegistration->additionalInformation()->associate($additionalInformation);
       //$detailRegistration->detailPlanification()->associate($detailPlanification);
       $detailRegistration->status()->associate (Status::findOrFail($status["id"]));
       $detailRegistration->statusCertificate()->associate(Catalogue::findOrFail($status_certificate["id"]));
       $detailRegistration->save();

       return response()->json([
           'data' => $detailRegistration,
           'msg' => [
               'summary' => 'Detalle creado',
               'detail' => 'El registro fue creado',
               'code' => '201'
           ]], 201); 
    }

    public function update(UpdateDetailRegistrationRequest $request, DetailRegistration $detailRegistration)
    {
        $data = $request -> json() ->all ();
        //return $data;
        $status = $data["detailRegistration"] ["status"];
        $status_certificate = $data["detailRegistration"] ["status_certificate"];
       // Crea una instanacia del modelo Professional para poder insertar en el modelo skill.
       //$registration = Registration::getInstance($request->input('registration.id'));

       // Crea una instanacia del modelo Catalogue para poder insertar en el modelo skill.
       //$status = Catalogue::getInstance($request->input('status.id'));

       //$detailRegistration = new DetailRegistration();
       $detailRegistration->partial_grade = $request->input('detailRegistration.partial_grade');
       $detailRegistration->final_exam = $request->input('detailRegistration.final_exam');
       $detailRegistration->code_certificate = $request->input('detailRegistration.code_certificate');
       $detailRegistration->certificate_withdrawn = $request->input('detailRegistration.certificate_withdrawn');
       $detailRegistration->location_certificate = $request->input('detailRegistration.location_certificate');
       $detailRegistration->observation = $request->input('detailRegistration.observation');
       $detailRegistration->additional_information_id = $request->input('detailRegistration.additional_information_id');
       $detailRegistration->detail_planification_id = $request->input('detailRegistration.detail_planification_id');
       $detailRegistration->registration_id = $request->input('detailRegistration.registration_id');



       //$detailRegistration->registration()->associate($registration);
       //$detailRegistration->additionalInformation()->associate($additionalInformation);
       //$detailRegistration->detailPlanification()->associate($detailPlanification);
       $detailRegistration->status()->associate (Status::findOrFail($status["id"]));
       $detailRegistration->statusCertificate()->associate(Catalogue::findOrFail($status_certificate["id"]));
       $detailRegistration->save();

       return response()->json([
           'data' => $detailRegistration,
           'msg' => [
               'summary' => 'Detalle creado',
               'detail' => 'El registro fue creado',
               'code' => '201'
           ]], 201); 
    }

    function delete(DeleteDetailRegistrationRequest $request)
    {
        DetailRegistration::destroy($request->input("ids")); 
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


    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
    }
    public function exportAprobados()
    {
         return $this->excel->download(new UserMultiSheetExport(2020), 'users.xlsx');


    }

     public function exportCertificados(Request $request){ 
     	$users = $detailRegistration = DetailRegistration::
          with(['registration' => function ($registration) use ($request) {
              $registration->with('participant', function ($participant) use ($request) {
                  $participant->with('user', function ($user) use ($request){
                      $user    ;
                  });
              });
          }])

          ->with(['detailPlanification' => function ($detailplanification) use ($request) {
             $detailplanification->with('course', function ($course) use ($request) {
                 $course;
                
             });
         }])
        ->get();
    	 $pdf   = PDF::loadView('pdf.certificado', compact('users'))->setPaper('a4', 'landscape');
     	 return $pdf->download('Certificado.pdf');
    }


    public function exportCertificadosI(Request $request , $id){ 
    	$users = DetailRegistration::
          with(['registration' => function ($registration) use ($request) {
             $registration->with('participant', function ($participant) use ($request) {
                  $participant->with('user', function ($user) use ($request){
                     $user    ;
                 });
              });
          }])

          ->with(['detailPlanification' => function ($detailplanification) use ($request) {
             $detailplanification->with('course', function ($course) use ($request) {
                 $course;
                
             });
         }])
    ->find($id);
        // // creamos y almacenamos la vista
         $vista = view('pdf.certificadoI')
                ->with('users', $users);

         //Generamos el pdf pasandole la vista
        $pdf = PDF::loadHTML($vista)->setPaper('a4', 'landscape');

        // // retornamos la salida del pdf
        return $pdf->download('Certificado.pdf');
    }



    public function importar(Request $request)
    {
        $file = $request->file('file')->store('import');
         $import = new UsersImport;
         $import->import($file);   
    }
}

