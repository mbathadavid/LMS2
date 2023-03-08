<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('communications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sid');
            $table->string('message');
            $table->string('number');
            $table->string('status_code')->nullable();
            $table->string('network_id')->nullable();
            $table->string('message_cost')->nullable();
            $table->string('credit_balance')->nullable();
            $table->string('API_used')->nullable();
            $table->string('Description')->nullable();
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
        Schema::dropIfExists('communications');
    }
}
