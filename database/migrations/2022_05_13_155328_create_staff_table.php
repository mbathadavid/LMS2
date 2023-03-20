<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sid');
            $table->string('Salutation')->nullable();
            $table->string('Fname')->nullable();
            $table->string('Lname')->nullable();
            $table->string('Gender')->nullable();
            $table->string('Position')->nullable();
            $table->string('Role')->nullable();
            $table->string('Email')->nullable();
            $table->string('Phone')->nullable();
            $table->string('username')->nullable()->unique();
            $table->longtext('priviledges')->default('Not Yet Assigned');
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
        Schema::dropIfExists('staff');
    }
}
