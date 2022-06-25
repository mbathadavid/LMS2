<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sid');
            $table->string('educationsystem');
            $table->string('class');
            $table->string('stream')->nullable();
            $table->string('snumber')->nullable();
            $table->string('classteacher')->nullable();
            $table->string('current_term')->default('Not Set');
            $table->string('fee_amount')->nullable();
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
        Schema::dropIfExists('classes');
    }
}
