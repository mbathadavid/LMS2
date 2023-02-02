<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCbcmarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cbcmarks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sid');
            $table->Integer('classid');
            $table->Integer('examid');
            $table->Integer('subid');
            $table->string('subject');
            $table->string('AdmissionNo');
            $table->string('Name');
            $table->Integer('marks');
            $table->Integer('maxscore');
            $table->string('Grade')->nullable();
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
        Schema::dropIfExists('cbcmarks');
    }
}
