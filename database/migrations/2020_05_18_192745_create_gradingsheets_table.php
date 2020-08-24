<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradingsheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gradingsheets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('batch_id')->unsigned();
            $table->integer('quarter_id')->unsigned();
            $table->integer('education_type_id')->unsigned();
            $table->integer('section_id')->unsigned();
            $table->integer('material_id')->unsigned();
            $table->integer('subject_id')->unsigned();
            $table->string('code', 100);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('created_by')->unsigned();
            $table->timestamp('updated_at')->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->boolean('is_locked')->default(0);
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
        Schema::dropIfExists('gradingsheets');
    }
}
