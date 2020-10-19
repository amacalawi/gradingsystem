<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->string('identification_no', 11)->unique();
            $table->string('learners_reference_no', 12)->nullable();
            $table->string('firstname', 40);
            $table->string('middlename', 40)->nullable();
            $table->string('lastname', 40);
            $table->string('suffix', 40)->nullable();
            $table->string('gender', 10);
            $table->string('marital_status', 40);
            $table->date('birthdate');
            $table->text('current_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('mobile_no', 40)->nullable();
            $table->string('telephone_no', 40)->nullable();
            $table->date('admitted_date')->nullable();
            $table->boolean('is_guardian')->default(0);
            $table->boolean('is_sibling')->default(0);
            $table->text('special_remarks')->nullable();
            $table->text('avatar')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('created_by')->unsigned();
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
        Schema::dropIfExists('students');
    }
}
