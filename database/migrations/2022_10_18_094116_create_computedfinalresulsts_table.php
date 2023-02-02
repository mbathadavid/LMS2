<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComputedfinalresulstsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('computedfinalresulsts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sid');
            $table->integer('tid');
            $table->string('AdmissionNo');
            $table->string('FName');
            $table->string('Lname');
            $table->integer('Finalscore')->nullable();
            $table->string('Finalgrade')->nullable();
            $table->string('Remarks')->nullable();
            $table->string('ScoresByPoints')->nullable();
            $table->string('ScoresByMarks')->nullable();
            $table->string('Grades')->nullable();
            $table->string('KCPE_marks')->nullable();
            $table->string('KCPE_rank')->nullable();
            $table->string('Prev_Score')->nullable();
            $table->string('DEV')->nullable();
            $table->string('STRPOS')->nullable();
            $table->string('OVRPOS')->nullable();
            $table->string('Class');
            $table->integer('Class_id');
            $table->string('Subjects')->nullable();
            $table->timestamps();

            $table->foreign('sid')->references('id')->on('school__data')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('computedfinalresulsts');
    }
}
