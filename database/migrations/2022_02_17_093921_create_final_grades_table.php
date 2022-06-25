<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinalGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('final_grades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sid');
            $table->integer('tid');
            $table->integer('AdmissionNo');
            $table->string('FName');
            $table->string('Lname');
            $table->integer('subid');
            $table->integer('classid');
            $table->string('availablescores');
            $table->string('scores');
            $table->integer('score');
            $table->integer('points')->nullable();
            $table->string('grade')->nullable();
            $table->string('Remarks')->nullable();
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
        Schema::dropIfExists('final_grades');
    }
}
