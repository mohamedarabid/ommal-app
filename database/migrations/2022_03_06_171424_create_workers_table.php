<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('father_name');
            $table->string('grand_name');
            $table->string('family_name');
            $table->string('email');
            $table->string('id_number');
            $table->string('mobile');
            $table->integer('code');
            $table->enum('status', ['Active', 'Deactive']);
            $table->string('password')->nullable();
            $table->date('marriage_date')->nullable();
            $table->text('experiences')->nullable();
            $table->integer('years_experiences')->nullable();
            $table->string('id_card')->nullable();
            $table->string('magnetic_card')->nullable();
            $table->string('permission_card')->nullable();
            $table->string('bank_paper')->nullable();
            $table->string('other_doc')->nullable();
            $table->unsignedBigInteger('Work_field_id')->nullable();
            $table->foreign('Work_field_id')->references('id')->on('work_types')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workers');
    }
}
