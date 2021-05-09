@extends('pages.index')
@section('content')
    <div class="row">
        <div class="col-12 text-muted ">
            <h3 class="text-center text-primary">Correo Electrónico Verificado</h3>
            <br>
            <p>Gracias por registrarse en <strong>{{$system->name}}  ({{$system->acronym}})</strong> </p>
            <p>Para empezar a utilizar nuestro sistema, debe hacer click en el siguiente enlace:</p>
            <div class=" text-center">
                <a class="btn btn-primary text-center"
                   href="{{$system->redirect}}/#/auth/login">
                    Iniciar Sesión
                </a>
            </div>
            <br>
            <br>
            <p class="text-muted">Si no puede acceder, copie la siguiente url:</p>
            <p class="text-muted">
                {{$system->redirect}}/#/auth/login
            </p>
            <br>
            <p>Si no ha solicitado este servicio, repórtelo a su Institución.</p>
        </div>
    </div>
@endsection
