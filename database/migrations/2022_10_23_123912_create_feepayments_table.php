<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeepaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feepayments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sid');
            $table->string('AdmorUPI');
            $table->integer('amountpayed');
            $table->string('academicyear');
            $table->string('term');
            $table->integer('amount');
            $table->string('paymentmethod');
            $table->string('paymentitem')->nullable();
            $table->string('Cheque_number')->nullable();
            $table->string('MPESA_Code')->nullable();
            $table->string('Collected_By');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feepayments');
    }
}
