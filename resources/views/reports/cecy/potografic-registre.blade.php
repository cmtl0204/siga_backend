
<html lang="en">
      <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
            <title>Registro Fotografico</title>

            <link href="css/bootstrap.min.css" rel="stylesheet">
     </head>
      <body>
      <h1 class="col-lg-4" style="text-align: center">INSTITUTO TECNOLOGICO SUPERIOR YAVIRAC</h1>
        <CENTER>
      <TABLE BORDER WIDTH="150%">
	      <TR>
		      <TD>Registro Fotografico</TD> <TD></TD> <TD></TD>
	      </TR>
      </TABLE>
      </CENTER>
      <h2 style="text-align: center">Informe de necesidad del curso</h2> 
      <hr>
        <TABLE class="col-lg-20" BORDER WIDTH="100%">
        @foreach ($topic as $course)
	        <TR><th style="text-align: left">Foto No:</th><TD> 09877 </TD></TR>
          <TR ><th style="text-align: left">Descripcion:</th><TD>{{$course->description}}</TD></TR> 
          <TR ><th style="text-align: left">Fecha:</th><TD>{{$course->course->approval_date}}</TD></TR> 
          @endforeach
        </TABLE>   
            <hr>
      </body>
    </html>