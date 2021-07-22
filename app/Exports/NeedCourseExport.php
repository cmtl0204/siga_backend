<?php

namespace App\Exports;

// use App\Registration;
use App\Models\Cecy\DetailPlanification;
// use App\Models\Cecy\Course;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class NeedCourseExport implements FromView
{
    use Exportable;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    // public $detailPlanification;

    // public function __construct(DetailPlanification $detailPlanification)
    // {
    //     $this->detailPlanification->id = $detailPlanificationId;
    // }

    public function view(): View
    {
        // $course = Course::find(1);
        $detailPlanification = DetailPlanification::with(['course'=> function ($courses){
                    $courses->with(['modality'])
                    ->with(['participantType'])
                    ->with(['personProposal'])
                    ->with(['courseType']);
                }])->find($this->id);
        return view('reports.cecy.need-course', 
        [
            //data que quiero generar
            // 'course' => $course,
            'detailPlanification' => $detailPlanification
        ]);
        
    }

    // public function collection(){
    //     return DetailPlanification::with(['course'=> function ($courses){
    //         $courses->with(['modality'])
    //         ->with(['participantType'])
    //         ->with(['personProposal'])
    //         ->with(['courseType']);
    //     // }])->find($request['id']);
    //     }])->get();
    // }

    // public function map($course): array
    // {
    //     return [
    //         $course->id,
    //         $course->course->name
    //     ];
    // }

    // public function headings(): array
    // {
    //     return [
    //         'Nro',
    //         'Cursos'
    //     ];
    // }

    // public function drawings()
    // {
    //     $drawing = new Drawing();
    //     $drawing->setName('logo');
    //     $drawing->setDescription('This is my logo');
    //     $drawing->setPath(public_path('/2.png'));
    //     $drawing->setHeight(90);
    //     $drawing->setCoordinates('D2');

    //     return $drawing;
    // }

    // public function startCell(): string
    // {
    //     return 'AB';
    // }

    // public function title(): string 
    // {
    //     return DateTime::createFromFormat('1m', $this->month)->format('F');
    // }

    // public function styles(Worksheet $sheet) 
    // {
    //     $styleArray = [
    //         'borders'=>[
    //             'outline'=>[
    //                 'borderStyle'=> \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
    //                 'color'=> ['argb'=>'000000'],
    //             ],
    //         ],
    //     ];
    //     $sheet->getStyle('B2')->getFont()->setName('Calibri');
    //     $sheet->getStyle('A1:E7')->applyFromArray($styleArray);
    //     $sheet->getStyle('A1:E30')->applyFromArray($styleArray);
    //     $sheet->getStyle('B2')->getFont()->setBold(true);
    //     $sheet->getStyle('A8')->getFont()->setBold(true);
    //     $sheet->getStyle('B8')->getFont()->setBold(true);
    //     $sheet->getStyle('C8')->getFont()->setBold(true);
    //     $sheet->getStyle('D8')->getFont()->setBold(true);

    //     $sheet->setSelectedCell('A1:E1', function($cells){
    //         $cells->setBackground('#3490ED');
    //     });

    //     $sheet
    //     ->setCellValue('B2', 'Instituto Superior Tecnologico Yavirac')
    //     ->setCellValue('B6', 'Registro de entrega de certificados de necesidades del curso')
    //     ->setCellValue('B7', 'Formadores modalidad dual')
    //     ->setCellValue('A8', 'Nro')
    //     ->setCellValue('B8', 'CUrso');
    // }
}
