<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffsTable extends Migration
{   
    protected $table = 'staffs';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        if (Schema::hasTable($this->table)) {
            return;
        }

        Schema::create('staffs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->integer('department_id')->unsigned();
            $table->integer('designation_id')->unsigned();
            $table->string('identification_no', 11)->unique();
            $table->string('type', 40);
            $table->string('specification', 40);
            $table->string('firstname', 40);
            $table->string('middlename', 40)->nullable();
            $table->string('lastname', 40);
            $table->string('suffix', 40)->nullable();
            $table->string('gender', 10);
            $table->string('marital_status', 40);
            $table->date('birthdate');
            $table->text('current_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('mobile_no', 40)->nullable();
            $table->string('telephone_no', 40)->nullable();
            $table->date('date_joined');
            $table->date('date_resigned')->nullable();
            $table->text('avatar')->nullable();
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
        Schema::dropIfExists('staffs');
    }
}
