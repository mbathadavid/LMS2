<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sid');
            $table->string('Fname');
            $table->string('Sname')->nullable();
            $table->string('Lname')->nullable();
            $table->string('AdmissionNo');
            $table->string('schoolsystem');
            $table->string('current_class');
            $table->Integer('current_classid');
            $table->string('gender');
            $table->string('dob')->nullable();
            $table->string('Active')->default('Yes');
            $table->string('county')->nullable();
            $table->string('subcounty')->nullable();
            $table->string('disabled')->default('No');
            $table->string('disability')->nullable();
            $table->string('d_description')->nullable();
            $table->string('parentinfo')->nullable();
            $table->string('feebalance')->nullable();
            $table->string('password')->nullable();
            $table->string('profile')->default('avatar.png');
            $table->tinyInteger('deleted')->default('0');
            $table->tinyInteger('completed')->default('0');
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
        Schema::dropIfExists('students');
    }
}
