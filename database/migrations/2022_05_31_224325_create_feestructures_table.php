<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeestructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feestructures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sid');
            $table->string('Term');
            $table->string('classes');
            $table->string('classnames');
            $table->string('modules');
            $table->string('amounts');
            $table->string('totalamount');
            $table->string('cid');
            $table->string('crole');
            $table->string('createdby');
            $table->string('deleted')->default('0');
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
        Schema::dropIfExists('feestructures');
    }
}
