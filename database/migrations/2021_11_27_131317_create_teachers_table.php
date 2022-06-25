<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sid');
            $table->string('salutation')->nullable();
            $table->string('Fname')->nullable();
            $table->string('Sname')->nullable();
            $table->string('Lname')->nullable();
            $table->string('Gender')->nullable();
            $table->string('Position')->nullable();
            $table->string('Email')->nullable()->unique();
            $table->string('Phone')->nullable()->unique();
            $table->string('password')->default('password123');
            $table->string('Profile')->default('avatar.png');
            $table->string('Active')->default('Yes');
            $table->tinyInteger('deleted')->default('0');
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
        Schema::dropIfExists('teachers');
    }
}
