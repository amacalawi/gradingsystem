<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoaTemplate01Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soa_template_01', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identification_no', 11);
            $table->string('firstname', 40);
            $table->string('middlename', 40);
            $table->string('lastname', 40);
            $table->double('outstanding_balance')->nullable();
            $table->text('billing_period')->nullable();
            $table->date('billing_due_date');
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
        Schema::dropIfExists('soa_template_01');
    }
}
