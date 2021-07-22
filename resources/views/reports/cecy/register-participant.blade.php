<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de participantes</title>
</head>
<body>
<h1 class="col-lg-4" style="text-align: center">INSTITUTO TECNOLOGICO SUPERIOR YAVIRAC</h1>
<CENTER>
<TABLE BORDER WIDTH="150%">
	      <TR>
		      <TD>FORMULARIO: e1</TD> <TD></TD> <TD></TD>
	      </TR>
      </TABLE>
</CENTER>
<h2 style="text-align: center"> REGISTRO DE PARTICIPANTES INSCRITOS Y MATRICULADOS</h2> 
<hr>
@foreach ($detailRegistration as $course)
        <TABLE class="col-lg-20" BORDER WIDTH="100%">
	        <TR><th style="text-align: left">Provincia:</th><TD>Pichincha</TD></TR>
          <TR ><th style="text-align: left">Canton:</th><TD>{{$course->detailPlanification->course->cantonDictate->name}}</TD></TR> 
          <TR><th style="text-align: left">Parroquia:</th><TD>Centro Historico</TD></TR>
          <TR><th style="text-align: left">Local Donde se dicta:</th><TD>{{$course->detailPlanification->course->local_proposal}}</TD></TR>
          <TR><th style="text-align: left">Convenio:</th><TD>-</TD></TR>
          <TR><th style="text-align: left">Nombre del curso:</th><TD>{{$course->detailPlanification->course->name}}</TD></TR>
        </TABLE>

        <TABLE class="col-lg-20" BORDER WIDTH="100%">
	        <TR><th style="text-align: left">Tipo de curso:</th><TD>
          {{$course->detailPlanification->course->courseType->name}}</TD></TR>
          <TR ><th style="text-align: left">Modalidad del curso:</th>
          <TD>{{$course->detailPlanification->course->modality->name}}</TD></TR> 
          <TR ><th style="text-align: left">Duracion del curso:</th>
          <TD>{{$course->detailPlanification->course->hours_duration}} HORAS</TD></TR> 
          <TR><th style="text-align: left">Fecha de iniciacion:</th>
          <TD>{{$course->detailPlanification->date_start}}</TD></TR>
          <TR><th style="text-align: left">Fecha Prevista de finalizacion:</th>
          <TD>{{$course->detailPlanification->course->proposed_date}}</TD></TR>
          <TR><th style="text-align: left">Fecha real de finalizacion:</th>
          <TD>{{$course->detailPlanification->date_end}}</TD></TR>
          <TR><th style="text-align: left">Horario del curso:</th><TD>7:00</TD></TR>
          <TR><th style="text-align: left">Codigo del curso:</th>
          <TD>{{$course->detailPlanification->course->code}}</TD></TR>
        </TABLE>
        <hr>
    <table>
    <thead>
    <tr>
    <th>N°</th>
    <th>APELLIDOS Y NOMBRES</th>
    <th>DOCUMENTO DE IDENTIDAD</th>
    <th>SEXO</th>
    <th>EDAD / AÑOS</th>
    <th>NIVEL DE INSTRUCCIÓN</th>
    <!-- Datos de la empresa -->
    <th>NOMBRE DE LA EMPRESA</th>
    <th>ACTIVIDAD DE LA EMPRESA</th>
    <th>DIRECCION  DE LA EMPRESA</th>
    <th>TELEFONO</th>
    <!-- DATOS DEL PARTICIPANTE -->
    </tr>
    </thead>
    <tbody>
    <tr>
    <th>{{ $course->detailPlanification->instructor->responsible->id}}</th>
    <th>{{ $course->detailPlanification->instructor->responsible->full_name}}</th>
    <th>{{ $course->detailPlanification->instructor->responsible->identification}}</th>
    <th>{{ $course->detailPlanification->instructor->responsible->sex->name}}</th>
    <th> 40 </th>
    <th>{{ $course->additionalInformation->level_instruction}}</th>
    <!-- Datos de la empresa -->
    <th>{{ $course->additionalInformation->company_name}}</th>
    <th>{{ $course->additionalInformation->company_activity}}</th>
    <th>{{ $course->additionalInformation->company_address}}</th>
    <th>{{ $course->additionalInformation->company_phone}}</th>
    </tr>
    </tbody>
    </table>
    <Table>
    <thead>
    <tr>
    <th>DIRECCION DOMICILIARIA</th>   
    <th>TELEFONOS</th>
    <th>Estado</th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <th>{{ $course->detailPlanification->instructor->responsible->address_id}}</th>
    <th>{{ $course->detailPlanification->instructor->responsible->phone}}</th>
    <th>{{ $course->registration->planification->state->name}}</th>
    </tr>
    </tbody>
    </Table>
    @endforeach
</body>
</html>