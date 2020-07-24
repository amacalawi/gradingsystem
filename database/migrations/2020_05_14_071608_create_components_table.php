<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('components', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('batch_id')->unsigned();
            $table->integer('section_id')->unsigned(); 
            $table->integer('subject_id')->unsigned(); 
            $table->integer('education_type_id')->unsigned();
            $table->integer('material_id')->unsigned();
            $table->string('name', 40);
            $table->double('percentage');
            $table->text('description')->nullable();
            $table->string('palette', 40);
            $table->integer('order')->unsigned();
            $table->boolean('is_sum_cell')->default(0);
            $table->boolean('is_hps_cell')->default(0);
            $table->boolean('is_ps_cell')->default(0);
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
        Schema::dropIfExists('components');
    }
}
