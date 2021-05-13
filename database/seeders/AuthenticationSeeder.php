<?php

namespace Database\Seeders;

use App\Models\App\Career;
use App\Models\App\Catalogue;
use App\Models\App\Institution;
use App\Models\App\Status;
use App\Models\Authentication\Module;
use App\Models\Authentication\Permission;
use App\Models\Authentication\Role;
use App\Models\Authentication\Route;
use App\Models\Authentication\SecurityQuestion;
use App\Models\Authentication\System;
use App\Models\Authentication\User;
use Illuminate\Database\Seeder;

class AuthenticationSeeder extends Seeder
{
    public function run()
    {
        $this->createStatus();

        // catalogos
        $this->createIdentificationTypeCatalogues();
        $this->createEthnicOriginCatalogues();
        $this->createBloodTypeCatalogues();
        $this->createSexCatalogues();
        $this->createGenderCatalogues();
        $this->createCivilStatusCatalogues();
        $this->createCareerModality();
        $this->createCareerType();
        $this->createLocationCatalogues();
        $this->createMenus();

        // Sistemas
        $this->createSystem();

        // Institutos
        $this->createInstitutions();

        // Carreras
        $this->createCareers();

        // Roles para el sistema IGNUG
        $this->createRoles();

        // Modulos
        $this->createModules();

        // Rutas
        $this->createRoutes();

        // Permisos
        $this->createPermissions();

        // Roles con permisos
        $this->createRolePermissions();

        // Users
        $this->createUsers();

        // Users con roles
        $this->createUsersRoles();

        // Users con instituciones
        $this->createUsersInstitutions();

        // Security Questions
        $this->createSecurityQuestions();
    }

