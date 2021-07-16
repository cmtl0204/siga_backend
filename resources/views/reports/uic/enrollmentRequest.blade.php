<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>
        body {
            font-size: .9rem;
            margin: 50px;
            font-family: "Times New Roman";
        }

        .rectorInfo {
            text-align: left;
        }

        .date {
            text-align: right;
        }

        .sincerely {
            margin-bottom: 50px;
        }

        .final-sign {
            text-align: center;
            margin-top: 50px;
        }

        .footer {
            margin-top: 300px;
            text-align: right;
        }
    </style>
</head>

<body class="body">

    <p class="date"> Quito D.M: {{
        \Carbon\Carbon::now()->format('d F Y')
    }}</p>

    <p class="rectorInfo">
        Magister<br>
        Oscar Iván Borja Carrera.<br>
        <b>RECTOR INSTITUTO SUPERIOR TECNOLÓGICO YAVIRAC</b><br>
        Presente.-
        <br>
    </p>

    <p>Señor Rector:</p>
    <p>
        <br>
        Yo, Simbaña Ortiz Luis Marcelo, con CC: 1750561597, estudiante de la carrera de {{$planning->career['name']}}, en aplicación a lo dispuesto en la Unidad de Titulación Especial,
        manifiesto mi aceptación libre y voluntaria a rendir el examen complexivo como opción de
        titulación, por lo que solicito a usted comedidamente se autorice.
    </p>

    <br>

    <p>Por la atención que se digne dar al presente, me suscribo.</p>

    <div class="final-sign">
        <p>

        <div class="sincerely">Atentamente,</div><br>

        Simbaña Ortiz Luis Marcelo<br>
        CI: 1750561597<br>
        E-mail: lmo.ortiz@yavirac.edu.ec<br>
        Celular: 0992378201<br>
        </p>
    </div>


    <div class="footer">
        <p>
            García Moreno S4-35 y Ambato, Centro Histórico de Quito
            Quito-Ecuador
        </p>
    </div>

</body>

</html>
