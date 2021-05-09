<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$system->acronym}}</title>
    <style>

    </style>
</head>
<body>
<div class="content">
    <div class="row m-5">
        <div class="col-6 offset-3 border">
            <h5 class="text-center bg-secondary text-white">{{$system->name}}</h5>
            <p class="text-muted">
                Fecha: <b>{{\Carbon\Carbon::now()->toDateString()}}</b>
                <b class="ml-2">{{\Carbon\Carbon::now()->toTimeString()}}</b>
            </p>
            <p class="text-muted">
                Estimado/a:
                <b>{{$user->full_name}}</b>
            </p>
            <br>
            @yield('content')
            <div class="row">
                <div class="col-12">
                    <footer class="text-muted">
                        <p>Saludos cordiales</p>
                        <p><b>{{$system->name}}</b></p>
                        <hr size="3">
                        <small><b>Nota de descargo:</b></small>
                        <small>La información contenida en este mensaje es confidencial y solo puede ser
                            utilizada por el usuario al cual está dirigido.</small>
                        <small>Esta información no debe ser distribuida ni copiada total o parcialmente por ningun medio
                            sin la autorización de la Institución.
                        </small>
                    </footer>
                </div>
            </div>
            <h6 class="text-center bg-secondary text-white">
                &copy; {{(new \Carbon\Carbon($system->date))->format('Y')}}
                Todos los derechos reservados. {{$system->acronym}} v{{$system->version}}</h6>
        </div>
    </div>
</div>
</body>
</html>
