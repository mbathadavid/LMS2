<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOverallGradeSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overall_grade_systems', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sid');
            $table->string('class');
            $table->string('consideration');
            $table->string('minA');
            $table->string('maxA');
            $table->string('gradeA');
            $table->string('RemarksA');
            $table->string('minA_minus');
            $table->string('maxA_minus');
            $table->string('gradeA_minus');
            $table->string('RemarksA_minus');
            $table->string('minB_plus');
            $table->string('maxB_plus');
            $table->string('gradeB_plus');
            $table->string('RemarksB_plus');
            $table->string('minB');
            $table->string('maxB');
            $table->string('gradeB');
            $table->string('RemarksB');
            $table->string('minB_minus');
            $table->string('maxB_minus');
            $table->string('gradeB_minus');
            $table->string('RemarksB_minus');
            $table->string('minC_plus');
            $table->string('maxC_plus');
            $table->string('gradeC_plus');
            $table->string('RemarksC_plus');
            $table->string('minC');
            $table->string('maxC');
            $table->string('gradeC');
            $table->string('RemarksC');
            $table->string('minC_minus');
            $table->string('maxC_minus');
            $table->string('gradeC_minus');
            $table->string('RemarksC_minus');
            $table->string('minD_plus');
            $table->string('maxD_plus');
            $table->string('gradeD_plus');
            $table->string('RemarksD_plus');
            $table->string('minD');
            $table->string('maxD');
            $table->string('gradeD');
            $table->string('RemarksD');
            $table->string('minD_minus');
            $table->string('maxD_minus');
            $table->string('gradeD_minus');
            $table->string('RemarksD_minus');
            $table->string('minE');
            $table->string('maxE');
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
        Schema::dropIfExists('overall_grade_systems');
    }
}
