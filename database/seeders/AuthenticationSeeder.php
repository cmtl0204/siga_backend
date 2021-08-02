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
use Illuminate\Support\Facades\DB;

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
        $this->createLocationCatalogues();
        $this->createLocations();
        $this->createCareerType();
        $this->createMenus();
        $this->createSectorTypeCatalogues();

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
        Status::factory()->create([
            'code' => $catalogues['status']['published'],
            'name' => 'PUBLICADO',
        ]);
        Status::factory()->create([
            'code' => $catalogues['status']['unpublished'],
            'name' => 'NO PUBLICADO',
        ]);
    }

    private function createRoles()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);

        //$system = System::firstWhere('code', $catalogues['system']['code']);
        $institution = Institution::find(1);
        foreach (System::all() as $system) {
            Role::factory()->create([
                'code' => $catalogues['role']['admin'],
                'name' => 'ADMINISTRADOR',
                'system_id' => $system->id,
                'institution_id' => $institution->id
            ]);

            Role::factory()->create([
                'code' => $catalogues['role']['professional'],
                'name' => 'PROFESIONAL',
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
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['identification_type']['ruc'],
            'name' => 'R.U.C.',
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
        Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['career_modality']['hybrid'],
            'name' => 'HIBRIDA',
            'type' => $catalogues['catalogue']['career_modality']['type']
        ]);
    }

    private function createSectorTypeCatalogues()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        Catalogue::factory()->create([
            'name' => 'NORTE',
            'type' => $catalogues['catalogue']['sector']['type'],
        ]);
        Catalogue::factory()->create([
            'name' => 'CENTRO',
            'type' => $catalogues['catalogue']['sector']['type'],
        ]);
        Catalogue::factory()->create([
            'name' => 'SUR',
            'type' => $catalogues['catalogue']['sector']['type'],
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
            'name' => 'PARROQUIA',
            'type' => $catalogues['catalogue']['location']['type'],
        ]);
    }

    private function createLocations()
    {
        DB::select("insert into app.locations(type_id,code,name) values(37,'1','AFGANISTÁN');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'2','ALBANIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'3','ALEMANIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'4','ANDORRA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'5','ANGOLA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'6','ANGUILA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'7','ANTIGUA Y BARBUDA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'8','ARABIA SAUDITA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'9','ARGELIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'10','ARGENTINA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'11','ARMENIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'12','ARUBA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'13','AUSTRALIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'14','AUSTRIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'15','AZERBAIYÁN');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'16','BAHAMAS');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'17','BAHREIN');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'18','BANGLADESH');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'19','BARBADOS');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'20','BÉLGICA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'21','BELICE');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'22','BENIN');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'23','BERMUDAS');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'24','BIELORRUSIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'25','BOLIVIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'26','BONAIRE, SAN EUSTAQUIO Y SABA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'27','BOSNIA Y HERZEGOVINA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'28','BOTSWANA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'29','BRASIL');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'30','BRUNEI DARUSSALAM');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'31','BULGARIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'32','BURKINA FASO');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'33','BURUNDI');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'34','BUTÁN');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'35','CABO VERDE');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'36','CAMBOYA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'37','CAMERÚN');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'38','CANADA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'39','CHAD');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'40','CHILE');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'41','CHINA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'42','CHIPRE');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'43','COLOMBIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'44','COMORAS');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'45','CONGO');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'46','COREA DEL NORTE');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'47','COREA DEL SUR');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'48','COSTA DE MARﬁL');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'49','COSTA RICA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'50','CROACIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'51','CUBA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'52','CURAÇAO');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'53','DINAMARCA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'54','DJIBOUTI');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'55','DOMINICA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'56','ECUADOR');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'57','EGIPTO');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'58','EL SALVADOR');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'59','EL VATICANO');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'60','EMIRATOS ÁRABES UNIDOS');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'61','ERITREA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'62','ESLOVAQUIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'63','ESLOVENIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'64','ESPAÑA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'65','ESTADO DE PALESTINA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'66','ESTADOS UNIDOS DE AMÉRICA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'67','ESTONIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'68','ETIOPÍA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'69','FIYI');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'70','FILIPINAS');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'71','FINLANDIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'72','FRANCIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'73','GABÓN');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'74','GAMBIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'75','GEORGIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'76','GHANA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'77','GIBRALTAR');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'78','GRANADA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'79','GRECIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'80','GROENLANDIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'81','GUADALUPE');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'82','GUAM');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'83','GUATEMALA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'84','GUAYANA FRANCESA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'85','GUERNSEY');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'86','GUINEA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'87','GUINEA ECUATORIAL');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'88','GUINEA-BISSAU');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'89','GUYANA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'90','HAITÍ');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'91','HONDURAS');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'92','HONG KONG');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'93','HUNGRÍA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'94','INDIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'95','INDONESIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'96','IRAK');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'97','IRÁN');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'98','IRLANDA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'99','ISLA DE MAN');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'100','ISLA NORFOLK');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'101','ISLANDIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'102','ISLAS ÅLAND');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'103','ISLAS CAIMÁN');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'104','ISLAS COOK');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'106','ISLAS FEROE');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'107','ISLAS MALVINAS (FALKLAND)');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'108','ISLAS MARIANAS DEL NORTE');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'109','ISLAS MARSHALL');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'110','ISLAS SALOMÓN');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'111','ISLAS TURCAS Y CAICOS');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'112','ISLAS VÍRGENES AMERICANAS');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'113','ISLAS VÍRGENES BRITÁNICAS');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'114','ISLAS WALLIS Y FUTUNA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'115','ISRAEL');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'116','ITALIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'117','JAMAICA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'118','JAPÓN');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'119','JERSEY');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'120','JORDANIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'121','KAZAJSTÁN');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'122','KENYA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'123','KIRGUISTÁN');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'124','KIRIBATI');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'125','KUWAIT');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'126','LA EX REPÚBLICA YUGOSLAVA DE MACEDONIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'127','LESOTO');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'128','LETONIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'129','LÍBANO');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'130','LIBERIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'131','LIBIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'132','LIECHTENSTEIN');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'133','LITUANIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'134','LUXEMBURGO');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'135','MACAO');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'136','MADAGASCAR');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'137','MALASIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'138','MALAUI');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'139','MALDIVAS');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'140','MALÍ');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'141','MALTA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'142','MARRUECOS');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'143','MARTINICA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'144','MAURICIO');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'145','MAURITANIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'146','MAYOTTE');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'147','MÉXICO');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'148','MICRONESIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'149','MÓNACO');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'150','MONGOLIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'151','MONTENEGRO');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'152','MONTSERRAT');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'153','MOZAMBIQUE');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'154','MYANMAR');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'155','NAMIBIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'156','NAURU');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'157','NEPAL');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'158','NICARAGUA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'159','NÍGER');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'160','NIGERIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'161','NIUE');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'162','NORUEGA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'163','NUEVA CALEDONIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'164','NUEVA ZELANDA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'165','OMÁN');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'166','PAÍSES BAJOS');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'167','PAKISTÁN');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'168','PALAU');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'169','PANAMÁ');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'170','PAPÚA NUEVA GUINEA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'171','PARAGUAY');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'172','PERÚ');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'173','PITCAIRN');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'174','POLINESIA FRANCÉS');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'175','POLONIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'176','PORTUGAL');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'177','PUERTO RICO');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'178','QATAR');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'179','REINO UNIDO DE GRAN BRETAÑA E IRLANDA DEL NORTE');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'180','REPÚBLICA ÁRABE SIRIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'181','REPÚBLICA CENTROAFRICANA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'182','REPÚBLICA CHECA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'183','REPÚBLICA DE MOLDAVIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'184','REPÚBLICA DEMOCRÁTICA DEL CONGO');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'185','REPÚBLICA DEMOCRÁTICA POPULAR LAO');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'186','REPÚBLICA DOMINICANA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'187','REPÚBLICA UNIDA DE TANZANIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'188','RÉUNION');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'189','RUMANIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'190','RUSIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'191','RWANDA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'192','SÁHARA OCCIDENTAL');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'193','SAINT-BARTHÉLEMY');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'194','SAINT-MARTIN');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'195','SAMOA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'196','SAMOA AMERICANA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'197','SAN CRISTÓBAL Y NIEVES');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'198','SAN MARINO');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'199','SAN PEDRO Y MIQUELÓN');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'200','SAN VICENTE Y LAS GRANADINAS');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'201','SANTA ELENA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'202','SANTA LUCÍA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'203','SANTO TOMÉ Y PRÍNCIPE');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'205','SENEGAL');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'206','SERBIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'207','SEYCHELLES');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'208','SIERRA LEONA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'209','SINGAPUR');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'210','SINT MAARTEN');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'211','SOMALIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'212','SRI LANKA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'213','SUDÁFRICA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'214','SUDÁN');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'215','SUDÁN DEL SUR');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'216','SUECIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'217','SUIZA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'218','SURINAME');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'219','SVALBARD Y JAN MAYEN');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'220','SWAZILANDIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'221','TAILANDIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'222','TAYIKISTÁN');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'223','TIMOR-LESTE');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'224','TOGO');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'225','TOKELAU');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'226','TONGA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'227','TRINIDAD Y TOBAGO');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'228','TÚNEZ');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'229','TURKMENISTÁN');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'230','TURQUÍA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'231','TUVALU');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'232','UCRANIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'233','UGANDA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'234','URUGUAY');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'235','UZBEKISTÁN');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'236','VANUATU');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'237','VENEZUELA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'238','VIET NAM');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'239','YEMEN');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'240','ZAMBIA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'241','ZIMBABWE');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'242','ANTÁRTIDA');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'243','ISLA BOUVET');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'244','TERRITORIO BRITÁNICO DE LA OCÉANO ÍNDICO');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'245','TAIWÁN');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'246','ISLA DE NAVIDAD');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'247','ISLAS COCOS');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'248','GEORGIA DEL SUR Y LAS ISLAS SANDWICH DEL SUR');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'249','TERRITORIOS AUSTRALES FRANCESES');");
        DB::select("insert into app.locations(type_id,code,name) values(37,'999','NO REGISTRA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(38,56,'01','AZUAY');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(38,56,'02','BOLIVAR');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(38,56,'03','CAÑAR');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(38,56,'04','CARCHI');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(38,56,'05','COTOPAXI');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(38,56,'06','CHIMBORAZO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(38,56,'07','EL ORO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(38,56,'08','ESMERALDAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(38,56,'09','GUAYAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(38,56,'10','IMBABURA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(38,56,'11','LOJA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(38,56,'12','LOS RIOS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(38,56,'13','MANABI');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(38,56,'14','MORONA SANTIAGO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(38,56,'15','NAPO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(38,56,'16','PASTAZA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(38,56,'17','PICHINCHA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(38,56,'18','TUNGURAHUA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(38,56,'19','ZAMORA CHINCHIPE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(38,56,'20','GALAPAGOS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(38,56,'21','SUCUMBIOS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(38,56,'22','ORELLANA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(38,56,'23','SANTO DOMINGO DE LOS TSACHILAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(38,56,'24','SANTA ELENA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(38,56,'90','ZONAS NO DELIMITADAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,249,'0101','CUENCA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,249,'0102','GIRÓN');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,249,'0103','GUALACEO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,249,'0104','NABÓN');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,249,'0105','PAUTE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,249,'0106','PUCARA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,249,'0107','SAN FERNANDO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,249,'0108','SANTA ISABEL');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,249,'0109','SIGSIG');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,249,'0110','OÑA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,249,'0111','CHORDELEG');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,249,'0112','EL PAN');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,249,'0113','SEVILLA DE ORO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,249,'0114','GUACHAPALA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,249,'0115','CAMILO PONCE ENRÍQUEZ');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,250,'0201','GUARANDA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,250,'0202','CHILLANES');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,250,'0203','CHIMBO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,250,'0204','ECHEANDÍA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,250,'0205','SAN MIGUEL');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,250,'0206','CALUMA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,250,'0207','LAS NAVES');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,251,'0301','AZOGUES');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,251,'0302','BIBLIÁN');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,251,'0303','CAÑAR');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,251,'0304','LA TRONCAL');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,251,'0305','EL TAMBO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,251,'0306','DÉLEG');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,251,'0307','SUSCAL');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,252,'0401','TULCÁN');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,252,'0402','BOLÍVAR');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,252,'0403','ESPEJO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,252,'0404','MIRA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,252,'0405','MONTÚFAR');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,252,'0406','SAN PEDRO DE HUACA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,253,'0501','LATACUNGA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,253,'0502','LA MANÁ');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,253,'0503','PANGUA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,253,'0504','PUJILI');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,253,'0505','SALCEDO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,253,'0506','SAQUISILÍ');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,253,'0507','SIGCHOS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,254,'0601','RIOBAMBA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,254,'0602','ALAUSI');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,254,'0603','COLTA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,254,'0604','CHAMBO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,254,'0605','CHUNCHI');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,254,'0606','GUAMOTE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,254,'0607','GUANO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,254,'0608','PALLATANGA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,254,'0609','PENIPE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,254,'0610','CUMANDÁ');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,255,'0701','MACHALA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,255,'0702','ARENILLAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,255,'0703','ATAHUALPA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,255,'0704','BALSAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,255,'0705','CHILLA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,255,'0706','EL GUABO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,255,'0707','HUAQUILLAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,255,'0708','MARCABELÍ');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,255,'0709','PASAJE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,255,'0710','PIÑAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,255,'0711','PORTOVELO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,255,'0712','SANTA ROSA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,255,'0713','ZARUMA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,255,'0714','LAS LAJAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,256,'0801','ESMERALDAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,256,'0802','ELOY ALFARO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,256,'0803','MUISNE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,256,'0804','QUININDÉ');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,256,'0805','SAN LORENZO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,256,'0806','ATACAMES');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,256,'0807','RIOVERDE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,256,'0808','LA CONCORDIA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,257,'0901','GUAYAQUIL');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,257,'0902','EDO BAQUERIZO MORENO (JU');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,257,'0903','BALAO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,257,'0904','BALZAR');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,257,'0905','COLIMES');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,257,'0906','DAULE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,257,'0907','DURÁN');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,257,'0908','EL EMPALME');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,257,'0909','EL TRIUNFO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,257,'0910','MILAGRO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,257,'0911','NARANJAL');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,257,'0912','NARANJITO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,257,'0913','PALESTINA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,257,'0914','PEDRO CARBO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,257,'0915','SAMBORONDÓN');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,257,'0916','SANTA LUCÍA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,257,'0917','SALITRE (URBINA JADO)');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,257,'0918','SAN JACINTO DE YAGUACHI');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,257,'0919','PLAYAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,257,'0920','SIMÓN BOLÍVAR');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,257,'0921','RONEL MARCELINO MARIDUE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,257,'0922','LOMAS DE SARGENTILLO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,257,'0923','NOBOL');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,257,'0924','GENERAL ANTONIO ELIZALDE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,257,'0925','ISIDRO AYORA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,258,'1001','IBARRA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,258,'1002','ANTONIO ANTE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,258,'1003','COTACACHI');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,258,'1004','OTAVALO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,258,'1005','PIMAMPIRO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,258,'1006','SAN MIGUEL DE URCUQUÍ');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,259,'1107','LOJA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,259,'1108','CALVAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,259,'1109','CATAMAYO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,259,'1110','CELICA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,259,'1111','CHAGUARPAMBA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,259,'1112','ESPÍNDOLA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,259,'1113','GONZANAMÁ');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,259,'1114','MACARÁ');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,259,'1115','PALTAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,259,'1116','PUYANGO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,259,'1117','SARAGURO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,259,'1118','SOZORANGA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,259,'1119','ZAPOTILLO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,259,'1120','PINDAL');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,259,'1121','QUILANGA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,259,'1122','OLMEDO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,260,'1201','BABAHOYO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,260,'1202','BABA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,260,'1203','MONTALVO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,260,'1204','PUEBLOVIEJO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,260,'1205','QUEVEDO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,260,'1206','URDANETA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,260,'1207','VENTANAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,260,'1208','VÍNCES');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,260,'1209','PALENQUE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,260,'1210','BUENA FÉ');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,260,'1211','VALENCIA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,260,'1212','MOCACHE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,260,'1213','QUINSALOMA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,261,'1301','PORTOVIEJO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,261,'1302','BOLÍVAR');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,261,'1303','CHONE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,261,'1304','EL CARMEN');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,261,'1305','FLAVIO ALFARO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,261,'1306','JIPIJAPA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,261,'1307','JUNÍN');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,261,'1308','MANTA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,261,'1309','MONTECRISTI');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,261,'1310','PAJÁN');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,261,'1311','PICHINCHA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,261,'1312','ROCAFUERTE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,261,'1313','SANTA ANA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,261,'1314','SUCRE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,261,'1315','TOSAGUA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,261,'1316','24 DE MAYO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,261,'1317','PEDERNALES');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,261,'1318','OLMEDO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,261,'1319','PUERTO LÓPEZ');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,261,'1320','JAMA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,261,'1321','JARAMIJÓ');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,261,'1322','SAN VICENTE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,262,'1401','MORONA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,262,'1402','GUALAQUIZA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,262,'1403','LIMÓN INDANZA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,262,'1404','PALORA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,262,'1405','SANTIAGO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,262,'1406','SUCÚA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,262,'1407','HUAMBOYA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,262,'1408','SAN JUAN BOSCO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,262,'1409','TAISHA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,262,'1410','LOGROÑO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,262,'1411','PABLO SEXTO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,262,'1412','TIWINTZA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,263,'1501','TENA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,263,'1502','ARCHIDONA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,263,'1503','EL CHACO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,263,'1504','QUIJOS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,263,'1505','ARLOS JULIO AROSEMENA TOL');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,264,'1601','PASTAZA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,264,'1602','MERA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,264,'1603','SANTA CLARA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,264,'1604','ARAJUNO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,265,'1701','QUITO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,265,'1702','CAYAMBE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,265,'1703','MEJIA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,265,'1704','PEDRO MONCAYO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,265,'1705','RUMIÑAHUI');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,265,'1706','SAN MIGUEL DE LOS BANCOS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,265,'1707','PEDRO VICENTE MALDONADO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,265,'1708','PUERTO QUITO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,266,'1801','AMBATO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,266,'1802','BAÑOS DE AGUA SANTA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,266,'1803','CEVALLOS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,266,'1804','MOCHA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,266,'1805','PATATE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,266,'1806','QUERO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,266,'1807','SAN PEDRO DE PELILEO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,266,'1808','SANTIAGO DE PÍLLARO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,266,'1809','TISALEO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,267,'1901','ZAMORA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,267,'1902','CHINCHIPE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,267,'1903','NANGARITZA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,267,'1904','YACUAMBI');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,267,'1905','YANTZAZA (YANZATZA)');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,267,'1906','EL PANGUI');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,267,'1907','CENTINELA DEL CÓNDOR');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,267,'1908','PALANDA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,267,'1909','PAQUISHA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,268,'2001','SAN CRISTÓBAL');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,268,'2002','ISABELA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,268,'2003','SANTA CRUZ');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,269,'2101','LAGO AGRIO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,269,'2102','GONZALO PIZARRO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,269,'2103','PUTUMAYO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,269,'2104','SHUSHUFINDI');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,269,'2105','SUCUMBÍOS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,269,'2106','CASCALES');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,269,'2107','CUYABENO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,270,'2201','ORELLANA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,270,'2202','AGUARICO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,270,'2203','LA JOYA DE LOS SACHAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,270,'2204','LORETO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,271,'2301','SANTO DOMINGO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,272,'2401','SANTA ELENA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,272,'2402','LA LIBERTAD');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,272,'2403','SALINAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,273,'9001','LAS GOLONDRINAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,273,'9002','MANGA DEL CURA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(39,273,'9003','EL PIEDRERO');");
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

        Route::factory()->create([
            'uri' => $catalogues['route']['job_board']['company'],
            'module_id' => $moduleAuthentication->id,
            'type_id' => $menuMega->id,
            'status_id' => $statusAvailable->id,
            'name' => 'USUARIOS',
            'logo' => 'routes/route2.png',
            'order' => 1
        ]);
    }

    private function createUsers()
    {
        User::factory()->create([
            'username' => '1234567890',
            'identification' => '1234567890',
        ]);
        User::factory()->count(10)->create();
    }

    private function createUsersRoles()
    {
        $user = User::find(1);

        foreach (Role::all() as $role) {
            $user->roles()->attach($role->id);
        }
        $user = User::where('id', '!=', 1)->get();

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
