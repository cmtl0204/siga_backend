<?php

namespace App\Exports;

use App\Models\Cecy\DetailRegistration;
use App\Models\Cecy\Instructor;
use App\Models\Cecy\Registration;
use DateTime;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMappedCells;
class DetailRegistrationExport implements
    FromCollection,
    ShouldAutoSize,
    WithMapping,
    WithHeadings,
    WithDrawings,
    WithCustomStartCell,
    WithTitle,
    WithStyles,

    WithColumnWidths
{
    use Exportable;

    private $year;
    public $user;
    private $month;
    public $instructor;
    public $date_start;
    public $date_end;
    public function __construct(int $year, int $month )
    {
        $this->year = $year;
        $this->month = $month;


        
    }


    public function collection(){

        return DetailRegistration::with(['registration' => function ($registration){ 
            $registration->with('participant', function ($participant) {
                $participant->with('user', function ($user){
                    $user    ;
                });
            });
        }])
        ->with(['detailPlanification' => function ($detailPlanification) {
            $detailPlanification
            ->with('course', function ($course) {
                $course;
            });
        }])
        ->with(['detailPlanification' => function ($detailPlanification) {
            $detailPlanification
            ->with('instructor', function ($instructor) {
                $instructor->with('user', function ($user){
                    $user    ;
                });
            });
        }])
        ->get();
    }

    public function map($user): array
    {
        $this->user= $user->detailPlanification->course->name;
        $this->instructor= $user->detailPlanification->instructor->user->first_name;
        $this->date_start= $user->detailPlanification->date_start;
        $this->date_end= $user->detailPlanification->date_end;

        return [
            $user->id ,
            $user->registration->participant->user->partial_name,
            $user->registration->participant->user->partial_lastname,
            $user->registration->participant->user->identification,
            '',
            '',
            '',
            '',
            $user->registration->participant->user->email,
        ];
    }

    public function headings(): array
    {
        return [
            'No.',
            'Nombres',
            'Apellidos',
            'Número de Cédula ',
            'Autodefinición ',
            'Posee alguna Discapacidad',
            'Género ',
            'Edad ',
            'Correo Electrónico ',
            'Código '
        ];
    }
    public function columnWidths(): array
    {
        return [
            'A' =>5,
            'B' =>25,  
            'D' => 25, 
            'C' => 20,  
            'G' => 15, 
            'J' => 35,         
        ];
    }


    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/2.png'));
        $drawing->setHeight(90);
        $drawing->setWidth(90);
        $drawing->setCoordinates('E8');

        return $drawing;
    }

    public function startCell(): string
    {
        return 'A15';
    }

    public function title(): string
    {
        return DateTime::createFromFormat('!m', $this->month)->format('F');
    }


    public function styles(Worksheet $sheet )
    {
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '#333538'],
                ],
            ],
            
            
        ];
        $styleArray1 = [
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => [
                    'argb' => '2a6478',
                ],
                'endColor' => [
                    'argb' => '2a6478',
                ],
            ],
             //Set font style
             'font' => [
                'name'      =>  'Calibri',
                'size'      =>  11,
                'bold'      =>  false,
                'color' => ['argb' => 'FFFFFF'],
            ],
        ];
        $styleArray2 = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => [
                    'argb' => '2a6478',
                ],
                'endColor' => [
                    'argb' => '2a6478',
                ],
            ],
        //Set font style
        'font' => [
            'name'      =>  'Calibri',
            'size'      =>  11,
            'bold'      =>  true,
            'color' => ['argb' => 'FFFFFF'],
        ],
          
        ];

        $styleArray3 = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => [
                    'argb' => '2a6478',
                ],
                'endColor' => [
                    'argb' => '2a6478',
                ],
            ],
        //Set font style
        'font' => [
            'name'      =>  'Calibri',
            'size'      =>  11,
            'bold'      =>  true,
            'color' => ['argb' => 'FFFFFF'],
        ],
          
        ];
        $styleArray4 = [
           
                'borders' => [
                    'horizontal' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '#333538'],
                    ],
                ],
                
                
        //Set font style
        'font' => [
            'name'      =>  'Calibri',
            'size'      =>  11,
            'bold'      =>  true,
            'color' => ['argb' => 'FFFFFF'],
        ],
          
        ];
        $styleArray5 = [
           
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '#333538'],
                ],
            ],
            'font' => [
                'name'      =>  'Calibri',
                'size'      =>  11,
                'bold'      =>  true,
                'color' => ['argb' => 'FFFFFF'],
            ],
      
         ];
         $styleArray6 = [
           
            'borders' => [
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '#333538'],
                ],
            ],
            'font' => [
                'name'      =>  'Calibri',
                'size'      =>  11,
                'bold'      =>  true,
                'color' => ['argb' => 'FFFFFF'],
            ],
      
         ];
         $styleArray7 = [
           
            'borders' => [
                'right' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '#333538'],
                ],
            ],
            'font' => [
                'name'      =>  'Calibri',
                'size'      =>  11,
                'bold'      =>  true,
                'color' => ['argb' => 'FFFFFF'],
            ],
      
         ];
         $styleArray8 = [
            'font' => [
                'name'      =>  'Calibri',
                'size'      =>  11,
                'bold'      =>  false,
                'color' => ['argb' => '000000'],
            ],
      
         ];
        $sheet->getStyle('B2')->getFont()->setName('Bahnschrift');
         $sheet->getStyle('A15:J15')->applyFromArray($styleArray1);
          $sheet->getStyle('A15:J45')->applyFromArray($styleArray);
          $sheet->getStyle('A2:G2')->applyFromArray($styleArray2);
          $sheet->getStyle('A3:G3')->applyFromArray($styleArray2);
          $sheet->getStyle('A4:G4')->applyFromArray($styleArray2);
          $sheet->getStyle('B8')->applyFromArray($styleArray3);
          $sheet->getStyle('B9')->applyFromArray($styleArray3);
          $sheet->getStyle('B10')->applyFromArray($styleArray3);
          $sheet->getStyle('B11')->applyFromArray($styleArray3);
          $sheet->getStyle('B12')->applyFromArray($styleArray3);
          $sheet->getStyle('B13')->applyFromArray($styleArray3);
          $sheet->getStyle('F8')->applyFromArray($styleArray3);
          $sheet->getStyle('F9')->applyFromArray($styleArray3);
          $sheet->getStyle('F10')->applyFromArray($styleArray3);
          $sheet->getStyle('G7')->applyFromArray($styleArray3);
          $sheet->getStyle('C8:D13')->applyFromArray($styleArray4);
          $sheet->getStyle('C8:D13')->applyFromArray($styleArray5);
          $sheet->getStyle('C13:D13')->applyFromArray($styleArray6);
          $sheet->getStyle('D8:D13')->applyFromArray($styleArray7);
          $sheet->getStyle('G9:G8')->applyFromArray($styleArray5);
          $sheet->getStyle('G10')->applyFromArray($styleArray6);
          $sheet->getStyle('G8:G10')->applyFromArray($styleArray7);
          $sheet->getStyle('C8:D13')->applyFromArray($styleArray8);

        //  $sheet->getStyle('B2')->getFont()->setBold(true);
        //  $sheet->getStyle('B6')->getFont()->setBold(true);
        //  $sheet->getStyle('B7')->getFont()->setBold(true);
        //  $sheet->getStyle('A8')->getFont()->setBold(true);
        //  $sheet->getStyle('B8')->getFont()->setBold(true);
        //  $sheet->getStyle('C8')->getFont()->setBold(true);
        //  $sheet->getStyle('D8')->getFont()->setBold(true);

     

          $sheet

          ->setCellValue('C2', 'DIRECCIÓN DE ACREDITACIÓN Y FORTALECIMIENTO DE LA OFERTA')
          ->setCellValue('C3', 'FORMULARIO DE ASIGNACIÓN DE CÓDIGOS A ESTUDIANES')
          ->setCellValue('C4', '- CAPACITACIÓN CONTINUA  -   Formulario  f1')

          ->setCellValue('D6', 'Identificación del Curso')

          ->setCellValue('B8', 'NOMBRE DEL INSTITUTO')
          ->setCellValue('B9', 'NOMBRE DEL CURSO')
          ->setCellValue('B10', 'ÁREA DEL CURSO')
          ->setCellValue('B11', 'DOCENTE')
          ->setCellValue('B12', 'FECHA DE INICIO')
          ->setCellValue('B13', 'FECHA DE FIN')

          ->setCellValue('C8', 'Instituto Superio Tecnológico Yavirac')
          ->setCellValue('C9', $this->user)
          ->setCellValue('C11', $this->instructor)
          ->setCellValue('C12', $this->date_start)
          ->setCellValue('C13', $this->date_end)

          
          
          ->setCellValue('F8', 'Estudiantes que Aprobaron')
          ->setCellValue('F9', 'Estudiantes que Reprobaron ')
          ->setCellValue('F10', 'Total ')
          ->setCellValue('G7', 'Número');




          $sheet = new Spreadsheet();
          $sheet->getActiveSheet()->getRowDimension('10')->setRowHeight(100);

         
    }


}
