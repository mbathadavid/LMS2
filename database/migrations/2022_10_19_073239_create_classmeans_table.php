<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassmeansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classmeans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sid');
            $table->integer('tid');
            $table->string('class');
            $table->string('classid')->nullable();
            $table->string('mean_score');
            $table->string('mean_grade')->nullable();
            $table->integer('student_count')->default('0');
            $table->integer('As')->nullable();
            $table->integer('A_minus')->nullable();
            $table->integer('B_plus')->nullable();
            $table->integer('Bs')->nullable();
            $table->integer('B_minus')->nullable();
            $table->integer('C_plus')->nullable();
            $table->integer('Cs')->nullable();
            $table->integer('C_minus')->nullable();
            $table->integer('D_plus')->nullable();
            $table->integer('Ds')->nullable();
            $table->integer('D_minus')->nullable();
            $table->integer('Es')->nullable();
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
        Schema::dropIfExists('classmeans');
    }
}
