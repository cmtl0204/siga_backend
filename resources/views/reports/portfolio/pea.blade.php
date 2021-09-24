<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <style>
@page {
            margin: 0cm 0cm;
            font-size: 1em;
        }
        body {
            margin: 3cm 2cm 2cm;
        }
        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            background-color: #46C66B;
            color: white;
            text-align: center;
            line-height: 30px;
        }
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            background-color: #46C66B;
            color: white;
            text-align: center;
            line-height: 35px;
        }
    </style>
</head>
<body>
    <header>
        <br>
        <p><strong>LIBRERIA DOMPDF - LARAVEL 7</strong></p>
    </header>
    <main>
        <div class="container">
            <h5 style="text-align: center"><strong>TABLA Asignaturas</strong></h5>
            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Descripción</th>

                    </tr>
                </thead>


               {{-- <tbody>
                @foreach($productos as $subjects)
                    <tr>
                        <th scope="row">{{ $subjects->id }}</th>
                        <td>{{ $subjects->description }}</td>
                        <td>{{ $subjects->objective }}</td>

                    </tr>
                @endforeach
                </tbody> --}}
            </table>
        </div>
    </main>
    <footer>
        <p><strong>SUSCRIBETE - COMENTA - COMPARTE</strong></p>
    </footer>

    <form novalidate (ngSubmit)="onSubmit(user)" [formGroup]="user">

        <p-card header="Información General de la asignatura">
            <div class="p-fluid">
                <div class="p-grid">


                    <div class="p-xl-6" >
                        <label>Carrera: </label> <br><br>
                        <p-dropdown [options]="subjects" [(ngModel)]="selectedSubject" optionLabel="name" [filter]="true"
                            filterBy="name" placeholder="Seleccione una carrera"  formControlName="name">
                            <ng-template pTemplate="selectedItem">
                                <div class="country-item country-item-value" *ngIf="selectedSubject">
                                   {{--  <div>{{selectedSubject.mesh?.career?.name}} </div> --}}
                                </div>
                            </ng-template>
                            <ng-template let-item pTemplate="item">
                                <div class="country-item">
                                    {{-- <div> {{item.mesh?.career?.name}} </div> --}}
                                </div>
                            </ng-template>
                        </p-dropdown>
                    </div>
                </div>

                <br>

                <div class="p-grid p-fluid">

                    <div class="p-col-12 p-md-6">
                        <label>Asignatura</label> <br><br>
                        <p-dropdown [options]="subjects" [(ngModel)]="selectedSubject" optionLabel="name" [filter]="true"
                            filterBy="name" placeholder="Seleccione una asignatura"  formControlName="selectedSubject">
                            <ng-template pTemplate="selectedItem">
                                <div class="country-item country-item-value" *ngIf="selectedSubject">
                                    {{-- <div>{{selectedSubject.name}} </div> --}}
                                </div>
                            </ng-template>
                            <ng-template let-item pTemplate="item">
                                <div class="country-item">
                                    {{-- <div> {{item.name}} </div> --}}
                                </div>
                            </ng-template>
                        </p-dropdown>
                    </div>



                    <div class="p-col-12 p-md-6">
                        <label for="carrera">Código de la Asignatura:</label> <br><br>
                        <div class="p-inputgroup">
                            {{-- <input pInputText value="{{selectedSubject?.code}}" [disabled]="disabled"> --}}
                        </div>
                    </div>
                </div>


                <br>



                <div class="p-grid p-fluid">
                    <div class="p-col-12 p-md-6">
                        <label for="carrera">Periodo Académico:</label> <br><br>
                        <div class="p-inputgroup">
                            {{-- <input pInputText value="{{selectedSubject?.name}}" [disabled]="disabled"> --}}


                        </div>
                    </div>



                     <!-- combobox periodo lectivo -->
                     <div class="p-col-12 p-md-6">
                        <label>Periodo Lectivo</label> <br><br>
                        <p-dropdown [options]="periods" id="selectedPeriod"
                            optionLabel="code" [filter]="true" placeholder="Seleccione un Periodo Lectivo">
                            {{-- <option *ngFor=" let period of periods " value={{period.id}}>
                                {{period.code}} --}}
                            </option>
                        </p-dropdown>
                    </div>
                </div>

                <br>

                <div class="p-grid p-fluid">
                    <div class="p-col-12 p-md-4">
                        <label for="carrera">Unidad de Organización Curricular:</label> <br><br>
                        <div class="p-inputgroup">
                            {{-- <input pInputText value="{{selectedSubject?.name}}" [disabled]="disabled"> --}}
                        </div>
                    </div>

                    <div class="p-col-12 p-md-4">
                        <label for="carrera">Campos de Formación:</label> <br><br>
                        <div class="p-inputgroup">
                           {{--  <input pInputText value="{{selectedSubject?.name}}" [disabled]="disabled"> --}}
                        </div>
                    </div>

                    <div class="p-col-12 p-md-4">
                        <label for="carrera">Modalidad:</label> <br><br>
                        <div class="p-inputgroup">
                           {{--  <input pInputText value="{{selectedSubject?.name}}" [disabled]="disabled"> --}}
                        </div>
                    </div>

                </div>


            </div>
        </p-card>


        <p-card header="Distribución de horas en las actividades de Aprendizaje">


            <div class="p-grid p-fluid">
                <div class="p-col-12 p-md-4">
                    <label for="carrera">Horas Docencia:</label> <br><br>
                    <div class="p-inputgroup">
                       {{--  <input pInputText value="{{selectedSubject?.teaching_hour}}" [disabled]="disabled"> --}}
                    </div>
                </div>

                <div class="p-col-12 p-md-4">
                    <label for="carrera">Horas Trabajo Autónomo:</label> <br><br>
                    <div class="p-inputgroup">
                       {{--  <input pInputText value="{{selectedSubject?.autonomous_hour}}" [disabled]="disabled"> --}}
                    </div>
                </div>

                <div class="p-col-12 p-md-4">
                    <label for="carrera">Horas Prácticas de Aprendizaje:</label> <br><br>
                    <div class="p-inputgroup">
                        {{-- <input pInputText value="{{selectedSubject?.practical_hour}}" [disabled]="disabled"> --}}
                    </div>
                </div>

            </div>

            <br>


            <div class="p-grid p-fluid">
                <div class="p-col-12 p-md-6">
                    <label for="carrera">Total horas de Asignatura:</label> <br><br>
                    <div class="p-inputgroup">
                        {{-- <input pInputText value="{{selectedSubject?.total_hour}}" [disabled]="disabled"> --}}
                    </div>
                </div>

                <div class="p-col-12 p-md-6">
                    <label for="carrera">Docente responsable de la asignatura:</label> <br><br>
                    <div class="p-inputgroup">
                        {{-- <input pInputText value="{{selectedSubject?.name}}" [disabled]="disabled"> --}}
                    </div>
                </div>
            </div>


        </p-card>





        <p-card header="Descripción de la Asignatura - Objetivo General">


            <div class="p-grid p-fluid">
                <div class="p-col-12 p-md-6">
                    <label for="carrera">Descripción de la Asignatura:</label> <br><br>
                    <div class="p-inputgroup">
                        {{-- <textarea pInputTextarea class="p-col-11" value="{{selectedSubject?.description}}" disabled type="text"
                            rows="5" cols="120" autoResize=true></textarea> --}}
                    </div>
                </div>

                <div class="p-col-12 p-md-6">
                    <label for="carrera">Objetivo General:</label> <br><br>
                    <div class="p-inputgroup">
                        {{-- <textarea pInputTextarea class="p-col-11" value="{{selectedSubject?.objective}}" disabled type="text"
                            rows="5" cols="120" autoResize=true></textarea> --}}
                    </div>
                </div>
            </div>



            <div>
                <button  pButton class="p-button-raised p-button-rounded"  (click)="clear()">Limpiar Campos</button>
                <button pButton class="p-button-raised p-button-rounded" type="submit" [disabled]="user.invalid">Validar-Guardar</button>
            </div>


        </p-card>


        </form>




{{--  {{$pea->id}} --}}
{{-- {{$subjects->id}} --}}



</body>
</html>
