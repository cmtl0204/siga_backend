<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programacion Mensual</title>
</head>
<body>
<h1 class="col-lg-4" style="text-align: center">INSTITUTO TECNOLOGICO SUPERIOR YAVIRAC</h1>
<CENTER>
<TABLE BORDER WIDTH="150%">
	      <TR>
		      <TD>FORMULARIO: d1</TD> <TD></TD> <TD>Año:</TD>
	      </TR>
      </TABLE>
</CENTER>
<h2 style="text-align: center">PROGRAMACIÓN DE CURSOS DE CAPACITACIÓN MENSUAL</h2> 
    <hr>
    <table>
    <thead>
    <tr>
    <th>Nro</th>
    <th>Sector</th>
    <th>Area</th>
    <th>Nombre del curso</th>
    <th>Curso OCC</th>
    <th>Duración</th>
    <th>Fecha Icicia</th>
    <th>Fecha Finaliza</th>
    </tr>
    </thead>
    <tbody>
    @foreach($detailPlanification as $user)
    <tr>
    <th>{{ $user->course->id}}</th>
    <th>{{ $user->course->personProposal->address->sector->name}}</th>
    <th>{{ $user->course->area->name}}</th>
    <th>{{ $user->course->name}}</th>
    <th> SI </th>
    <th>{{ $user->course->hours_duration}} HORAS</th>
    <th>{{ $user->date_start}}</th>
    <th>{{ $user->date_end}}</th>
    </tr>
    @endforeach
    </tbody>
    </table>
    <hr>
    <Table>
    <thead>
    <tr>
    <th>Hora Desde</th>
    <th>Hora hasta</th>
    <th>Lugar del curso dictado</th>
    <th>Nro. De participantes</th>
    <th>Docente</th>
    <th>Responsable</th>
    </tr>
    </thead>
    <tbody>
    @foreach($detailPlanification as $user)
    <tr>
    <th>{{ $user->course->proposed_date}}</th>
    <th>{{ $user->course->approval_date}}</th>
    <th>{{ $user->course->place}}</th>
    <th>{{ $user->number_participant}}</th>
    <th>{{ $user->course->personProposal->full_name}}</th>
    <th>{{ $user->course->personProposal->full_name}}</th>
    </tr>
    @endforeach
    </tbody>
    </Table>
</body>
</html>