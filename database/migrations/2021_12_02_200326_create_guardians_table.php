<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuardiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guardians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sid');
            $table->string('Fname')->nullable();
            $table->string('Sname')->nullable();
            $table->string('Lname');
            $table->string('Active')->default('Yes');
            $table->string('Parent_Guardian')->nullable();
            $table->string('Students');
            $table->string('Phone');
            $table->string('AltPhone')->nullable();
            $table->string('Email')->nullable();
            $table->string('Gender')->nullable();
            $table->string('Password')->default('password123');
            $table->string('Profile')->default('avatar.png');
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
        Schema::dropIfExists('guardians');
    }
}
