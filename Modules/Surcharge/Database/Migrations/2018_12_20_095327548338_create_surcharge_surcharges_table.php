<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurchargeSurchargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surcharge__surcharges', function (Blueprint $table) {
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

        Schema::create('hotel_surcharges', function (Blueprint $table) {
            $table->integer('hotel_id')->unsigned();
            $table->integer('surcharge_id')->unsigned();
            $table->nullableTimestamps();

            $table->engine = 'InnoDB';
            $table->primary(['hotel_id', 'surcharge_id']);
            $table->foreign('hotel_id')->references('id')->on('hotel__hotels')->onDelete('cascade');
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
        Schema::dropIfExists('hotel_surcharges');
        Schema::dropIfExists('surcharge__surcharges');
    }
}
