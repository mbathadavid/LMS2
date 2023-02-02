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
            $table->integer('AdmissionNo')->nullable();
            $table->string('EduSystem');
            $table->string('UPI')->nullable();
            $table->string('StudentId')->nullable();
            $table->string('schoolsystem');
            $table->integer('KCPE_marks')->nullable();
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
            $table->integer('pendingbalances')->default('0');
            $table->integer('feebalance')->default('0');
            $table->integer('ovbalance')->default('0');
            $table->string('password')->nullable();
            $table->string('profile')->default('avatar.png');
            $table->string('pathway')->nullable();
            $table->string('suborlearningpaths')->nullable();
            $table->longText('books')->nullable();
            $table->string('subids')->nullable();
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
