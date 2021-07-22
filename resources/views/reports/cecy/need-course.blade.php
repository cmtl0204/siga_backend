
<html lang="en">
      <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
            <title>Informe de necesidades</title>

            <link href="css/bootstrap.min.css" rel="stylesheet">
     </head>
     <style>
    table {
      border-collapse: collapse;
      font-family: Tahoma, Geneva, sans-serif;
      font-size: 10px;
      border: 1px solid #999;
    }

    p {
      font-family: Tahoma, Geneva, sans-serif;
      font-size: 10px;
    }

    ol,
    li {
      font-family: Tahoma, Geneva, sans-serif;
      font-size: 15px;
    }

    td,
    th {
      border: 1px solid #CCC;
      padding: 2px 5px;
    }

    th {
      background: #CCC;
      border-color: #999;
    }
  </style>
      <body>
      <h1 class="col-lg-4" style="text-align: center">INSTITUTO TECNOLOGICO SUPERIOR YAVIRAC</h1>
        <CENTER>
      <TABLE BORDER WIDTH="150%">
	      <TR>
		      <TD>FORMULARIO:F2</TD> <TD></TD> <TD>Codigo del curso:{{$detailPlanification->course->code}}</TD>
	      </TR>
      </TABLE>
      </CENTER>
      <h2 style="text-align: center">Informe de necesidad del curso</h2> 
      <hr>
        <TABLE class="col-lg-20" BORDER WIDTH="100%">
	        <TR><th style="text-align: left">Nombre del docente:</th><TD>{{$detailPlanification->course->personProposal->first_name}}  
          {{$detailPlanification->course->personProposal->first_lastname}}</TD></TR>
          <TR ><th style="text-align: left">Nombre del curso:</th><TD>{{$detailPlanification->course->name}}</TD></TR> 
        </TABLE>
        <TABLE class="col-lg-20" BORDER WIDTH="75%">
        <TR>
            <th style="text-align: left">Tipo de curso:</th>
            <TD>{{$detailPlanification->course->courseType->name}} </TD>
          </TR>
          <TR>
            <th style="text-align: left">MODALIDAD</th>
            <TD>{{$detailPlanification->course->modality->name}} </TD>
          </TR>
        </TABLE>
            <hr>
            <TABLE class="col-lg-20" BORDER WIDTH="100%">
              <TR><th style="text-align: left">Necesidad del curso</th><TD> {{$detailPlanification->course->needs[0]}}</TD>
              </TR>
            </TABLE>
          <TABLE class="col-lg-20" BORDER WIDTH="75%">
          <TR>
           <th style="text-align: left">Duracion del curso</th>
            <TD style="text-align: left">{{$detailPlanification->course->hours_duration}} Horas</TD>
         </TR>
          </TABLE>
          <hr>
          <label for="">Lugar / Lugares donde se dictará (Indicar si necesitará salidas de campo): <b>{{$detailPlanification->course->place}}</b></label>
          <hr>
          <TABLE class="col-lg-20" BORDER WIDTH="115%">
          <TR>
          <th style="text-align: left">horario 1 Curso:</th>
          <TD>{{$detailPlanification->course->proposed_date}}</TD>
          <th style="text-align: left">Dias:</th>
          <TD>Lunes-viernes </TD>
          <TD>sabados-domingos</TD>
          </TR>
          </TABLE>
          <hr>
          <TABLE class="col-lg-20" BORDER WIDTH="100%">
          <TR>
          <th style="text-align: left">Fecha de iniciacion:</th>
          <TD>{{$detailPlanification->date_start}}</TD>
          <th style="text-align: left">Fecha real de finalizacion:</th>
          <TD> {{$detailPlanification->date_end}} </TD>
          </TR>
          </TABLE>

          <TABLE class="col-lg-20" BORDER WIDTH="100%">
          <TR>
          <th style="text-align: left">Fecha prevista de finalizacion:</th>
          <TD>{{$detailPlanification->course->approval_date}} </TD>
          </TR>
          </TABLE>

          <TABLE class="col-lg-20" BORDER WIDTH="100%">
          <TR>
          <th style="text-align: left">Participantes inscritos:</th>
          <!-- preguntar si esta bien imprimir la capacidad del curso -->
          <TD>{{$detailPlanification->number_participant}}</TD>
          </TR>
          </TABLE>
          <hr>
          <TABLE class="col-lg-20" BORDER WIDTH="100%">
          <TR>
          <th style="text-align: left">Resumen del curso y posible proyecto:</th>
          <TD>{{$detailPlanification->course->summary}}</TD>
          </TR>
          </TABLE>
          <hr>
          <TABLE class="col-lg-20" BORDER WIDTH="100%">
          <TR>
          <th style="text-align: left">Indicar a que población se encuentra dirigido el curso: </th>
          <TD>{{$detailPlanification->course->Target_group}}</TD>
          </TR>
          </TABLE>
          
          <hr>
          <TABLE class="col-lg-20" BORDER WIDTH="100%">
          <TR>
          <th style="text-align: left">______________________________</th>
          <TD>26-feb-2021</TD>
          </TR>
          <TR>
          <th style="text-align: left">REPRESENTANTE DEL OCS</th>
          <TD>Fecha</TD>
          </TR>
          </TABLE>

          <TABLE class="col-lg-20" BORDER WIDTH="100%">
          <TR>
          <th style="text-align: left">______________________________</th>
          <TD>26-feb-2021 </TD>
          </TR>
          <TR>
          <th style="text-align: left">VICERRECTOR </th>
          <TD>Fecha</TD>
          </TR>
          </TABLE>

            <hr>
      </body>
    </html>