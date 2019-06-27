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
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('summary');
            $table->text('description');
            $table->text('responsibilities');
            $table->text('experience');
            $table->text('additionalCompetencies')->nullable();
            $table->text('guideline');
            $table->string('salary')->default('No Details Yet');
            $table->date('expiryDate');
            $table->integer('spec_id')->unsigned();
            $table->foreign('spec_id')->references('id')-> on('specs');
            $table->string('location');
            $table->integer('jobType_id')->unsigned();
            $table->foreign( 'jobType_id')->references('id')->on('jobTypes');
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
