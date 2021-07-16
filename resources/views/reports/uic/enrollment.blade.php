<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>
        h1 {
            text-align: center;
            font-size: x-large;
            font-weight: bold;
        }

        body {
            font-size: .8rem;
            margin: 10px;
            font-family: "Times New Roman";
        }

        table {
            text-align: center;
            width: 100%;
        }

        .requirementsInfo {
            font-size: .7rem;
            border: 1px solid black;
            text-align: left;
            border-collapse: collapse;
            margin-bottom: 300px;
        }

        tr,
        td,
        th {
            border: 1px solid black;
        }

        .date {
            font-size: 15px;
        }

        .infoEnrollment {
            width: 100%;
            border: none;
            text-align: center;
            border-color: white;
        }

        .infoEnrollment td,
        .infoEnrollment th,
        .infoEnrollment tr {
            border: none;
        }

        .enrollmentText {
            margin: 60px 0px 30px 0px;
        }

        th {
            text-align: center;
        }

        .infoEnrollment td {
            width: 50%;
        }

        .end {
            margin-bottom: 200px;
        }
    </style>
</head>

<body class="body">
    <div>
        <p class="date"> FECHA: {{\Carbon\Carbon::now()->toDateString()}}</p>
        <h1>CERTIFICADO DE MATRÍCULA</h1>

        <table class="infoEnrollment">
            <tr>
                <th>MÁTRICULA</th>
                <th>FOLIO</th>
            </tr>
            <tr>
                <td>2021-1-DS-1750561597</td>
                <td>2021-1-DS</td>
            </tr>
        </table>
        <p class="enrollmentText">
            CERTIFICO que, SIMBAÑA ORTIZ LUIS MARCELO, con cédula de ciudadanía N° 1750561597,
            se encuentra matriculado/a en la UNIDAD DE TITULACIÓN de la carrera {{$planning->career['name']}}, para el periodo lectivo JUNIO 2021 - OCTUBRE
            2021, bajo la modalidad de TITULACIÓN, previo al cumpliento de los siguientes
            requisitos legales:

        </p>

        <table class="requirementsInfo">
            <tr>
                <th>REQUISITO</th>
                <th>NUMERO MATÍCULA</th>
                <th>ESTADO</th>
            </tr>
            <tr>
                <td>CERTIFICADO SIAU</td>
                <td>PRIMERA</td>
                <td>CUMPLE</td>
            </tr>
            <tr>
                <td>HORAS DE VINCULACIÓN CON LAS SOCIEDAD (160)</td>
                <td>PRIMERA</td>
                <td>NO CUMPLE</td>
            </tr>
            <tr>
                <td>HORAS PRACTICAS PREPROFESIONALES (240)</td>
                <td>PRIMERA</td>
                <td>CUMPLE</td>
            </tr>
            <tr>
                <td>MALLA COMPLETA</td>
                <td>PRIMERA</td>
                <td>CUMPLE</td>
            </tr>
            <tr>
                <td>NIVEL DE INGLÉS REQUERIDO (A2.2)</td>
                <td>PRIMERA</td>
                <td>CUMPLE</td>
            </tr>
        </table>
        <p class="end">
            Con sentimiento de distinguida consideración.
            <br>
            Atentamente,
        </p>
        <h6>
            UNIDAD DE INTEGRACIÓN CURRICULAR
            <br>
            INSTITUTO SUPERIOR TECNOLÓGICO BENITO JUÁREZ
        </h6>

    </div>
</body>

</html>
