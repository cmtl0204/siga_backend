<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>
    </title>
    <style>
        body {
            line-height: 108%;
            font-family: Calibri;
            font-size: 11pt
        }

        p {
            margin: 0pt 0pt 8pt;

        }

        .Footer {
            margin-bottom: 0pt;
            line-height: normal;
            font-size: 11pt
        }

        .Header {
            margin-bottom: 0pt;
            line-height: normal;
            font-size: 11pt
        }

        .NoSpacing {
            margin-bottom: 0pt;
            line-height: normal;
            font-size: 11pt
        }

        .Style {
            margin-bottom: 0pt;
            line-height: normal;
            widows: 0;
            orphans: 0;
            font-family: Arial;
            font-size: 12pt
        }

        .container {
            size: 8.27in 11.69in;
            margin-left: 0.59in;
            margin-right: 0.395in;
            margin-top: 0.245in;
            margin-bottom: 0.295in
        }
        .selector {
            word-wrap: break-word;      /* IE 5.5-7 */
            white-space: -moz-pre-wrap; /* Firefox 1.0-2.0 */
            white-space: pre-wrap;      /* current browsers */
        }
    </style>
</head>

<body style="background: url({{public_path('storage/institutions/official_logos/'.$logo)}}) no-repeat; background-size: {{$size}}px auto; background-position: 590px 0px;" lang="es-ES">
    <div class="container">
    <p>&nbsp;</p>
    <p class="NoSpacing"><strong>A:</strong><span style="width:26.3pt; display:inline-block;">&nbsp;</span><span style="width:36pt; display:inline-block;">&nbsp;</span><span>{{ $receiver }}</span></p>
    <p class="NoSpacing"><span style="width:36pt; display:inline-block;">&nbsp;</span><span style="width:36pt; display:inline-block;">&nbsp;</span>Coordinadora de Carrera</p>
    <p class="NoSpacing">&nbsp;</p>
    <p class="NoSpacing"><strong>DE:</strong><span style="width:20.67pt; display:inline-block;">&nbsp;</span><span style="width:36pt; display:inline-block;">&nbsp;</span><span>{{ $sender }}</span></p>
    <p class="NoSpacing"><span style="width:36pt; display:inline-block;">&nbsp;</span><span style="width:36pt; display:inline-block;">&nbsp;</span>Tutor del proyecto</p>
    <p class="NoSpacing">&nbsp;</p>
    <p class="NoSpacing"><strong>Asunto:</strong><span style="width:0.38pt; display:inline-block;">&nbsp;</span><span style="width:36pt; display:inline-block;">&nbsp;</span>Informe de inicio de actividades <strong>&ldquo;</strong><strong><span>{{ $project }}</span></strong><strong>&rdquo;</strong></p>
    <p class="NoSpacing"><strong>&nbsp;</strong></p>
    <p class="NoSpacing"><strong>Fecha:</strong><span style="width:6.44pt; display:inline-block;">&nbsp;</span><span style="width:36pt; display:inline-block;">&nbsp;</span><span>{{ $start_date }} en</span> la que se iniciaba las actividades</p>
    <p class="NoSpacing">&nbsp;</p>
    <p class="NoSpacing">&nbsp;</p>
    <p class="NoSpacing"><span style="height:0pt; display:block; position:absolute; z-index:0;"><hr style="margin: 0 0 0 auto; text-align: right; display: block; "></span>&nbsp;</p>
    <p class="NoSpacing">&nbsp;</p>
    <p class="NoSpacing">&nbsp;</p>
    <p style="line-height:150%;">Yo <span>{{ $name }}</span> con ci <span>{{$identification}}</span> docente de la carrera <span>{{$career}},</span> tengo bien a informar que, siguiendo con el cronograma de actividades establecido en el proyecto vinculaci&oacute;n <strong><span>{{$project}}</span></strong><strong>,&nbsp;</strong>le inform&oacute; que el d&iacute;a de hoy <strong><span>{{$day}} de {{$month}}</span></strong> del a&ntilde;o en curso, se procedi&oacute; a dar inicio con el desarrollo del mismo.</p>
    <p style="line-height:150%;" class="selector">{{ $description }}</p>
    <p>&nbsp;</p>
    <p><img width="600px" align="center" src="{{storage_path('app/private/images/'.'temp'. '\\' .'temp'.'.jpg')}}"></p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>Atentamente</p>
    <p>&nbsp;</p>
    <p class="Style" style="margin-right:1.7pt; text-align:justify; font-size:9pt;"><strong>f.___________________________</strong><span style="width:3.36pt; display:inline-block;">&nbsp;</span><span style="width:36pt; display:inline-block;">&nbsp;</span><span style="width:36pt; display:inline-block;">&nbsp;</span><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></p>
    <p class="Style" style="margin-right:1.7pt; text-align:justify; font-size:9pt;"><strong>Nombre:</strong></p>
    <p class="Style" style="margin-right:1.7pt; text-align:justify; font-size:9pt;"><strong>&nbsp;</strong></p>
    <p class="Style" style="margin-right:1.7pt; text-align:justify; font-size:9pt;"><strong>Tutor del proyecto</strong><span style="width:29pt; display:inline-block;">&nbsp;</span><span style="width:36pt; display:inline-block;">&nbsp;</span><span style="width:36pt; display:inline-block;">&nbsp;</span><span style="width:36pt; display:inline-block;">&nbsp;</span><span style="width:36pt; display:inline-block;">&nbsp;</span><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></p>
    <p style="line-height:normal;"><span style="font-family:Arial;">&nbsp;</span></p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    </div>
    
</body>

</html>