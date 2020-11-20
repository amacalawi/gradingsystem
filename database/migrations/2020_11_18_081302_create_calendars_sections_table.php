<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarsSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendars_sections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('calendar_id')->unsigned();
            $table->integer('section_info_id')->unsigned();
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
        Schema::dropIfExists('calendars_sections');
    }
}
