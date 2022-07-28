<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('desc');
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->date('date');
            $table->double('salary');
            $table->enum('status', ['active', 'deactive','stop']);
            $table->enum('overnight', ['active', 'deactive']);
            $table->enum('health_inssurance', ['active', 'deactive']);
            $table->enum('permission', ['active', 'deactive']);
            $table->unsignedBigInteger('contractor_id');
            $table->foreign('contractor_id')->references('id')->on('contractors');
            $table->unsignedBigInteger('currency_id');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->unsignedBigInteger('job_salary_id');
            $table->foreign('job_salary_id')->references('id')->on('job_salary');
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
        Schema::dropIfExists('jobs');
    }
}
