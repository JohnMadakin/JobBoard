<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('title');
            $table->integer('userId')->unsigned();
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->text('summary');
            $table->text('description');
            $table->text('responsibilities');
            $table->text('experience');
            $table->text('additionalCompetences')->nullable();
            $table->text('guideline');
            $table->string('salary');
            $table->date('expiryDate');
            $table->integer('specId')->unsigned();
            $table->foreign('specId')->references('id')-> on('specs');
            $table->string('location');
            $table->integer('jobTypeId')->unsigned();
            $table->foreign( 'jobTypeId')->references('id')->on('jobTypes');
            $table->boolean('published')->default(false);
            $table->timestamps();
            $table->softDeletes();
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
