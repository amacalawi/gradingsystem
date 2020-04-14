<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members_informations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('member_id')->unsigned();
            $table->text('current_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('mobile_no', 40)->nullable();
            $table->string('telephone_no', 40)->nullable();
            $table->text('special_remarks')->nullable();
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
        Schema::dropIfExists('members_informations');
    }
}
