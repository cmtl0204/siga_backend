@extends('mails.index')
@section('content')
    <div class="row">
        <div class="col-12 text-muted ">
            <h3 class="text-center">Verificación de Usuario</h3>
            <br>
            <p>Su usuario en <strong>{{$system->name}}</strong>ha sido generado satisfactoriamente!</p>
            {{$data->password}}
            <p>Por favor inicie sesión con:</p>
            <p>Usuario: <string>{{$data->identification}}</strong></p>
            <p>Clave: <string>{{$data->password}}</strong></p>
            <p>Para ello simplemente debe hacer click en el siguiente enlace:</p>
            <div class=" text-center">
                <a class="btn btn-primary text-center"
                   href="{{$system->redirect}}/authentication/auth/login">
                    Inicie Sesión
                </a>
            </div>
            <br>
            <br>
            <p class="text-muted">Si no puede acceder, copie la siguiente url:</p>
            <p class="text-muted">
                {{$system->redirect}}/authentication/auth/login
            </p>
            <br>
            <p>Si no ha solicitado este servicio, repórtelo a su Institución.</p>
        </div>
    </div>
@endsection
