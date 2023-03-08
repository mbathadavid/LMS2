<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralreportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generalreports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sid');
            $table->Integer('studentid');
            $table->string('AdmUPI');
            $table->string('Name');
            $table->longText('report');
            $table->string('date');
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
        Schema::dropIfExists('generalreports');
    }
}
