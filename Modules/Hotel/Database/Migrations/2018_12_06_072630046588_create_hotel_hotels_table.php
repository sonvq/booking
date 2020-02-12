<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel__hotels', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            // Your fields
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('email');
            $table->string('telephone');

            $table->decimal('amount_buy', 14, 2)->nullable();
            $table->string('change_buy')->comment('increase/decrease')->nullable();
            $table->string('type_buy')->comment('number/percentage')->nullable();

            $table->decimal('amount_sell', 14, 2)->nullable();
            $table->string('change_sell')->comment('increase/decrease')->nullable();
            $table->string('type_sell')->comment('number/percentage')->nullable();

            $table->integer('region_id')->unsigned()->nullable();
            $table->foreign('region_id')->references('id')->on('region__regions')->onDelete('cascade');

            $table->integer('company_id')->unsigned()->nullable();
            $table->foreign('company_id')->references('id')->on('company__companies')->onDelete('cascade');

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
        Schema::dropIfExists('hotel__hotels');
    }
}
