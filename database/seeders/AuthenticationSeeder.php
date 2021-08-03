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
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthenticationSeeder extends Seeder
{
    public function run()
    {
        $this->createStatus();

        // catalogos
        $this->createLocationCatalogues();
        $this->createLocations();
        $this->createIdentificationTypeCatalogues();
        $this->createEthnicOriginCatalogues();
        $this->createBloodTypeCatalogues();
        $this->createSexCatalogues();
        $this->createGenderCatalogues();
        $this->createCivilStatusCatalogues();
        $this->createMenus();
        $this->createSectorTypeCatalogues();


        // Sistemas
        $this->createSystem();

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
        Status::factory(7)->sequence(
            ['code' => $catalogues['status']['active'], 'name' => 'ACTIVO',],
            ['code' => $catalogues['status']['inactive'], 'name' => 'INACTIVO',],
            ['code' => $catalogues['status']['locked'], 'name' => 'BLOQUEADO',],
            ['code' => $catalogues['status']['available'], 'name' => 'HABILITADO',],
            ['code' => $catalogues['status']['maintenance'], 'name' => 'EN MANTENIMEINTO',],
            ['code' => $catalogues['status']['published'], 'name' => 'PUBLICADO',],
            ['code' => $catalogues['status']['unpublished'], 'name' => 'NO PUBLICADO',],
        )->create();
    }

    private function createRoles()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);

        Role::factory(3)->sequence(
            ['code' => $catalogues['role']['admin'], 'name' => 'ADMINISTRADOR',],
            ['code' => $catalogues['role']['professional'], 'name' => 'PROFESIONAL',],
            ['code' => $catalogues['role']['company'], 'name' => 'EMPRESA',],
        )->create();
    }

    private function createPermissions()
    {
        foreach (Route::all() as $route) {
            Permission::factory()->create([
                'route_id' => $route->id,
            ]);
        }
    }

    private function createRolePermissions()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        $system = System::firstWhere('code', $catalogues['system']['code']);

        foreach (Route::all() as $route) {
            foreach (Role::all() as $role) {
                $role->permissions()->attach(
                    Permission::where('route_id', $route->id)
                        ->where('system_id', $system->id)
                        ->first()
                );
            }
        }
    }

    private function createEthnicOriginCatalogues()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        Catalogue::factory(9)->sequence(
            [
                'code' => $catalogues['catalogue']['ethnic_origin']['indigena'],
                'name' => 'INDIGENA',
                'type' => $catalogues['catalogue']['ethnic_origin']['type'],
            ],
            [
                'code' => $catalogues['catalogue']['ethnic_origin']['afroecuatoriano'],
                'name' => 'AFROECUATORIANO',
                'type' => $catalogues['catalogue']['ethnic_origin']['type'],
            ],
            [
                'code' => $catalogues['catalogue']['ethnic_origin']['negro'],
                'name' => 'NEGRO',
                'type' => $catalogues['catalogue']['ethnic_origin']['type'],
            ],
            [
                'code' => $catalogues['catalogue']['ethnic_origin']['mulato'],
                'name' => 'MULATO',
                'type' => $catalogues['catalogue']['ethnic_origin']['type'],
            ],
            [
                'code' => $catalogues['catalogue']['ethnic_origin']['montuvio'],
                'name' => 'MONTUVIO',
                'type' => $catalogues['catalogue']['ethnic_origin']['type'],
            ],
            [
                'code' => $catalogues['catalogue']['ethnic_origin']['mestizo'],
                'name' => 'MESTIZO',
                'type' => $catalogues['catalogue']['ethnic_origin']['type'],
            ],
            [
                'code' => $catalogues['catalogue']['ethnic_origin']['blanco'],
                'name' => 'BLANCO',
                'type' => $catalogues['catalogue']['ethnic_origin']['type'],
            ],
            [
                'code' => $catalogues['catalogue']['ethnic_origin']['other'],
                'name' => 'OTRO',
                'type' => $catalogues['catalogue']['ethnic_origin']['type'],
            ],
            [
                'code' => $catalogues['catalogue']['ethnic_origin']['unregistered'],
                'name' => 'NO REGISTRA',
                'type' => $catalogues['catalogue']['ethnic_origin']['type'],
            ]
        )->create();
    }

    private function createIdentificationTypeCatalogues()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        Catalogue::factory(3)->sequence(
            [
                'code' => $catalogues['catalogue']['identification_type']['cc'],
                'name' => 'CEDULA',
                'type' => $catalogues['catalogue']['identification_type']['type'],
            ],
            [
                'code' => $catalogues['catalogue']['identification_type']['passport'],
                'name' => 'PASAPORTE',
                'type' => $catalogues['catalogue']['identification_type']['type'],
            ],
            [
                'code' => $catalogues['catalogue']['identification_type']['ruc'],
                'name' => 'R.U.C.',
                'type' => $catalogues['catalogue']['identification_type']['type'],
            ]
        )->create();
    }

    private function createBloodTypeCatalogues()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        Catalogue::factory(8)->sequence(
            [
                'code' => $catalogues['catalogue']['blood_type']['a-'],
                'name' => 'A-',
                'type' => $catalogues['catalogue']['blood_type']['type'],
            ],
            [
                'code' => $catalogues['catalogue']['blood_type']['a+'],
                'name' => 'A+',
                'type' => $catalogues['catalogue']['blood_type']['type'],
            ],
            [
                'code' => $catalogues['catalogue']['blood_type']['b-'],
                'name' => 'B-',
                'type' => $catalogues['catalogue']['blood_type']['type'],
            ],
            [
                'code' => $catalogues['catalogue']['blood_type']['b+'],
                'name' => 'B+',
                'type' => $catalogues['catalogue']['blood_type']['type'],
            ],
            [
                'code' => $catalogues['catalogue']['blood_type']['ab-'],
                'name' => 'AB-',
                'type' => $catalogues['catalogue']['blood_type']['type'],
            ],
            [
                'code' => $catalogues['catalogue']['blood_type']['ab+'],
                'name' => 'AB+',
                'type' => $catalogues['catalogue']['blood_type']['type'],
            ],
            [
                'code' => $catalogues['catalogue']['blood_type']['o-'],
                'name' => 'O-',
                'type' => $catalogues['catalogue']['blood_type']['type'],
            ],
            [
                'code' => $catalogues['catalogue']['blood_type']['o+'],
                'name' => 'O+',
                'type' => $catalogues['catalogue']['blood_type']['type'],
            ],
        )->create();
    }

    private function createSexCatalogues()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        Catalogue::factory(2)->sequence(
            [
                'code' => $catalogues['catalogue']['sex']['male'],
                'name' => 'HOMBRE',
                'type' => $catalogues['catalogue']['sex']['type']
            ],
            [
                'code' => $catalogues['catalogue']['sex']['female'],
                'name' => 'MUJER',
                'type' => $catalogues['catalogue']['sex']['type'],
            ]
        )->create();
    }

    private function createGenderCatalogues()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        Catalogue::factory(4)->sequence(
            [
                'code' => $catalogues['catalogue']['gender']['male'],
                'name' => 'MASCULINO',
                'type' => $catalogues['catalogue']['gender']['type']
            ],
            [
                'code' => $catalogues['catalogue']['gender']['female'],
                'name' => 'FEMENINO',
                'type' => $catalogues['catalogue']['gender']['type'],
            ],
            [
                'code' => $catalogues['catalogue']['gender']['other'],
                'name' => 'OTRO',
                'type' => $catalogues['catalogue']['gender']['type'],
            ],
            [
                'code' => $catalogues['catalogue']['gender']['not_say'],
                'name' => 'PREFIERO NO DECIRLO',
                'type' => $catalogues['catalogue']['gender']['type'],
            ],
        )->create();
    }

    private function createCivilStatusCatalogues()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        Catalogue::factory(5)->sequence(
            [
                'code' => $catalogues['catalogue']['civil_status']['married'],
                'name' => 'CASADO/A',
                'type' => $catalogues['catalogue']['civil_status']['type']
            ],
            [
                'code' => $catalogues['catalogue']['civil_status']['single'],
                'name' => 'SOLTERO/A',
                'type' => $catalogues['catalogue']['civil_status']['type']
            ],
            [
                'code' => $catalogues['catalogue']['civil_status']['widower'],
                'name' => 'VIUDO/A',
                'type' => $catalogues['catalogue']['civil_status']['type']
            ],
            [
                'code' => $catalogues['catalogue']['civil_status']['divorced'],
                'name' => 'DIVORCIADO/A',
                'type' => $catalogues['catalogue']['civil_status']['type']
            ],
            [
                'code' => $catalogues['catalogue']['civil_status']['union'],
                'name' => 'UNIÓN DE HECHO',
                'type' => $catalogues['catalogue']['civil_status']['type']
            ],
        )->create();
    }

    private function createSectorTypeCatalogues()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        Catalogue::factory(3)->sequence(
            [
                'name' => 'NORTE',
                'type' => $catalogues['catalogue']['sector']['type'],
            ],
            [
                'name' => 'CENTRO',
                'type' => $catalogues['catalogue']['sector']['type'],
            ],
            [
                'name' => 'SUR',
                'type' => $catalogues['catalogue']['sector']['type'],
            ],
        )->create();
    }

    private function createLocationCatalogues()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        Catalogue::factory(4)->sequence(
            [
                'code' => $catalogues['catalogue']['location']['country'],
                'name' => 'PAIS',
                'type' => $catalogues['catalogue']['location']['type'],
            ],
            [
                'code' => $catalogues['catalogue']['location']['province'],
                'name' => 'PROVINCIA',
                'type' => $catalogues['catalogue']['location']['type'],
            ],
            [
                'code' => $catalogues['catalogue']['location']['canton'],
                'name' => 'CANTON',
                'type' => $catalogues['catalogue']['location']['type'],
            ],
            [
                'code' => $catalogues['catalogue']['location']['parish'],
                'name' => 'PARROQUIA',
                'type' => $catalogues['catalogue']['location']['type'],
            ],
        )->create();
    }

    private function createLocations()
    {
        DB::select("insert into app.locations(type_id,code,name) values(1,'1','AFGANISTÁN');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'2','ALBANIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'3','ALEMANIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'4','ANDORRA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'5','ANGOLA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'6','ANGUILA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'7','ANTIGUA Y BARBUDA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'8','ARABIA SAUDITA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'9','ARGELIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'10','ARGENTINA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'11','ARMENIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'12','ARUBA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'13','AUSTRALIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'14','AUSTRIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'15','AZERBAIYÁN');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'16','BAHAMAS');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'17','BAHREIN');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'18','BANGLADESH');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'19','BARBADOS');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'20','BÉLGICA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'21','BELICE');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'22','BENIN');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'23','BERMUDAS');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'24','BIELORRUSIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'25','BOLIVIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'26','BONAIRE, SAN EUSTAQUIO Y SABA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'27','BOSNIA Y HERZEGOVINA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'28','BOTSWANA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'29','BRASIL');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'30','BRUNEI DARUSSALAM');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'31','BULGARIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'32','BURKINA FASO');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'33','BURUNDI');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'34','BUTÁN');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'35','CABO VERDE');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'36','CAMBOYA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'37','CAMERÚN');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'38','CANADA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'39','CHAD');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'40','CHILE');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'41','CHINA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'42','CHIPRE');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'43','COLOMBIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'44','COMORAS');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'45','CONGO');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'46','COREA DEL NORTE');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'47','COREA DEL SUR');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'48','COSTA DE MARﬁL');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'49','COSTA RICA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'50','CROACIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'51','CUBA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'52','CURAÇAO');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'53','DINAMARCA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'54','DJIBOUTI');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'55','DOMINICA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'56','ECUADOR');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'57','EGIPTO');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'58','EL SALVADOR');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'59','EL VATICANO');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'60','EMIRATOS ÁRABES UNIDOS');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'61','ERITREA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'62','ESLOVAQUIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'63','ESLOVENIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'64','ESPAÑA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'65','ESTADO DE PALESTINA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'66','ESTADOS UNIDOS DE AMÉRICA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'67','ESTONIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'68','ETIOPÍA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'69','FIYI');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'70','FILIPINAS');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'71','FINLANDIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'72','FRANCIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'73','GABÓN');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'74','GAMBIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'75','GEORGIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'76','GHANA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'77','GIBRALTAR');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'78','GRANADA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'79','GRECIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'80','GROENLANDIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'81','GUADALUPE');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'82','GUAM');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'83','GUATEMALA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'84','GUAYANA FRANCESA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'85','GUERNSEY');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'86','GUINEA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'87','GUINEA ECUATORIAL');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'88','GUINEA-BISSAU');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'89','GUYANA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'90','HAITÍ');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'91','HONDURAS');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'92','HONG KONG');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'93','HUNGRÍA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'94','INDIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'95','INDONESIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'96','IRAK');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'97','IRÁN');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'98','IRLANDA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'99','ISLA DE MAN');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'100','ISLA NORFOLK');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'101','ISLANDIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'102','ISLAS ÅLAND');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'103','ISLAS CAIMÁN');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'104','ISLAS COOK');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'106','ISLAS FEROE');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'107','ISLAS MALVINAS (FALKLAND)');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'108','ISLAS MARIANAS DEL NORTE');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'109','ISLAS MARSHALL');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'110','ISLAS SALOMÓN');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'111','ISLAS TURCAS Y CAICOS');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'112','ISLAS VÍRGENES AMERICANAS');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'113','ISLAS VÍRGENES BRITÁNICAS');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'114','ISLAS WALLIS Y FUTUNA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'115','ISRAEL');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'116','ITALIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'117','JAMAICA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'118','JAPÓN');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'119','JERSEY');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'120','JORDANIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'121','KAZAJSTÁN');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'122','KENYA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'123','KIRGUISTÁN');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'124','KIRIBATI');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'125','KUWAIT');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'126','LA EX REPÚBLICA YUGOSLAVA DE MACEDONIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'127','LESOTO');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'128','LETONIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'129','LÍBANO');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'130','LIBERIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'131','LIBIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'132','LIECHTENSTEIN');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'133','LITUANIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'134','LUXEMBURGO');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'135','MACAO');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'136','MADAGASCAR');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'137','MALASIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'138','MALAUI');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'139','MALDIVAS');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'140','MALÍ');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'141','MALTA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'142','MARRUECOS');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'143','MARTINICA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'144','MAURICIO');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'145','MAURITANIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'146','MAYOTTE');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'147','MÉXICO');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'148','MICRONESIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'149','MÓNACO');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'150','MONGOLIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'151','MONTENEGRO');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'152','MONTSERRAT');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'153','MOZAMBIQUE');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'154','MYANMAR');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'155','NAMIBIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'156','NAURU');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'157','NEPAL');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'158','NICARAGUA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'159','NÍGER');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'160','NIGERIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'161','NIUE');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'162','NORUEGA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'163','NUEVA CALEDONIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'164','NUEVA ZELANDA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'165','OMÁN');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'166','PAÍSES BAJOS');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'167','PAKISTÁN');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'168','PALAU');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'169','PANAMÁ');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'170','PAPÚA NUEVA GUINEA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'171','PARAGUAY');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'172','PERÚ');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'173','PITCAIRN');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'174','POLINESIA FRANCÉS');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'175','POLONIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'176','PORTUGAL');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'177','PUERTO RICO');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'178','QATAR');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'179','REINO UNIDO DE GRAN BRETAÑA E IRLANDA DEL NORTE');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'180','REPÚBLICA ÁRABE SIRIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'181','REPÚBLICA CENTROAFRICANA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'182','REPÚBLICA CHECA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'183','REPÚBLICA DE MOLDAVIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'184','REPÚBLICA DEMOCRÁTICA DEL CONGO');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'185','REPÚBLICA DEMOCRÁTICA POPULAR LAO');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'186','REPÚBLICA DOMINICANA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'187','REPÚBLICA UNIDA DE TANZANIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'188','RÉUNION');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'189','RUMANIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'190','RUSIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'191','RWANDA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'192','SÁHARA OCCIDENTAL');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'193','SAINT-BARTHÉLEMY');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'194','SAINT-MARTIN');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'195','SAMOA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'196','SAMOA AMERICANA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'197','SAN CRISTÓBAL Y NIEVES');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'198','SAN MARINO');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'199','SAN PEDRO Y MIQUELÓN');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'200','SAN VICENTE Y LAS GRANADINAS');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'201','SANTA ELENA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'202','SANTA LUCÍA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'203','SANTO TOMÉ Y PRÍNCIPE');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'205','SENEGAL');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'206','SERBIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'207','SEYCHELLES');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'208','SIERRA LEONA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'209','SINGAPUR');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'210','SINT MAARTEN');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'211','SOMALIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'212','SRI LANKA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'213','SUDÁFRICA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'214','SUDÁN');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'215','SUDÁN DEL SUR');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'216','SUECIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'217','SUIZA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'218','SURINAME');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'219','SVALBARD Y JAN MAYEN');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'220','SWAZILANDIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'221','TAILANDIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'222','TAYIKISTÁN');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'223','TIMOR-LESTE');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'224','TOGO');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'225','TOKELAU');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'226','TONGA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'227','TRINIDAD Y TOBAGO');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'228','TÚNEZ');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'229','TURKMENISTÁN');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'230','TURQUÍA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'231','TUVALU');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'232','UCRANIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'233','UGANDA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'234','URUGUAY');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'235','UZBEKISTÁN');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'236','VANUATU');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'237','VENEZUELA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'238','VIET NAM');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'239','YEMEN');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'240','ZAMBIA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'241','ZIMBABWE');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'242','ANTÁRTIDA');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'243','ISLA BOUVET');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'244','TERRITORIO BRITÁNICO DE LA OCÉANO ÍNDICO');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'245','TAIWÁN');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'246','ISLA DE NAVIDAD');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'247','ISLAS COCOS');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'248','GEORGIA DEL SUR Y LAS ISLAS SANDWICH DEL SUR');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'249','TERRITORIOS AUSTRALES FRANCESES');");
        DB::select("insert into app.locations(type_id,code,name) values(1,'999','NO REGISTRA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(2,56,'01','AZUAY');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(2,56,'02','BOLIVAR');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(2,56,'03','CAÑAR');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(2,56,'04','CARCHI');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(2,56,'05','COTOPAXI');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(2,56,'06','CHIMBORAZO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(2,56,'07','EL ORO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(2,56,'08','ESMERALDAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(2,56,'09','GUAYAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(2,56,'10','IMBABURA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(2,56,'11','LOJA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(2,56,'12','LOS RIOS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(2,56,'13','MANABI');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(2,56,'14','MORONA SANTIAGO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(2,56,'15','NAPO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(2,56,'16','PASTAZA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(2,56,'17','PICHINCHA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(2,56,'18','TUNGURAHUA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(2,56,'19','ZAMORA CHINCHIPE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(2,56,'20','GALAPAGOS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(2,56,'21','SUCUMBIOS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(2,56,'22','ORELLANA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(2,56,'23','SANTO DOMINGO DE LOS TSACHILAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(2,56,'24','SANTA ELENA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(2,56,'90','ZONAS NO DELIMITADAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,249,'0101','CUENCA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,249,'0102','GIRÓN');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,249,'0103','GUALACEO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,249,'0104','NABÓN');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,249,'0105','PAUTE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,249,'0106','PUCARA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,249,'0107','SAN FERNANDO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,249,'0108','SANTA ISABEL');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,249,'0109','SIGSIG');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,249,'0110','OÑA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,249,'0111','CHORDELEG');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,249,'0112','EL PAN');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,249,'0113','SEVILLA DE ORO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,249,'0114','GUACHAPALA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,249,'0115','CAMILO PONCE ENRÍQUEZ');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,250,'0201','GUARANDA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,250,'0202','CHILLANES');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,250,'0203','CHIMBO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,250,'0204','ECHEANDÍA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,250,'0205','SAN MIGUEL');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,250,'0206','CALUMA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,250,'0207','LAS NAVES');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,251,'0301','AZOGUES');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,251,'0302','BIBLIÁN');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,251,'0303','CAÑAR');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,251,'0304','LA TRONCAL');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,251,'0305','EL TAMBO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,251,'0306','DÉLEG');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,251,'0307','SUSCAL');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,252,'0401','TULCÁN');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,252,'0402','BOLÍVAR');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,252,'0403','ESPEJO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,252,'0404','MIRA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,252,'0405','MONTÚFAR');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,252,'0406','SAN PEDRO DE HUACA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,253,'0501','LATACUNGA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,253,'0502','LA MANÁ');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,253,'0503','PANGUA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,253,'0504','PUJILI');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,253,'0505','SALCEDO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,253,'0506','SAQUISILÍ');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,253,'0507','SIGCHOS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,254,'0601','RIOBAMBA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,254,'0602','ALAUSI');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,254,'0603','COLTA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,254,'0604','CHAMBO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,254,'0605','CHUNCHI');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,254,'0606','GUAMOTE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,254,'0607','GUANO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,254,'0608','PALLATANGA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,254,'0609','PENIPE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,254,'0610','CUMANDÁ');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,255,'0701','MACHALA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,255,'0702','ARENILLAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,255,'0703','ATAHUALPA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,255,'0704','BALSAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,255,'0705','CHILLA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,255,'0706','EL GUABO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,255,'0707','HUAQUILLAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,255,'0708','MARCABELÍ');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,255,'0709','PASAJE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,255,'0710','PIÑAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,255,'0711','PORTOVELO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,255,'0712','SANTA ROSA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,255,'0713','ZARUMA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,255,'0714','LAS LAJAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,256,'0801','ESMERALDAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,256,'0802','ELOY ALFARO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,256,'0803','MUISNE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,256,'0804','QUININDÉ');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,256,'0805','SAN LORENZO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,256,'0806','ATACAMES');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,256,'0807','RIOVERDE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,256,'0808','LA CONCORDIA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,257,'0901','GUAYAQUIL');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,257,'0902','EDO BAQUERIZO MORENO (JU');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,257,'0903','BALAO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,257,'0904','BALZAR');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,257,'0905','COLIMES');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,257,'0906','DAULE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,257,'0907','DURÁN');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,257,'0908','EL EMPALME');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,257,'0909','EL TRIUNFO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,257,'0910','MILAGRO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,257,'0911','NARANJAL');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,257,'0912','NARANJITO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,257,'0913','PALESTINA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,257,'0914','PEDRO CARBO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,257,'0915','SAMBORONDÓN');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,257,'0916','SANTA LUCÍA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,257,'0917','SALITRE (URBINA JADO)');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,257,'0918','SAN JACINTO DE YAGUACHI');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,257,'0919','PLAYAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,257,'0920','SIMÓN BOLÍVAR');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,257,'0921','RONEL MARCELINO MARIDUE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,257,'0922','LOMAS DE SARGENTILLO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,257,'0923','NOBOL');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,257,'0924','GENERAL ANTONIO ELIZALDE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,257,'0925','ISIDRO AYORA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,258,'1001','IBARRA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,258,'1002','ANTONIO ANTE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,258,'1003','COTACACHI');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,258,'1004','OTAVALO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,258,'1005','PIMAMPIRO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,258,'1006','SAN MIGUEL DE URCUQUÍ');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,259,'1107','LOJA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,259,'1108','CALVAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,259,'1109','CATAMAYO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,259,'1110','CELICA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,259,'1111','CHAGUARPAMBA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,259,'1112','ESPÍNDOLA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,259,'1113','GONZANAMÁ');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,259,'1114','MACARÁ');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,259,'1115','PALTAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,259,'1116','PUYANGO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,259,'1117','SARAGURO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,259,'1118','SOZORANGA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,259,'1119','ZAPOTILLO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,259,'1120','PINDAL');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,259,'1121','QUILANGA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,259,'1122','OLMEDO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,260,'1201','BABAHOYO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,260,'1202','BABA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,260,'1203','MONTALVO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,260,'1204','PUEBLOVIEJO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,260,'1205','QUEVEDO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,260,'1206','URDANETA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,260,'1207','VENTANAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,260,'1208','VÍNCES');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,260,'1209','PALENQUE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,260,'1210','BUENA FÉ');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,260,'1211','VALENCIA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,260,'1212','MOCACHE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,260,'1213','QUINSALOMA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,261,'1301','PORTOVIEJO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,261,'1302','BOLÍVAR');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,261,'1303','CHONE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,261,'1304','EL CARMEN');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,261,'1305','FLAVIO ALFARO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,261,'1306','JIPIJAPA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,261,'1307','JUNÍN');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,261,'1308','MANTA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,261,'1309','MONTECRISTI');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,261,'1310','PAJÁN');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,261,'1311','PICHINCHA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,261,'1312','ROCAFUERTE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,261,'1313','SANTA ANA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,261,'1314','SUCRE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,261,'1315','TOSAGUA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,261,'1316','24 DE MAYO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,261,'1317','PEDERNALES');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,261,'1318','OLMEDO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,261,'1319','PUERTO LÓPEZ');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,261,'1320','JAMA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,261,'1321','JARAMIJÓ');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,261,'1322','SAN VICENTE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,262,'1401','MORONA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,262,'1402','GUALAQUIZA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,262,'1403','LIMÓN INDANZA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,262,'1404','PALORA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,262,'1405','SANTIAGO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,262,'1406','SUCÚA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,262,'1407','HUAMBOYA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,262,'1408','SAN JUAN BOSCO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,262,'1409','TAISHA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,262,'1410','LOGROÑO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,262,'1411','PABLO SEXTO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,262,'1412','TIWINTZA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,263,'1501','TENA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,263,'1502','ARCHIDONA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,263,'1503','EL CHACO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,263,'1504','QUIJOS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,263,'1505','ARLOS JULIO AROSEMENA TOL');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,264,'1601','PASTAZA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,264,'1602','MERA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,264,'1603','SANTA CLARA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,264,'1604','ARAJUNO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,265,'1701','QUITO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,265,'1702','CAYAMBE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,265,'1703','MEJIA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,265,'1704','PEDRO MONCAYO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,265,'1705','RUMIÑAHUI');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,265,'1706','SAN MIGUEL DE LOS BANCOS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,265,'1707','PEDRO VICENTE MALDONADO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,265,'1708','PUERTO QUITO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,266,'1801','AMBATO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,266,'1802','BAÑOS DE AGUA SANTA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,266,'1803','CEVALLOS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,266,'1804','MOCHA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,266,'1805','PATATE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,266,'1806','QUERO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,266,'1807','SAN PEDRO DE PELILEO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,266,'1808','SANTIAGO DE PÍLLARO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,266,'1809','TISALEO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,267,'1901','ZAMORA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,267,'1902','CHINCHIPE');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,267,'1903','NANGARITZA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,267,'1904','YACUAMBI');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,267,'1905','YANTZAZA (YANZATZA)');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,267,'1906','EL PANGUI');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,267,'1907','CENTINELA DEL CÓNDOR');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,267,'1908','PALANDA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,267,'1909','PAQUISHA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,268,'2001','SAN CRISTÓBAL');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,268,'2002','ISABELA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,268,'2003','SANTA CRUZ');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,269,'2101','LAGO AGRIO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,269,'2102','GONZALO PIZARRO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,269,'2103','PUTUMAYO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,269,'2104','SHUSHUFINDI');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,269,'2105','SUCUMBÍOS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,269,'2106','CASCALES');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,269,'2107','CUYABENO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,270,'2201','ORELLANA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,270,'2202','AGUARICO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,270,'2203','LA JOYA DE LOS SACHAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,270,'2204','LORETO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,271,'2301','SANTO DOMINGO');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,272,'2401','SANTA ELENA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,272,'2402','LA LIBERTAD');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,272,'2403','SALINAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,273,'9001','LAS GOLONDRINAS');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,273,'9002','MANGA DEL CURA');");
        DB::select("insert into app.locations(type_id,parent_id,code,name) values(3,273,'9003','EL PIEDRERO');");

    }

    private function createMenus()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        Catalogue::factory(2)->sequence(
            [
                'code' => $catalogues['menu']['normal'],
                'name' => 'MENU',
                'type' => $catalogues['menu']['type'],
            ],
            [
                'code' => $catalogues['menu']['mega'],
                'name' => 'MEGA MENU',
                'type' => $catalogues['menu']['type'],
            ],
        )->create();
    }

    private function createModules()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        $system = System::firstWhere('code', $catalogues['system']['code']);
        $statusAvailable = Status::firstWhere('code', $catalogues['status']['available']);

        Module::factory(2)->sequence(
            [
                'code' => $catalogues['module']['authentication'],
                'name' => 'AUTHENTICATION',
                'system_id' => $system->id,
                'status_id' => $statusAvailable->id,
            ],
            [
                'code' => $catalogues['module']['job_board'],
                'name' => 'BOLSA DE EMPLEO',
                'system_id' => $system->id,
                'status_id' => $statusAvailable->id,
            ],
        )->create();
    }

    private function createRoutes()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        $moduleAuthentication = Module::firstWhere('code', $catalogues['module']['authentication']);
        $menuNormal = Catalogue::firstWhere('code', $catalogues['menu']['normal']);
        $menuMega = Catalogue::firstWhere('code', $catalogues['menu']['mega']);
        $statusAvailable = Status::firstWhere('code', $catalogues['status']['available']);

        Route::factory(4)->sequence(
            [
                'uri' => $catalogues['route']['dashboard'],
                'module_id' => $moduleAuthentication->id,
                'type_id' => $menuMega->id,
                'status_id' => $statusAvailable->id,
                'name' => 'DASHBOARD',
                'logo' => 'routes/route1.png',
                'order' => 1
            ],
            [
                'uri' => $catalogues['route']['user']['user'],
                'module_id' => $moduleAuthentication->id,
                'type_id' => $menuMega->id,
                'status_id' => $statusAvailable->id,
                'name' => 'USUARIOS',
                'logo' => 'routes/route2.png',
                'order' => 1
            ],
            [
                'uri' => $catalogues['route']['user']['administration'],
                'module_id' => $moduleAuthentication->id,
                'type_id' => $menuNormal->id,
                'status_id' => $statusAvailable->id,
                'name' => 'ADMINISTRACIÓN USUARIOS',
                'logo' => 'routes/route3.png',
                'order' => 2
            ],
            [
                'uri' => $catalogues['route']['job_board']['company'],
                'module_id' => $moduleAuthentication->id,
                'type_id' => $menuMega->id,
                'status_id' => $statusAvailable->id,
                'name' => 'USUARIOS',
                'logo' => 'routes/route2.png',
                'order' => 1
            ],
        )->create();
    }

    private function createUsers()
    {
        User::factory()->create([
            'username' => '1234567890',
            'identification' => '1234567890',
        ]);
        User::factory(10)->create();
    }

    private function createUsersRoles()
    {
        $user = User::find(1);
        $role = Role::find(1);
        $user->roles()->attach($role->id);

        $user = User::where('id', '!=', 1)->get();

        foreach ($user as $users) {
            $users->roles()->attach(random_int(1, Role::all()->count()));
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
