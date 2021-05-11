@extends('mails.index')
@section('content')
    <div class="row">
        <div class="col-12 text-muted ">
            <h3 class="text-center">Verificación de Correo Electrónico</h3>
            <br>
            <p>Gracias por registrarse en <strong>{{$system->name}}</strong> !</p>
            <p>Por favor confirme su correo electrónico.</p>
            <p>Para ello simplemente debe hacer click en el siguiente enlace:</p>
            <div class=" text-center">
                <a class="btn btn-primary text-center"
                   href="{{env('APP_URL')}}/authentication/auth/verify-email/{{$data->user->id}}?system={{$system->id}}">
                    Verificar Correo Electrónico
                </a>
            </div>
            <br>
            <br>
            <p class="text-muted">Si no puede acceder, copie la siguiente url:</p>
            <p class="text-muted">
                {{env('APP_URL')}}/authentication/auth/verify-email/{{$data->user->id}}?system={{$system->id}}
            </p>
            <br>
            <p>Si no ha solicitado este servicio, repórtelo a su Institución.</p>
        </div>
    </div>
@endsection
