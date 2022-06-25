<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('result_threads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sid');
            $table->string('name');
            $table->string('term');
            $table->string('year');
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
        Schema::dropIfExists('result_threads');
    }
}
