<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresetMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preset_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->text('message');
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
        Schema::dropIfExists('preset_messages');
    }
}
