<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectmeansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjectmeans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sid');
            $table->integer('tid');
            $table->integer('subid');
            $table->string('class');
            $table->string('classid')->nullable();
            $table->string('mean_marks');
            $table->string('mean_points');
            $table->string('mean_grade');
            $table->integer('student_count')->default('0');
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
        Schema::dropIfExists('subjectmeans');
    }
}
