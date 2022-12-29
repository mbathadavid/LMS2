<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sid');
            $table->string('type')->default('message');
            $table->integer('replyfor')->default('0');
            $table->string('toberecievedby')->default('0');
            $table->string('noficationtxt');
            $table->string('group')->nullable();
            $table->string('topic')->nullable();
            $table->string('message');
            $table->string('filetype')->nullable();
            $table->string('filename')->nullable();
            $table->string('ucategory');
            $table->integer('uid')->default('0');
            $table->string('sendername');
            $table->integer('seen')->nullable();
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
        Schema::dropIfExists('notifications');
    }
}
