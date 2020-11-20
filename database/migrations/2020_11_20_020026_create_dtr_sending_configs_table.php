<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDtrSendingConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dtr_sending_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('config', 100);
            $table->text('description')->nullable();
            $table->boolean('is_enabled')->default(0);
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
        Schema::dropIfExists('dtr_sending_configs');
    }
}
