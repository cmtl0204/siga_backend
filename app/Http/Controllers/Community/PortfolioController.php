<?php

namespace App\Http\Controllers\Community;

// Controllers
use App\Http\Controllers\Controller;
use App\Http\Requests\App\Image\UploadImageRequest;
use App\Http\Requests\Community\Portfolio\PortfolioFirstDocRequest;
use App\Http\Requests\Community\Portfolio\PortfolioSecondDocRequest;
use App\Http\Requests\Community\Portfolio\VinculationRequestDocRequest;
use PDF;
use Intervention\Image\Facades\Image as InterventionImage;
use Illuminate\Support\Facades\Storage;

// PortfolioRequest

class PortfolioController extends Controller 
{

    private $storagePath;

    public function __construct()
    {
        $this->storagePath = storage_path('app\private\images\\');
    }

    public function downloadPortfolioFirstDocument(PortfolioFirstDocRequest $request)
    {
        $name = $request->input('name');
        $identification = $request->input('ci');
        $career = $request->input('career.name');
        $level = $request->input('level');
        $entity = $request->input('entity');
        $institution = $request->input('institution');
        $teacher = $request->input('teacher');

        $logo = $request->input('logo');
        $logo = $this->handleLogo($logo);
        $size = 0;
        if ($logo == "bj.png" || $logo == "y.png") {
            $size = 115;
        } else {
            $size = 60;
        }

        $data = ['name' => $name, 'identification' => $identification, 'career' => $career,
                 'level' => $level, 'entity' => $entity, 'institution' => $institution,
                 'logo' => $logo, 'size' => $size, 'teacher' => $teacher,];

        // share data to view
        view()->share('community/carta-compromiso-vinculacion-pdf', $data);
        $pdf = PDF::loadView('community/carta-compromiso-vinculacion-pdf', $data);
        return $pdf->download('1. CARTA COMPROMISO VINCULACION.pdf');
    }

    public function downloadPortfolioSecondDocument(PortfolioSecondDocRequest $request, UploadImageRequest $image_request)
    {
        Storage::deleteDirectory('images\\' . 'temp');

        $receiver = $request->input('receiver');
        $sender = $request->input('sender');
        $project = $request->input('project');
        $start_date = $request->input('start_date');
        $identification = $request->input('ci');
        $career = $request->input('career');
        $description = $request->input('description');
        $image = $image_request->file('image');

        $logo = $request->input('logo');
        $logo = $this->handleLogo($logo);
        $size = 0;
        if ($logo == "bj.png" || $logo == "y.png") {
            $size = 115;
        } else {
            $size = 60;
        }

        $fullDate = strtotime($start_date);
        $day = date("d", $fullDate);
        $month = date("M", $fullDate);
        $month = $this->handleMonthName($month);

        $data = ['identification' => $identification, 'career' => $career,
                 'receiver' => $receiver, 'sender' => $sender, 'project' => $project,
                 'start_date' => $start_date, 'description' => $description, 'image' => $image,
                 'day' => $day, 'month' => $month, 'logo' => $logo, 'size' => $size,];



        Storage::makeDirectory('images\\' . 'temp');

        $this->uploadOriginal(InterventionImage::make($image), 'temp');



        // share data to view
        view()->share('community/informe-inicio-pdf', $data);
        $pdf = PDF::loadView('community/informe-inicio-pdf', $data);
        
        // Elimina los archivos del servidor
        return $pdf->download('2. Informe de inicio de proyectos por parte del tutor del proyecto.pdf');
    }

    private function handleLogo($logo)
    {
        switch ($logo) {
            case 'institutions/1.png':
                $logo = 'bj.png';
                break;
            case 'institutions/2.png':
                $logo = 'y.png';
                break;
            case 'institutions/3.png':
                $logo = '24m.jpg';
                break;
            case 'institutions/4.png':
                $logo = 'gc.png';
                break;
            default:
                break;
        }
        return $logo;
    }

    private function handleMonthName($month)
    {
        switch ($month) {
            case 'Jan':
                $month = 'Enero';
                break;
            case 'Feb':
                $month = 'Febrero';
                break;
            case 'Mar':
                $month = 'Marzo';
                break;
            case 'Apr':
                $month = 'Abril';
                break;
            case 'May':
                $month = 'Mayo';
                break;
            case 'Jun':
                $month = 'Junio';
                break;
            case 'Jul':
                $month = 'Julio';
                break;
            case 'Aug':
                $month = 'Agosto';
                break;
            case 'Sep':
                $month = 'Septiembre';
                break;
            case 'Oct':
                $month = 'Octubre';
                break;
            case 'Nov':
                $month = 'Noviembre';
                break;
            case 'Dec':
                $month = 'Diciembre';
                break;
            default:
                break;
        }
        return $month;
    }

    // Guarda imagenes con su tamaño original
    private function uploadOriginal($image, $name)
    {
        $path = $this->storagePath . $name . '\\' . $name . '.jpg';
        $image->save($path, 75);
    }

    public function downloadVinculationRequestDocument(VinculationRequestDocRequest $request)
    {
        $name = $request->input('name');
        $identification = $request->input('ci');
        $career = $request->input('career.name');
        $date = $request->input('date');
        $institution = $request->input('institution');
        
        $fullDate = strtotime($date);
        $day = date("d", $fullDate);
        $month = date("M", $fullDate);
        $month = $this->handleMonthName($month);

        $logo = $request->input('logo');
        $logo = $this->handleLogo($logo);
        $size = 0;
        if ($logo == "bj.png" || $logo == "y.png") {
            $size = 115;
        } else {
            $size = 60;
        }

        $data = ['name' => $name, 'identification' => $identification, 'career' => $career,
                 'logo' => $logo, 'size' => $size, 'month' => $month,
                 'day' => $day, 'institution' => $institution];

        // share data to view
        view()->share('community/solicitud-vinculacion-pdf', $data);
        $pdf = PDF::loadView('community/solicitud-vinculacion-pdf', $data);
        return $pdf->download('SOLICITUD_VINCULACION.pdf');
    }

}
