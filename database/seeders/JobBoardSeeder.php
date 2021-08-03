<?php

namespace Database\Seeders;

use App\Models\App\Catalogue;
use App\Models\App\Location;
use App\Models\Authentication\User;
use App\Models\JobBoard\AcademicFormation;
use App\Models\JobBoard\Company;
use App\Models\JobBoard\Offer;
use App\Models\JobBoard\Skill;
use App\Models\App\Status;
use App\Models\Authentication\Route;
use App\Models\JobBoard\Category;
use App\Models\JobBoard\Professional;
use Database\Factories\JobBoard\LocationFactory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class JobBoardSeeder extends Seeder
{
    public function run()
    {
        $this->createCategories();
        $this->createCompanyCatalogues();
        $this->createLanguageCatalogues();
        $this->createCourseCatalogues();
        $this->createSkillCatalogues();
        $this->createOfferCatalogues();
        $this->createProfessionals();
        $this->createCompanies();
        $this->createSkills();
        $this->createOfferStatus();
//        $this->createOffers();
    }

    private function createProfessionals()
    {
        foreach (User::all() as $user) {
            $professional = new Professional();
            $professional->user()->associate($user);
            $professional->save();
        }
    }

    private function createCompanies()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        $types = Catalogue::where('type', $catalogues['catalogue']['company_type']['type'])->get();
        $activityTypes = Catalogue::where('type', $catalogues['catalogue']['company_activity_type']['type'])->get();
        $personTypes = Catalogue::where('type', $catalogues['catalogue']['company_person_type']['type'])->get();
        foreach (User::all() as $user) {
            Company::factory()->create([
                'type_id' => $types[rand(0, $types->count()-1)]['id'],
                'activity_type_id' => $activityTypes[rand(0, $activityTypes->count()-1)]['id'],
                'person_type_id' => $personTypes[rand(0, $personTypes->count()-1)]['id'],
                'user_id' => $user->id
            ]);
        }
    }

    private function createCategories()
    {
        $categories = Category::factory()->count(10)->create();

        foreach ($categories as $category) {
            Category::factory()->count(20)->create(['parent_id' => $category->id]);
        }
    }

    private function createSkillCatalogues()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        $softSkill = Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['skill_type']['soft'],
            'name' => 'HABILIDADES BLANDAS',
            'type' => $catalogues['catalogue']['skill_type']['type']
        ]);
        $hardSkill = Catalogue::factory()->create([
            'code' => $catalogues['catalogue']['skill_type']['hard'],
            'name' => 'HABILIDADES DURAS',
            'type' => $catalogues['catalogue']['skill_type']['type']
        ]);
        Catalogue::factory()->count(10)->create([
            'parent_id' => $softSkill->id,
            'type' => $catalogues['catalogue']['skill_type']['type']
        ]);

        Catalogue::factory()->count(10)->create([
            'parent_id' => $hardSkill->id,
            'type' => $catalogues['catalogue']['skill_type']['type'],
        ]);
    }

    private function createCompanyCatalogues()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        // Tipo
        Catalogue::factory()->count(3)->state(new Sequence(
            ['name' => 'PRIVADA'],
            ['name' => 'PUBLICA'],
            ['name' => 'MIXTA'],
        ))->create([
            'type' => $catalogues['catalogue']['company_type']['type']
        ]);

        // ACTIVIDAD COMERCIAL
        Catalogue::factory()->count(23)->state(new Sequence(
            ['name' => 'ACTIVIDADES COMUNITARIAS'],
            ['name' => 'ACTIVIDADES DE SALUD'],
            ['name' => 'ACTIVIDADES TIPO SERVICIOS'],
            ['name' => 'AGRICULTURA Y PLANTACIONES'],
            ['name' => 'ARTESANÍAS'],
            ['name' => 'COMERCIALIZACIÓN Y VENTA DE PRODUCTOS'],
            ['name' => 'CONSTRUCCIÓN'],
            ['name' => 'ELECTRICIDAD, GAS Y AGUA'],
            ['name' => 'ENSEÑANZA'],
            ['name' => 'METALMECÁNICA'],
            ['name' => 'MINAS, CANTERAS Y YACIMIENTOS'],
            ['name' => 'PESCA, ACUACULTURA Y MARICULTURA'],
            ['name' => 'PRODUCCION INDUSTRIAL DE BEBIDAS Y TABACOS'],
            ['name' => 'PRODUCCIÓN PECUARIA'],
            ['name' => 'PRODUCTOS INDUSTRIALES, FARMACÉUTICOS Y QUÍMICOS'],
            ['name' => 'PRODUCTOS TEXTILES, CUERO Y CALZADO'],
            ['name' => 'SERVICIO DOMÉSTICO'],
            ['name' => 'SERVICIOS FINANCIEROS'],
            ['name' => 'TECNOLOGÍA: HARDWARE Y SOFTWARE (INCLUYE TICS)'],
            ['name' => 'TRANSFORMACIÓN DE ALIMENTOS  (INCLUYE AGROINDUSTRIA)'],
            ['name' => 'TRANSPORTE, ALMACENAMIENTO Y LOGÍSTICA'],
            ['name' => 'TURISMO Y ALIMENTACIÓN'],
            ['name' => 'VEHICULOS, AUTOMOTORES, CARROCERÍAS Y SUS PARTES'],
        ))->create([
            'type' => $catalogues['catalogue']['company_activity_type']['type']
        ]);

        // PERSONA
        Catalogue::factory()->count(2)
            ->state(new Sequence(
                ['name' => 'NATURAL'],
                ['name' => 'JURIDICA'],
            ))->create([
                'type' => $catalogues['catalogue']['company_person_type']['type']
            ]);
    }

    private function createLanguageCatalogues()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        Catalogue::factory()->count(3)->create([
            'type' => $catalogues['catalogue']['language_level']['type']
        ]);

        Catalogue::factory()->count(50)->create([
            'type' => $catalogues['catalogue']['language_type']['type']
        ]);
    }

    private function createCourseCatalogues()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        Catalogue::factory()->count(10)->create([
            'type' => $catalogues['catalogue']['course_event_type']['type']
        ]);

        Catalogue::factory()->count(70)->create([
            'type' => $catalogues['catalogue']['course_institution']['type']
        ]);

        Catalogue::factory()->count(2)->create([
            'type' => $catalogues['catalogue']['course_certification_type']['type']
        ]);

        Catalogue::factory()->count(20)->create([
            'type' => $catalogues['catalogue']['course_area']['type']
        ]);
    }

    private function createSkills()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        $professional = Professional::find(1);
        $types = Catalogue::where('type', $catalogues['catalogue']['skill_type']['type'])->where('parent_id', '<>', null);

        for ($i = 0; $i < 1; $i++) {
            foreach ($types as $type) {
                Skill::factory()->count(100)->create([
                    'professional_id' => $professional->id,
                    'type_id' => $type->id
                ]);
            }
        }
    }

    private function createOfferCatalogues()
    {
        $catalogues = json_decode(file_get_contents(storage_path() . "/catalogues.json"), true);
        Catalogue::factory()->count(4)->create([
            'type' => $catalogues['catalogue']['offer_contract_type']['type']
        ]);

        Catalogue::factory()->count(20)->create([
            'type' => $catalogues['catalogue']['offer_position']['type'],
        ]);

        Catalogue::factory()->count(20)->create([
            'type' => $catalogues['catalogue']['offer_working_day']['type'],
        ]);

        Catalogue::factory()->count(20)->create([
            'type' => $catalogues['catalogue']['offer_experience_time']['type'],
        ]);

        Catalogue::factory()->count(20)->create([
            'type' => $catalogues['catalogue']['offer_training_hours']['type'],
        ]);
    }

    private function createOffers()
    {
        Offer::factory(100)->create();

        // offers with categories.
        $i = 1;
        foreach (Offer::all() as $offer) {
            $offer->categories()->attach($i++);
        }
    }

    private function createOfferStatus()
    {
        $status = Status::whereIn('id', [6, 7])->get();
        foreach ($status as $state) {
            $state->routes()->attach(4);
        }
    }

}
