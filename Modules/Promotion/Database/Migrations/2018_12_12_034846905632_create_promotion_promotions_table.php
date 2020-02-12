<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionPromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion__promotions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            // Your fields
            $table->string('name');
            $table->text('description')->nullable();

            $table->decimal('amount', 14, 2);
            $table->string('change')->comment('increase/decrease');
            $table->string('type')->comment('number/percentage');

            $table->integer('campaign_id')->unsigned()->nullable();
            $table->foreign('campaign_id')->references('id')->on('campaign__campaigns')->onDelete('cascade');

            $table->timestamps();
        });


        Schema::create('agency_promotions', function (Blueprint $table) {
            $table->integer('agency_id')->unsigned();
            $table->integer('promotion_id')->unsigned();
            $table->nullableTimestamps();

            $table->engine = 'InnoDB';
            $table->primary(['agency_id', 'promotion_id']);
            $table->foreign('agency_id')->references('id')->on('agency__agencies')->onDelete('cascade');
            $table->foreign('promotion_id')->references('id')->on('promotion__promotions')->onDelete('cascade');
        });

        Schema::create('hotel_promotions', function (Blueprint $table) {
            $table->integer('hotel_id')->unsigned();
            $table->integer('promotion_id')->unsigned();
            $table->nullableTimestamps();

            $table->engine = 'InnoDB';
            $table->primary(['hotel_id', 'promotion_id']);
            $table->foreign('hotel_id')->references('id')->on('hotel__hotels')->onDelete('cascade');
            $table->foreign('promotion_id')->references('id')->on('promotion__promotions')->onDelete('cascade');
        });

        Schema::create('room_promotions', function (Blueprint $table) {
            $table->integer('room_id')->unsigned();
            $table->integer('promotion_id')->unsigned();
            $table->nullableTimestamps();

            $table->engine = 'InnoDB';
            $table->primary(['room_id', 'promotion_id']);
            $table->foreign('room_id')->references('id')->on('room__rooms')->onDelete('cascade');
            $table->foreign('promotion_id')->references('id')->on('promotion__promotions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_promotions');
        Schema::dropIfExists('hotel_promotions');
        Schema::dropIfExists('agency_promotions');
        Schema::dropIfExists('promotion__promotions');
    }
}
