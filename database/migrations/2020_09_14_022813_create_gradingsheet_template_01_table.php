<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradingsheetTemplate01Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gradingsheet_template_01', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identification_no', 11);
            $table->string('firstname', 40);
            $table->string('middlename', 40);
            $table->string('lastname', 40);
            $table->string('grade_level', 40);
            $table->string('section', 40);
            $table->string('adviser', 100);
            $table->string('academics_status', 15);
            $table->string('eligibility', 100);
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('gradingsheet_template_01');
    }
}
