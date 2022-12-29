<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sid');
            $table->integer('subid');
            $table->string('subject');
            $table->string('class');
            $table->string('minA');
            $table->string('maxA');
            $table->string('pointA');
            $table->string('gradeA');
            $table->string('RemarksA');
            $table->string('minA_minus');
            $table->string('maxA_minus');
            $table->string('pointA_minus');
            $table->string('gradeA_minus');
            $table->string('RemarksA_minus');
            $table->string('minB_plus');
            $table->string('maxB_plus');
            $table->string('pointB_plus');
            $table->string('gradeB_plus');
            $table->string('RemarksB_plus');
            $table->string('minB');
            $table->string('maxB');
            $table->string('pointB');
            $table->string('gradeB');
            $table->string('RemarksB');
            $table->string('minB_minus');
            $table->string('maxB_minus');
            $table->string('pointB_minus');
            $table->string('gradeB_minus');
            $table->string('RemarksB_minus');
            $table->string('minC_plus');
            $table->string('maxC_plus');
            $table->string('pointC_plus');
            $table->string('gradeC_plus');
            $table->string('RemarksC_plus');
            $table->string('minC');
            $table->string('maxC');
            $table->string('pointC');
            $table->string('gradeC');
            $table->string('RemarksC');
            $table->string('minC_minus');
            $table->string('maxC_minus');
            $table->string('pointC_minus');
            $table->string('gradeC_minus');
            $table->string('RemarksC_minus');
            $table->string('minD_plus');
            $table->string('maxD_plus');
            $table->string('pointD_plus');
            $table->string('gradeD_plus');
            $table->string('RemarksD_plus');
            $table->string('minD');
            $table->string('maxD');
            $table->string('pointD');
            $table->string('gradeD');
            $table->string('RemarksD');
            $table->string('minD_minus');
            $table->string('maxD_minus');
            $table->string('pointD_minus');
            $table->string('gradeD_minus');
            $table->string('RemarksD_minus');
            $table->string('minE');
            $table->string('maxE');
            $table->string('pointE');
            $table->string('gradeE');
            $table->string('RemarksE');
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
        Schema::dropIfExists('grades');
    }
}
