<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuardiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guardians', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('member_id')->unsigned();
            $table->string('mother_firstname', 40);
            $table->string('mother_middlename', 40)->nullable();
            $table->string('mother_lastname', 40);
            $table->string('mother_contact_no', 40);
            $table->text('mother_avatar')->nullable();
            $table->boolean('mother_selected')->default(0);
            $table->string('father_firstname', 40);
            $table->string('father_middlename', 40)->nullable();
            $table->string('father_lastname', 40);
            $table->string('father_contact_no', 40);
            $table->text('father_avatar')->nullable();
            $table->boolean('father_selected')->default(0);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('created_by');
            $table->timestamp('updated_at')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('guardians');
    }
}
