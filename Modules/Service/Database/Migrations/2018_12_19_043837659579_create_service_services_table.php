<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServiceServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service__services', function (Blueprint $table) {
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

        Schema::create('hotel_services', function (Blueprint $table) {
            $table->integer('hotel_id')->unsigned();
            $table->integer('service_id')->unsigned();
            $table->nullableTimestamps();

            $table->engine = 'InnoDB';
            $table->primary(['hotel_id', 'service_id']);
            $table->foreign('hotel_id')->references('id')->on('hotel__hotels')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('service__services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotel_services');
        Schema::dropIfExists('service__services');
    }
}
