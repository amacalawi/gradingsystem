<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnrollmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('batch_id')->unsigned();
            $table->string('student_email', 40);
            $table->boolean('is_new')->default(1);
            $table->string('student_no', 40)->nullable();
            $table->string('student_lrn', 12);
            $table->string('student_psa_no', 100);
            $table->integer('level_id')->unsigned();
            $table->string('student_firstname', 100);
            $table->string('student_middlename', 100)->nullable();
            $table->string('student_lastname', 100);
            $table->double('student_age');
            $table->string('student_gender', 40);
            $table->date('student_birthdate')->nullable();
            $table->string('student_birthorder', 40);
            $table->string('student_reside_with', 40);
            $table->text('student_address')->nullable();
            $table->text('student_barangay')->nullable();
            $table->text('student_last_attended')->nullable();
            $table->text('student_transfer_reason')->nullable();
            $table->string('father_firstname', 100);
            $table->string('father_middlename', 100)->nullable();
            $table->string('father_lastname', 100);
            $table->string('father_contact', 20);
            $table->date('father_birthdate')->nullable();
            $table->text('father_birthplace')->nullable();
            $table->text('father_address')->nullable();
            $table->string('father_religion', 40);
            $table->string('father_specific_religion', 40)->nullable();
            $table->string('father_occupation', 100)->nullable();
            $table->string('father_education', 100)->nullable();
            $table->string('father_employment_status', 100)->nullable();
            $table->string('father_workplace', 100)->nullable();
            $table->string('father_work_quarantine', 100)->nullable();
            $table->string('mother_firstname', 100);
            $table->string('mother_middlename', 100)->nullable();
            $table->string('mother_lastname', 100);
            $table->string('mother_maidenname', 100);
            $table->string('mother_contact', 20);
            $table->date('mother_birthdate')->nullable();
            $table->text('mother_birthplace')->nullable();
            $table->text('mother_address')->nullable();
            $table->string('mother_religion', 40);
            $table->string('mother_specific_religion', 40)->nullable();
            $table->string('mother_occupation', 100)->nullable();
            $table->string('mother_education', 100)->nullable();
            $table->string('mother_employment_status', 100)->nullable();
            $table->string('mother_workplace', 100)->nullable();
            $table->string('mother_work_quarantine', 100)->nullable();
            $table->string('parent_marriage_status', 40);
            $table->string('guardian_firstname', 100);
            $table->string('guardian_middlename', 100)->nullable();
            $table->string('guardian_lastname', 100);
            $table->string('guardian_contact', 20);
            $table->string('guardian_relationship', 40);
            $table->string('guardian_employment_status', 100)->nullable();
            $table->string('guardian_work_quarantine', 100)->nullable();
            $table->string('family_4ps', 20)->nullable();
            $table->text('student_siblings')->nullable();
            $table->text('student_previous_academic')->nullable();
            $table->string('student_transpo', 100)->nullable();
            $table->string('student_studying', 100)->nullable();
            $table->string('specific_student_studying', 100)->nullable();
            $table->string('student_supplies', 100)->nullable();
            $table->text('student_devices')->nullable();
            $table->string('specific_student_devices', 100)->nullable();
            $table->string('student_with_internet', 100)->nullable();
            $table->text('student_internet_connection')->nullable();
            $table->string('student_describe_internet', 255)->nullable();
            $table->string('student_learning_modality', 255)->nullable();
            $table->string('student_learning_delivery', 255)->nullable();
            $table->text('student_challenges_education')->nullable();
            $table->string('specific_student_challenges_education', 100)->nullable();
            $table->text('student_documents')->nullable();
            $table->string('student_tuition_fee_types', 100)->nullable();
            $table->integer('payment_term_id')->unsigned();
            $table->string('student_sibling_discount', 100)->nullable();
            $table->string('student_subsidy_grantee', 100)->nullable();
            $table->integer('payment_option_id')->unsigned();
            $table->string('student_acknowledge_1', 20)->nullable();
            $table->string('student_acknowledge_2', 20)->nullable();
            $table->string('student_acknowledge_3', 20)->nullable();
            $table->string('student_acknowledge_4', 20)->nullable();
            $table->string('status', 20)->default('enlisted');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('created_by')->unsigned()->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->boolean('is_active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enrollments');
    }
}
