<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sid');
            $table->Integer('classid');
            $table->Integer('examid');
            $table->Integer('subid');
            $table->string('subject');
            $table->Integer('AdmissionNo');
            $table->string('Fname');
            $table->string('Lname');
            $table->Integer('marks');
            $table->Integer('maxscore');
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
        Schema::dropIfExists('marks');
    }
}