    private function createSystem()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        $statysAvailable = Status::firstWhere('code', $catalogues['status']['available']);
        System::factory()->create([
            'code' => $catalogues['system']['code'],
            'name' => 'Sistema de Gestión Académico - Administrativo',
            'acronym' => 'IGNUG',
            'version' => '1.2.3',
            'redirect' => 'http://siga.test:4200',
            'date' => '2021-03-10',
            'status_id' => $statysAvailable->id
        ]);
        System::factory()->create([
            'code' => $catalogues['system']['code'],
            'name' => 'Sistema de Gestión Académico - Administrativo',
            'acronym' => 'CECY',
            'version' => '1.2.3',
            'redirect' => 'http://siga.test:4200',
            'date' => '2021-03-10',
            'status_id' => $statysAvailable->id
        ]);
    }

    private function createStatus()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);

        Status::factory()->create([
            'code' => $catalogues['status']['active'],
            'name' => 'ACTIVE',
        ]);
        Status::factory()->create([
            'code' => $catalogues['status']['inactive'],
            'name' => 'INACTIVE',
        ]);
        Status::factory()->create([
            'code' => $catalogues['status']['locked'],
            'name' => 'LOCKED',
        ]);
        Status::factory()->create([
            'code' => $catalogues['status']['available'],
            'name' => 'AVAILABLE',
        ]);
        Status::factory()->create([
            'code' => $catalogues['status']['maintenance'],
            'name' => 'MAINTENANCE',
        ]);
    }

    private function createRoles()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);

        //$system = System::firstWhere('code', $catalogues['system']['code']);
        $institution = Institution::find(1);
        foreach (System::all() as $system) {
            // SIGA
            Role::factory()->create([
                'code' => $catalogues['role']['admin'],
                'name' => 'ADMINISTRADOR',
                'system_id' => $system->id,
                'institution_id' => $institution->id
            ]);
            Role::factory()->create([
                'code' => $catalogues['role']['student'],
                'name' => 'ESTUDIANTE',
                'system_id' => $system->id
                , 'institution_id' => $institution->id]);
            Role::factory()->create([
                'code' => $catalogues['role']['teacher'],
                'name' => 'PROFESOR',
                'system_id' => $system->id,
                'institution_id' => $institution->id]);
            Role::factory()->create([
                'code' => $catalogues['role']['chancellor'],
                'name' => 'RECTOR',
                'system_id' => $system->id,
                'institution_id' => $institution->id]);
            Role::factory()->create([
                'code' => $catalogues['role']['vice_chancellor'],
                'name' => 'VICERRECTOR',
                'system_id' => $system->id
                , 'institution_id' => $institution->id]);
            Role::factory()->create([
                'code' => $catalogues['role']['concierge'],
                'name' => 'CONSERJE',
                'system_id' => $system->id
                , 'institution_id' => $institution->id]);
            Role::factory()->create([
                'code' => $catalogues['role']['career_coordinator'],
                'name' => 'COORD. CARRERA',
                'system_id' => $system->id
                , 'institution_id' => $institution->id]);
            Role::factory()->create([
                'code' => $catalogues['role']['academic_coordinator'],
                'name' => 'COORD. ACADEMICO',
                'system_id' => $system->id
                , 'institution_id' => $institution->id]);
            Role::factory()->create([
                'code' => $catalogues['role']['community_coordinator'],
                'name' => 'COORD. VINCULACION',
                'system_id' => $system->id
                , 'institution_id' => $institution->id]);
            Role::factory()->create([
                'code' => $catalogues['role']['investigation_coordinator'],
                'name' => 'COORD. INVESTIGACION',
                'system_id' => $system->id
                , 'institution_id' => $institution->id]);
            Role::factory()->create([
                'code' => $catalogues['role']['administrative_coordinator'],
                'name' => 'COORD. ADMINISTRATIVO',
                'system_id' => $system->id,
                'institution_id' => $institution->id]);

            // JOB BOARD
            Role::factory()->create([
                'code' => $catalogues['role']['professional'],
                'name' => 'PROFSIONAL',
                'system_id' => $system->id,
                'institution_id' => $institution->id]);

            Role::factory()->create([
                'code' => $catalogues['role']['company'],
                'name' => 'EMPRESA',
                'system_id' => $system->id,
                'institution_id' => $institution->id]);
        }
    }

    private function createPermissions()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        $system = System::firstWhere('code', $catalogues['system']['code']);
        foreach (Route::all() as $route) {
            foreach (Institution::all() as $institution) {
                Permission::factory()->create([
                    'route_id' => $route->id,
                    'institution_id' => $institution->id,
                    'system_id' => $system->id,
                ]);
            }
        }
    }

    private function createRolePermissions()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        $system = System::firstWhere('code', $catalogues['system']['code']);

        foreach (Institution::all() as $institution) {
            foreach (Route::all() as $route) {
                foreach (Role::all() as $role) {
                    $role->permissions()->attach(Permission::
                    where('route_id', $route->id)
                        ->where('system_id', $system->id)
                        ->where('institution_id', $institution->id)
                        ->first()
                    );
                }
            }
        }
    }

    private function createInstitutions()
    {
        Institution::factory()->create(
            [
                'code' => 'bj_1',
                'name' => 'BENITO JUAREZ',
                'logo' => 'institutions/1.png',
                'acronym' => 'BJ',
                'short_name' => 'BENITO JUAREZ'
            ]);
        Institution::factory()->create(
            [
                'code' => 'y_2',
                'name' => 'DE TURISMO Y PATRIMONIO YAVIRAC',
                'logo' => 'institutions/2.png',
                'acronym' => 'Y',
                'short_name' => 'YAVIRAC'
            ]);
        Institution::factory()->create(
            [
                'code' => '24mayo_3',
                'name' => '24 DE MAYO',
                'logo' => 'institutions/3.png',
                'acronym' => '24MAYO',
                'short_name' => '24 DE MAYO'
            ]);
        Institution::factory()->create(
            [
                'code' => 'gc_4',
                'name' => 'GRAN COLOMBIA',
                'logo' => 'institutions/4.png',
                'acronym' => 'GC',
                'short_name' => 'GRAN COLOMBIA'
            ]);
    }

    private function createCareers()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);

        $benitoJuarez = Institution::find(1);
        $yavirac = Institution::find(2);
        $mayo24 = Institution::find(3);
        $granColombia = Institution::find(4);

        $dualModality = Catalogue::where('type', $catalogues['catalogue']['career_modality']['type'])->where('code', $catalogues['catalogue']['career_modality']['dual'])->first();
        $presencialModality = Catalogue::where('type', $catalogues['catalogue']['career_modality']['type'])->where('code', $catalogues['catalogue']['career_modality']['full_attendance'])->first();

        $technologyType = Catalogue::where('type', $catalogues['catalogue']['career_type']['type'])->where('code', $catalogues['catalogue']['career_type']['technology'])->first();
        $technicalType = Catalogue::where('type', $catalogues['catalogue']['career_type']['type'])->where('code', $catalogues['catalogue']['career_type']['technical'])->first();

        Career::create([
            'institution_id' => $benitoJuarez->id,
            'name' => 'TECNOLGÍA SUPERIOR EN DESAROLLO DE SOFTWARE',
            'short_name' => 'DESAROLLO DE SOFTWARE',
            'modality_id' => $dualModality->id,
            'title' => 'TECNÓLOGO SUPERIOR EN DESARROLLO DE SOFTWARE',
            'acronym' => 'DS1',
            'logo' => 'careers/1.png',
            'type_id' => $technologyType->id
        ]);
        Career::create([
            'institution_id' => $benitoJuarez->id,
            'name' => 'TECNOLGÍA SUPERIOR EN DESAROLLO DE SOFTWARE',
            'short_name' => 'DESAROLLO DE SOFTWARE',
            'modality_id' => $dualModality->id,
            'title' => 'TECNÓLOGO SUPERIOR EN DESARROLLO DE SOFTWARE',
            'acronym' => 'DS2',
            'logo' => 'careers/2.png',
            'type_id' => $technologyType->id
        ]);

        Career::create([
            'institution_id' => $yavirac->id,
            'name' => 'TECNOLOGIA SUPERIOR EN ANALISIS DE SISTEMAS',
            'short_name' => 'ANALISIS DE SISTEMAS',
            'modality_id' => $presencialModality->id,
            'title' => 'TECNOLOGO SUPERIOR EN ANALISIS DE SISTEMAS',
            'acronym' => 'AS',
            'logo' => 'careers/3.png',
            'type_id' => $technologyType->id
        ]);
        Career::create([
            'institution_id' => $yavirac->id,
            'name' => 'TECNOLOGIA SUPERIOR EN ELECTRONICA',
            'short_name' => 'ELECTRONICA',
            'modality_id' => $presencialModality->id,
            'title' => 'TECNOLOGO SUPERIOR EN ANALISIS DE ELECTRONICA',
            'acronym' => 'ELT',
            'logo' => 'careers/4.png',
            'type_id' => $technologyType->id
        ]);
        Career::create([
            'institution_id' => $yavirac->id,
            'name' => 'TECNOLOGIA SUPERIOR EN ELECTRICIDAD',
            'short_name' => 'ELECTRICIDAD',
            'modality_id' => $presencialModality->id,
            'title' => 'TECNOLOGO SUPERIOR EN ELECTRICIDAD',
            'acronym' => 'ELC',
            'logo' => 'careers/5.png',
            'type_id' => $technologyType->id
        ]);
        Career::create([
            'institution_id' => $yavirac->id,
            'name' => 'TECNICO SUPERIOR EN GUIANZA TURISTICA CON MENCION EN PATRIMONIO CULTURAL O AVITURISMO',
            'short_name' => 'GUIANZA TURISTICA',
            'modality_id' => $dualModality->id,
            'title' => 'TECNICO SUPERIOR EN GUIANZA TURISTICA CON MENCION EN PATRIMONIO CULTURAL O AVITURISMO',
            'acronym' => 'GT',
            'logo' => 'careers/6.png',
            'type_id' => $technicalType->id
        ]);
        Career::create([
            'institution_id' => $yavirac->id,
            'name' => 'GUIA NACIONAL DE TURISMO CON NIVEL EQUIVALENTE A TECNOLOGIA SUPERIOR',
            'short_name' => 'GUIA NACIONAL',
            'modality_id' => $dualModality->id,
            'title' => 'GUIA NACIONAL DE TURISMO CON NIVEL EQUIVALENTE A TECNOLOGO SUPERIOR',
            'acronym' => 'GN',
            'logo' => 'careers/7.png',
            'type_id' => $technologyType->id
        ]);
        Career::create([
            'institution_id' => $yavirac->id,
            'name' => 'TECNICO SUPERIOR EN ARTE CULINARIO ECUATORIANO',
            'short_name' => 'ARTE CULINARIO',
            'modality_id' => $dualModality->id,
            'title' => 'TECNICO SUPERIOR EN ARTE CULINARIO ECUATORIANO',
            'acronym' => 'AC',
            'logo' => 'careers/8.png',
            'type_id' => $technicalType->id
        ]);
        Career::create([
            'institution_id' => $granColombia->id,
            'name' => 'DISEÑO DE MODAS CON NIVEL EQUIVALENTE A TECNOLOGÍA SUPERIOR',
            'short_name' => 'DISEÑO DE MODAS',
            'modality_id' => $presencialModality->id,
            'title' => 'DISEÑADOR DE MODAS CON NIVEL EQUIVALENTE A TECNOLOGO SUPERIOR',
            'acronym' => 'DM',
            'logo' => 'careers/9.png',
            'type_id' => $technologyType->id
        ]);
        Career::create([
            'institution_id' => $granColombia->id,
            'name' => 'DISEÑO DE MODAS CON NIVEL EQUIVALENTE A TECNOLOGÍA SUPERIOR',
            'short_name' => 'DISEÑO DE MODAS',
            'modality_id' => $presencialModality->id,
            'title' => 'DISEÑADOR DE MODAS CON NIVEL EQUIVALENTE A TECNOLOGO SUPERIOR',
            'acronym' => 'DM',
            'logo' => 'careers/10.png',
            'type_id' => $technologyType->id
        ]);
        Career::create([
            'institution_id' => $yavirac->id,
            'name' => 'TECNOLOGIA SUPERIOR EN MARKETING',
            'short_name' => 'MARKETING',
            'modality_id' => $presencialModality->id,
            'title' => 'TECNOLOGO SUPERIOR EN MARKETING',
            'acronym' => 'MK',
            'logo' => 'careers/11.png',
            'type_id' => $technologyType->id
        ]);
        Career::create([
            'institution_id' => $yavirac->id,
            'name' => 'TECNOLOGIA SUPERIOR EN CONTROL DE INCENDIOS Y OPERACIONES DE RESCATE',
            'short_name' => 'CONTROL DE INCENDIOS Y OPERACIONES DE RESCATE',
            'modality_id' => $dualModality->id,
            'title' => 'TECNOLOGO SUPERIOR EN CONTROL DE INCENDIOS Y OPERACIONES DE RESCATE',
            'acronym' => 'CIOR',
            'logo' => 'careers/12.png',
            'type_id' => $technicalType->id
        ]);
        Career::create([
            'institution_id' => $mayo24->id,
            'name' => 'TECNOLOGIA SUPERIOR EN MARKETING',
            'short_name' => 'MARKETING',
            'modality_id' => $presencialModality->id,
            'title' => 'TECNOLOGO SUPERIOR EN MARKETING',
            'acronym' => 'MK',
            'logo' => 'careers/13.png',
            'type_id' => $technologyType->id
        ]);
    }

    private function createEthnicOriginCatalogues()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['ethnic_origin']['indigena'],
            'name' => 'INDIGENA',
            'type' => $catalogues['catalogue']['ethnic_origin']['type'],
        ]);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['ethnic_origin']['afroecuatoriano'],
            'name' => 'AFROECUATORIANO',
            'type' => $catalogues['catalogue']['ethnic_origin']['type'],
        ]);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['ethnic_origin']['negro'],
            'name' => 'NEGRO',
            'type' => $catalogues['catalogue']['ethnic_origin']['type'],
        ]);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['ethnic_origin']['mulato'],
            'name' => 'MULATO',
            'type' => $catalogues['catalogue']['ethnic_origin']['type'],
        ]);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['ethnic_origin']['montuvio'],
            'name' => 'MONTUVIO',
            'type' => $catalogues['catalogue']['ethnic_origin']['type'],
        ]);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['ethnic_origin']['mestizo'],
            'name' => 'MESTIZO',
            'type' => $catalogues['catalogue']['ethnic_origin']['type'],
        ]);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['ethnic_origin']['blanco'],
            'name' => 'BLANCO',
            'type' => $catalogues['catalogue']['ethnic_origin']['type'],
        ]);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['ethnic_origin']['other'],
            'name' => 'OTRO',
            'type' => $catalogues['catalogue']['ethnic_origin']['type'],
        ]);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['ethnic_origin']['unregistered'],
            'name' => 'NO REGISTRA',
            'type' => $catalogues['catalogue']['ethnic_origin']['type'],
        ]);
    }

    private function createIdentificationTypeCatalogues()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['identification_type']['cc'],
            'name' => 'CEDULA',
            'type' => $catalogues['catalogue']['identification_type']['type'],
        ]);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['identification_type']['passport'],
            'name' => 'PASAPORTE',
            'type' => $catalogues['catalogue']['identification_type']['type'],
        ]);
    }

    private function createBloodTypeCatalogues()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['blood_type']['a-'],
            'name' => 'A-',
            'type' => $catalogues['catalogue']['blood_type']['type'],
        ]);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['blood_type']['a+'],
            'name' => 'A+',
            'type' => $catalogues['catalogue']['blood_type']['type'],
        ]);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['blood_type']['b-'],
            'name' => 'B-',
            'type' => $catalogues['catalogue']['blood_type']['type'],
        ]);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['blood_type']['b+'],
            'name' => 'B+',
            'type' => $catalogues['catalogue']['blood_type']['type'],
        ]);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['blood_type']['ab-'],
            'name' => 'AB-',
            'type' => $catalogues['catalogue']['blood_type']['type'],
        ]);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['blood_type']['ab+'],
            'name' => 'AB+',
            'type' => $catalogues['catalogue']['blood_type']['type'],
        ]);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['blood_type']['o-'],
            'name' => 'O-',
            'type' => $catalogues['catalogue']['blood_type']['type'],
        ]);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['blood_type']['o+'],
            'name' => 'O+',
            'type' => $catalogues['catalogue']['blood_type']['type'],
        ]);
    }

    private function createSexCatalogues()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['sex']['male'],
            'name' => 'HOMBRE',
            'type' => $catalogues['catalogue']['sex']['type']
        ]);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['sex']['female'],
            'name' => 'MUJER',
            'type' => $catalogues['catalogue']['sex']['type'],
        ]);
    }

    private function createGenderCatalogues()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['gender']['male'],
            'name' => 'MASCULINO',
            'type' => $catalogues['catalogue']['gender']['type']
        ]);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['gender']['female'],
            'name' => 'FEMENINO',
            'type' => $catalogues['catalogue']['gender']['type'],
        ]);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['gender']['other'],
            'name' => 'OTRO',
            'type' => $catalogues['catalogue']['gender']['type'],
        ]);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['gender']['not_say'],
            'name' => 'PREFIERO NO DECIRLO',
            'type' => $catalogues['catalogue']['gender']['type'],
        ]);
    }

    private function createCivilStatusCatalogues()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['civil_status']['married'],
            'name' => 'CASADO/A',
            'type' => $catalogues['catalogue']['civil_status']['type']
        ]);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['civil_status']['single'],
            'name' => 'SOLTERO/A',
            'type' => $catalogues['catalogue']['civil_status']['type']
        ]);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['civil_status']['widower'],
            'name' => 'VIUDO/A',
            'type' => $catalogues['catalogue']['civil_status']['type']
        ]);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['civil_status']['divorced'],
            'name' => 'DIVORCIADO/A',
            'type' => $catalogues['catalogue']['civil_status']['type']
        ]);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['civil_status']['union'],
            'name' => 'UNIÓN DE HECHO',
            'type' => $catalogues['catalogue']['civil_status']['type']
        ]);
    }

    private function createCareerModality()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['career_modality']['full_attendance'],
            'name' => 'PRESENCIAL',
            'type' => $catalogues['catalogue']['career_modality']['type']
        ]);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['career_modality']['semi_attendance'],
            'name' => 'SEMI-PRESENCIAL',
            'type' => $catalogues['catalogue']['career_modality']['type']
        ]);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['career_modality']['distance'],
            'name' => 'DISTANCIA',
            'type' => $catalogues['catalogue']['career_modality']['type']
        ]);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['career_modality']['dual'],
            'name' => 'DISTANCIA',
            'type' => $catalogues['catalogue']['career_modality']['type']
        ]);
    }

    private function createLocationCatalogues()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['location']['country'],
            'name' => 'PAIS',
            'type' => $catalogues['catalogue']['location']['type'],
        ]);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['location']['province'],
            'name' => 'PROVINCIA',
            'type' => $catalogues['catalogue']['location']['type'],
        ]);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['location']['canton'],
            'name' => 'CANTON',
            'type' => $catalogues['catalogue']['location']['type'],
        ]);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['location']['parish'],
            'name' => 'PARISH',
            'type' => $catalogues['catalogue']['location']['type'],
        ]);
    }

    private function createLocations()
    {

    }

    private function createCareerType()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['career_type']['technology'],
            'name' => 'TECNOLOGIA',
            'type' => $catalogues['catalogue']['career_type']['type']
        ]);
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['career_type']['technical'],
            'name' => 'TECNICATURA',
            'type' => $catalogues['catalogue']['career_type']['type']
        ]);
    }

    private function createMenus()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        Catalogue::factory()->create([
            'code' => $catalogues['menu']['normal'],
            'name' => 'MENU',
            'type' => $catalogues['menu']['type'],
        ]);
        Catalogue::factory()->create([
            'code' => $catalogues['menu']['mega'],
            'name' => 'MEGA MENU',
            'type' => $catalogues['menu']['type'],
        ]);
    }

    private function createModules()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        $system = System::firstWhere('code', $catalogues['system']['code']);
        $statusAvailable = Status::firstWhere('code', $catalogues['status']['available']);

        Module::factory()->create([
            'code' => $catalogues['module']['authentication'],
            'name' => 'AUTHENTICATION',
            'system_id' => $system->id,
            'status_id' => $statusAvailable->id,
        ]);

        Module::factory()->create([
            'code' => $catalogues['module']['app'],
            'name' => 'APP',
            'system_id' => $system->id,
            'status_id' => $statusAvailable->id,
        ]);

        Module::factory()->create([
            'code' => $catalogues['module']['attendance'],
            'name' => 'ATTENDANCE',
            'system_id' => $system->id,
            'status_id' => $statusAvailable->id,
        ]);

        Module::factory()->create([
            'code' => $catalogues['module']['job_board'],
            'name' => 'JOB_BOARD',
            'system_id' => $system->id,
            'status_id' => $statusAvailable->id,
        ]);

        Module::factory()->create([
            'code' => $catalogues['module']['web'],
            'name' => 'WEB',
            'system_id' => $system->id,
            'status_id' => $statusAvailable->id,
        ]);

        Module::factory()->create([
            'code' => $catalogues['module']['teacher_eval'],
            'name' => 'TEACHER_EVAL',
            'system_id' => $system->id,
            'status_id' => $statusAvailable->id,
        ]);

        Module::factory()->create([
            'code' => $catalogues['module']['community'],
            'name' => 'COMMUNITY',
            'system_id' => $system->id,
            'status_id' => $statusAvailable->id,
        ]);

        Module::factory()->create([
            'code' => $catalogues['module']['cecy'],
            'name' => 'CECY',
            'system_id' => $system->id,
            'status_id' => $statusAvailable->id,
        ]);
    }

    private function createRoutes()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        $moduleAuthentication = Module::firstWhere('code', $catalogues['module']['authentication']);
        $menuNormal = Catalogue::firstWhere('code', $catalogues['menu']['normal']);
        $menuMega = Catalogue::firstWhere('code', $catalogues['menu']['mega']);
        $statusAvailable = Status::firstWhere('code', $catalogues['status']['available']);

        Route::factory()->create([
            'uri' => $catalogues['route']['dashboard'],
            'module_id' => $moduleAuthentication->id,
            'type_id' => $menuMega->id,
            'status_id' => $statusAvailable->id,
            'name' => 'DASHBOARD',
            'logo' => 'routes/route1.png',
            'order' => 1
        ]);

        Route::factory()->create([
            'uri' => $catalogues['route']['user']['user'],
            'module_id' => $moduleAuthentication->id,
            'type_id' => $menuMega->id,
            'status_id' => $statusAvailable->id,
            'name' => 'USUARIOS',
            'logo' => 'routes/route2.png',
            'order' => 1
        ]);

        Route::factory()->create([
            'uri' => $catalogues['route']['user']['administration'],
            'module_id' => $moduleAuthentication->id,
            'type_id' => $menuNormal->id,
            'status_id' => $statusAvailable->id,
            'name' => 'ADMINISTRACIÓN USUARIOS',
            'logo' => 'routes/route3.png',
            'order' => 2
        ]);
    }

    private function createUsers()
    {
        User::factory()->create([
            'username'=>'1234567890',
            'identification'=>'1234567890',
        ]);
        User::factory()->count(10)->create();
    }

    private function createUsersRoles()
    {
        $user = User::find(1);

        foreach (Role::all() as $role) {
            $user->roles()->attach($role->id);
        }
        $user = User::where('id','!=',1)->get();

        foreach ($user as $users) {
            $users->roles()->attach(random_int(1, Role::all()->count()));
        }
    }

    private function createUsersInstitutions()
    {
        $user = User::find(1);

        foreach (Institution::all() as $institution) {
            $user->institutions()->syncWithoutDetaching($institution->id);
        }
    }

    private function createSecurityQuestions()
    {
        SecurityQuestion::factory()->create(['name' => '¿Cuál es el nombre de su padre?']);
        SecurityQuestion::factory()->create(['name' => '¿Cuál es el nombre de su madre?']);
        SecurityQuestion::factory()->create(['name' => '¿Cuál es el nombre de su mascota?']);
        SecurityQuestion::factory()->create(['name' => '¿Cuál es el nombre de su mejor amigo de la infancia?']);
        SecurityQuestion::factory()->create(['name' => '¿Cuál es el nombre de su color favorito?']);
        SecurityQuestion::factory()->create(['name' => '¿Cuál es el nombre de su fruta favorita?']);
        SecurityQuestion::factory()->create(['name' => '¿Cuál es el nombre de su abuela materna?']);
        SecurityQuestion::factory()->create(['name' => '¿Cuál es el nombre de su abuela paterna?']);
        SecurityQuestion::factory()->create(['name' => '¿Cuál es su marca de auto favorito?']);
        SecurityQuestion::factory()->create(['name' => '¿Cuál es el nombre de su canción favorita?']);
    }
}
