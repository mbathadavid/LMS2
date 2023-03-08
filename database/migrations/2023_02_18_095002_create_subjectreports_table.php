<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectreportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjectreports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sid');
            $table->Integer('studentid');
            $table->string('AdmUPI');
            $table->string('Name');
            $table->string('subject');
            $table->string('subjectid');
            $table->longText('report');
            $table->string('date');
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
        Schema::dropIfExists('subjectreports');
    }
}
