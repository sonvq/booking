<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBookingBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking__bookings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            // Your fields
            $table->integer('hotel_id')->unsigned()->nullable();
            $table->foreign('hotel_id')->references('id')->on('hotel__hotels')->onDelete('cascade');

            $table->integer('agency_id')->unsigned()->nullable();
            $table->foreign('agency_id')->references('id')->on('agency__agencies')->onDelete('cascade');

            $table->integer('supplier_id')->unsigned()->nullable();
            $table->foreign('supplier_id')->references('id')->on('supplier__suppliers')->onDelete('cascade');

            // For Sale foreign key
            $table->integer('sale_id')->unsigned()->nullable()->comment('Sale user id');
            $table->foreign('sale_id')->references('id')->on('users')->onDelete('cascade');

            // For Customer foreign key
            $table->integer('customer_id')->unsigned()->nullable()->comment('Customer id');
            $table->foreign('customer_id')->references('id')->on('customer__customers')->onDelete('cascade');

            $table->date('checkin_date');
            $table->date('checkout_date');

            $table->string('hotel_confirm_code')->nullable();
            $table->string('flight_code')->nullable();

            $table->integer('campaign_id')->unsigned()->nullable();
            $table->foreign('campaign_id')->references('id')->on('campaign__campaigns')->onDelete('cascade');

            $table->boolean('is_adjust_surcharge')->default(false);
            $table->boolean('is_adjust_price')->default(false);

            $table->text('note')->nullable();

            $table->integer('total_price')->nullable();
            $table->integer('total_buy_price')->nullable();
            $table->integer('total_sell_price')->nullable();
            $table->integer('total_profit')->nullable();

            $table->string('booking_number')->nullable();

            $table->integer('author_id')->unsigned()->nullable()->comment('User who create this booking');
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');

            $table->date('cod')->comment('Booking cod');
            $table->enum('booking_status', [
                'created',
                'hotel_sent',
                'hotel_confirmed',
                'hotel_rejected',
                'customer_rejected',
                'penalty_for_cancellation',
            ]);

            $table->enum('payment_status', [
                'pending',
                'payment_confirmation',
                'partially_paid',
                'fully_paid',
            ]);

            $table->enum('vendor_purchase_status', [
                'pending',
                'completed',
                'partially_paid'
            ]);

            $table->timestamps();
        });

        Schema::create('room_bookings', function (Blueprint $table) {
            $table->integer('booking_id')->unsigned();
            $table->integer('room_id')->unsigned();
            $table->integer('quantity')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('buy_price')->nullable();
            $table->integer('sell_price')->nullable();

            $table->nullableTimestamps();

            $table->engine = 'InnoDB';

            $table->foreign('booking_id')->references('id')->on('booking__bookings')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('room__rooms')->onDelete('cascade');
        });

        Schema::create('service_bookings', function (Blueprint $table) {
            $table->integer('booking_id')->unsigned();
            $table->integer('service_id')->unsigned();
            $table->integer('quantity')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('buy_price')->nullable();
            $table->integer('sell_price')->nullable();

            $table->nullableTimestamps();

            $table->engine = 'InnoDB';

            $table->foreign('booking_id')->references('id')->on('booking__bookings')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('service__services')->onDelete('cascade');
        });

        Schema::create('surcharge_bookings', function (Blueprint $table) {
            $table->integer('booking_id')->unsigned();
            $table->integer('surcharge_id')->unsigned();
            $table->integer('quantity')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('buy_price')->nullable();
            $table->integer('sell_price')->nullable();

            $table->nullableTimestamps();

            $table->engine = 'InnoDB';

            $table->foreign('booking_id')->references('id')->on('booking__bookings')->onDelete('cascade');
            $table->foreign('surcharge_id')->references('id')->on('surcharge__surcharges')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('surcharge_bookings');
        Schema::dropIfExists('service_bookings');
        Schema::dropIfExists('room_bookings');
        Schema::dropIfExists('booking__bookings');
        Schema::enableForeignKeyConstraints();
    }
}
