<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>INSCRIPCION PARA CURSOS DE CAPACITACION</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
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

    th.nombre {
      background: none;
    }

    td.dia {
      text-align: center;
      width: 24px;
      height: 24px;
      padding: 0px;
      overflow: hidden;
    }

    .nombre {
      text-align: left;
      width: 150px;
    }
  </style>
</head>

<body>
  <IMG SRC="https://www.google.com/url?sa=i&url=http%3A%2F%2Fyavirac.edu.ec%2F&psig=AOvVaw2Dv2-gyt5XzOkTu2iITweN&ust=1625519424149000&source=images&cd=vfe&ved=0CAoQjRxqFwoTCKCs7fGpyvECFQAAAAAdAAAAABAJ" ALIGN=LEFT BORDER=5>
  <h1 class="col-lg-4" style="text-align: center">INSTITUTO TECNOLOGICO SUPERIOR YAVIRAC</h1>

  <table BORDER WIDTH="100%">
    <tr>
      <td style="color:#FF0000">FORMULARIO:A2</td>
      <td></td>
      <td></td>
    </tr>
  </table>

  <h3 style="text-align: center">INSCRIPCION PARA CURSOS DE CAPACITACION</h3>

  <div>
    <table BORDER WIDTH="100%" style="margin: 0 auto;">
    
      <tr>
        <th style="text-align: left">CODIGO DEL CURSO</th>
        <td colspan="2">{{$course->code}}</td>

      </tr>
      <tr>
        <th style="text-align: left">NOMBRE DEL CURSO</th>
        <td colspan="2">{{$course->name}}</td>

      </tr>

      <tr>
        <th style="text-align: left">MODALIDAD</th>
        <td>PRESENCIAL<input type="checkbox"></td>
        <td>VIRTUAL<input type="checkbox"></td>
      </tr>
      
    </table>
  </div>

  <h3 style="text-align: center">DATOS PERSONALES</h3>
  <div>
    <table BORDER WIDTH="100%" border="0.5" style="margin: 0 auto;">
     
      <tr>
        <th style="text-align: left">APELLIDO Y NOMBRES</th>
        <td colspan="6">{{$course->personProposal->partial_lastname}} {{$course->personProposal->partial_name}}</td>
      </tr>
      <tr>
        <th style="text-align: left">CEDULA DE CIUDADANIA</th>
        <td style="text-align: left">{{$course->personProposal->identification}}</td>
        <th style="text-align: rigth">FECHA DE NACIMIENTO</th>
        <td colspan="4" style="text-align: left">{{$course->personProposal->birthdate}}</td>
      </tr>
      <tr>
        <th style="text-align: left">SEXO</th>
        <td colspan="3">FEMENINO  {{$course->personProposal->sex_id}}<input type="checkbox"></td>
        <td colspan="3">MASCULINO <input type="checkbox"></td>
      </tr>
      <tr>
        <th style="text-align: left">ETNIA</th>
        <td>MESTIZO <input type="checkbox"></td>
        <td>INDIGENA <input type="checkbox"></td>
        <td>BLANCO <input type="checkbox"></td>
        <td>AFROECUATORIANO <input type="checkbox"></td>
        <td colspan="2">OTRO <input type="checkbox"></td>
      </tr>
      <tr>
        <th style="text-align: left">DIRECCION DOMICILIARIA</th>
        <td colspan="6">{{$course->personProposal->address_id}}</td>
      </tr>
      <tr>
        <th style="text-align: left">NUMERO TELEFONICO</th>
        <td style="text-align: left">{{$course->personProposal->phone}}</td>
        <th style="text-align: rigth">CELULAR</th>
        <td colspan="4" style="text-align: left">0{{$course->personProposal->phone}}</td>
      </tr>
      <tr>
        <th style="text-align: left">CORREO ELECTRONICO</th>
        <td colspan="6">{{$course->personProposal->email}}</td>
      </tr>
      <tr>
        <th style="text-align: left">NIVEL DE INSTRUCCION</th>
        <td colspan="2">PRIMARIA <input type="checkbox"></td>
        <td colspan="2">SECUNDARIA <input type="checkbox"></td>
        <td colspan="2">SUPERIOR <input type="checkbox"></td>
      </tr>
      
    </table>
  </div>

  <h3 style="text-align: center">INFORMACION LABORAL / ESTUDIOS</h3>

  <div>
    <table BORDER WIDTH="100%" style="margin: 0 auto;">
  
      <tr>
        <th style="text-align: left">INSTITUCION DONDE TRABAJA/ESTUDIA</th>
        <td colspan="2">{{$course->institution->name}}</td>

      </tr>
      <tr>
        <th style="text-align: left">DIRECCION DE LA INSTITUCION</th>
        <td colspan="2">{{$course->institution->institution->code}}</td>
      </tr>
      <tr>
        <th style="text-align: left">CORREO ELECTRONICO DE LA INSTITUCION</th>
        <td colspan="2"></td>
      </tr>
      <tr>
        <th style="text-align: left">NUMERO TELEFONICO DE LA INSTITUCION</th>
        <td colspan="2"></td>
      </tr>
      <tr>
        <th style="text-align: left">ACTIVIDAD DE LA INSTITUCION</th>
        <td colspan="2"></td>
      </tr>
      <tr>
        <th style="text-align: left">¿EL CURSO ES AUSPICIADO POR LA INSTITUCION?</th>
        <td style="text-align: left"> SI <input type="checkbox"></td>
        <td> NO <input type="checkbox"></td>
      </tr>
      <tr>
        <th style="text-align: left">Si esta auspiciado, indique el nombre de contacto</th>
        <td colspan="2">INTITUTO TECNOLOGICO SUPERIOR YAVIRAC</td>
      </tr>
      <tr>
        <th style="text-align: left">¿Como se entero del curso?</th>
        <td colspan="2">GARCIA MORENO OEA</td>
      </tr>
      <tr>
        <th style="text-align: left">¿Que otros cursos le gustaria seguir?</th>
        <td colspan="2">Ingles</td>
      </tr>
      <tr>
        <th style="text-align: left"></th>
        <td colspan="2">Frances</td>
      </tr>
      <tr>
        <th style="text-align: left"></th>
        <td colspan="2">Frances</td>
      </tr>
      <tr>
        <th style="text-align: left"></th>
        <td colspan="2">Frances</td>
      </tr>
      <tr>
        <th style="text-align: left"></th>
        <td colspan="2">Frances</td>
      </tr>
      
    </table>
  </div>
  <p>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
  </p>

  <table style='text-align:center' BORDER WIDTH="100%">
    
    <th style='text-align:center'>Firma del solicitante</th>
    <th style='text-align:center'>{{$course->personProposal->partial_lastname}} {{$course->personProposal->partial_name}}</th>
    
  </table>
  <p style='text-align:center'>
    Nota: Para el caso de una inscripción fìsica, se tomará en cuenta la impresiòn del siguiente formulario, en caso de que sea un registro digital, se solicita adjuntar unicamente la imagen de la firma del solicitante en el documento para el archivo del Instituto.
  </p>
</body>

</html>