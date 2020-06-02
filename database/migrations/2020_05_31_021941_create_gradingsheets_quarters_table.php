<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradingsheetsQuartersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gradingsheets_quarters', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('gradingsheet_id')->unsigned();
            $table->integer('batch_id')->unsigned();
            $table->integer('quarter_id')->unsigned();
            $table->integer('student_id')->unsigned();
            $table->double('initial_grade')->nullable();
            $table->double('adjustment_grade')->nullable();
            $table->double('quarter_grade')->nullable();
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
        Schema::dropIfExists('gradingsheets_quarters');
    }
}
