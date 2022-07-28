<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractors', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('father_name');
            $table->string('grand_name');
            $table->string('family_name');
            $table->string('photo')->nullable();
            $table->string('email');
            $table->string('id_number');
            $table->string('mobile');
            $table->integer('code');
            $table->enum('status', ['Active', 'Deactive']);
            $table->string('password')->nullable();
            $table->string('company_name')->nullable();
            $table->string('id_card')->nullable();
            $table->string('license')->nullable();
            $table->string('other_doc')->nullable();
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
        Schema::dropIfExists('contractors');
    }
}
