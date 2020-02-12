<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRoomRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room__rooms', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            // Your fields
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 14, 2);

            $table->decimal('amount', 14, 2)->nullable();
            $table->string('change')->comment('increase/decrease')->nullable();
            $table->string('type')->comment('number/percentage')->nullable();

            $table->timestamps();
        });

        Schema::create('hotel_rooms', function (Blueprint $table) {
            $table->integer('hotel_id')->unsigned();
            $table->integer('room_id')->unsigned();
            $table->nullableTimestamps();

            $table->engine = 'InnoDB';
            $table->primary(['hotel_id', 'room_id']);
            $table->foreign('hotel_id')->references('id')->on('hotel__hotels')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('room__rooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotel_rooms');
        Schema::dropIfExists('room__rooms');
    }
}
