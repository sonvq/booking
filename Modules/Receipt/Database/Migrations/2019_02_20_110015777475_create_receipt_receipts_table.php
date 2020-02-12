<?php

use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateReceiptReceiptsTable
 */
class CreateReceiptReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt__receipts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('booking_id')->unsigned()->nullable();
            $table->integer('author_id')->unsigned()->nullable()->comment('User who create this receipt');

            $table->string('type');
            $table->integer('amount');
            $table->string('payment_type');
            $table->string('status');
            $table->text('note')->nullable();
            $table->string('unique_number');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->date('start_date')->default(Carbon::now());

            $table->timestamps();
            $table->engine = 'InnoDB';

            $table->foreign('booking_id')->references('id')->on('booking__bookings')->onDelete('cascade');
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receipt__receipts');
    }
}
