<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppStudentInformationTable extends Migration
{
    public function up()
    {
        Schema::connection('pgsql-app')->create('student_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->constrained('registration.enrollments');
            $table->foreignId('location_id')->constrained('app.locations');
            $table->foreignId('immigration_category_id')->nullable()->constrained('app.catalogues'); //type string
            $table->foreignId('civil_status_id')->nullable()->constrained('app.catalogues'); //type string
            $table->foreignId('ancestral_language_id')->nullable()->constrained('app.catalogues'); //type string
            $table->foreignId('scholarship_type_id')->nullable()->constrained('app.catalogues'); //type string
            $table->foreignId('disability_type_id')->nullable()->constrained('app.catalogues'); //type string
            $table->foreignId('scholarship_financing_type_id')->nullable()->constrained('app.catalogues'); //type string
            $table->foreignId('type_institution_practices_id')->nullable()->constrained('app.catalogues'); //type string
            $table->foreignId('address_id')->constrained('app.address'); //type string
            $table->double('family_income', 8, 2)->nullable();
            $table->double('amount_financial_aid', 8, 2)->nullable();
            $table->double('amount_scholarship', 8, 2)->nullable();
            $table->double('educational_credit_amount', 8, 2)->nullable();
            $table->double('disability percentage', 8, 2)->nullable();
            $table->double('percent_scholarship_coverage_fee', 8, 2)->nullable();
            $table->double('percent_scholarship_coverage_maintenance', 8, 2)->nullable();
            $table->integer('practical_hours')->nullable();
            $table->integer('bonding_hours')->nullable();
            $table->integer('number_household_members')->nullable();
            $table->string('bonding_scope')->nullable();
            $table->string('company_work_area')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('emergency_contact_names')->nullable();
            $table->string('kinship_emergency_contact')->nullable();//catalogue for parentesco
            $table->string('emergency_contact_phone')->nullable();
            $table->string('destination_income')->nullable();
            $table->boolean('is_gratuity_lost');
            $table->boolean('is_done_internships');
            $table->boolean('is_done_bonding');
            $table->boolean('is_repeated_subject');
            $table->boolean('is_speaks_ancestral_language');
            $table->string('mother_education_level')->nullable();
            $table->string('father_education_level')->nullable();
            $table->string('work_company_name')->nullable();
            $table->string('conadis_card_number')->nullable();
            $table->string('occupation')->nullable();//catalogue for ocupacion
            $table->string('differentiated_pension')->nullable();
            $table->boolean('higher_degree');
            $table->string('scholarship_reason');
            $table->string('scholarship_reason_two');
            $table->string('scholarship_reason_three');
            $table->string('scholarship_reason_four');
            $table->string('scholarship_reason_five');
            $table->string('scholarship_reason_six');
            $table->boolean('receive_development_bonus')->nullable();
            $table->string('economic_sector_practices');//catalogue
            $table->string('cell_phone')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_disability');
            $table->string('higher_degree_obtained');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('pgsql-app')->dropIfExists('student_information');
    }
}
