<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sid');
            $table->string('BookNumber');
            $table->string('Category')->nullable();
            $table->string('Class');
            $table->string('Subject')->nullable();
            $table->string('Publisher')->nullable();
            $table->string('Status')->default('In Store');
            $table->timestamp('date_borrowed')->nullable();
            $table->timestamp('return_date')->nullable();
            $table->string('borrowed_by')->nullable();
            $table->string('fine')->nullable();
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
        Schema::dropIfExists('books');
    }
}
