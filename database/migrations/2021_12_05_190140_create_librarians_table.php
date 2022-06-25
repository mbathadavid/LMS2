<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLibrariansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('librarians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sid');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('Email')->nullable();
            $table->string('Phone');
            $table->string('Active')->default('Yes');
            $table->string('password')->default('password123');
            $table->string('profile')->default('avatar.png');
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
        Schema::dropIfExists('librarians');
    }
}
