<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaignCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign__campaigns', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            // Your fields
            $table->string('name');
            $table->text('description')->nullable();

            $table->decimal('amount', 14, 2);
            $table->string('change')->comment('increase/decrease');
            $table->string('type')->comment('number/percentage');

            $table->timestamps();
        });

        Schema::create('hotel_campaigns', function (Blueprint $table) {
            $table->integer('hotel_id')->unsigned();
            $table->integer('campaign_id')->unsigned();
            $table->nullableTimestamps();

            $table->engine = 'InnoDB';
            $table->primary(['hotel_id', 'campaign_id']);
            $table->foreign('hotel_id')->references('id')->on('hotel__hotels')->onDelete('cascade');
            $table->foreign('campaign_id')->references('id')->on('campaign__campaigns')->onDelete('cascade');
        });

        Schema::create('room_campaigns', function (Blueprint $table) {
            $table->integer('room_id')->unsigned();
            $table->integer('campaign_id')->unsigned();
            $table->nullableTimestamps();

            $table->engine = 'InnoDB';
            $table->primary(['room_id', 'campaign_id']);
            $table->foreign('room_id')->references('id')->on('room__rooms')->onDelete('cascade');
            $table->foreign('campaign_id')->references('id')->on('campaign__campaigns')->onDelete('cascade');
        });

        Schema::create('service_campaigns', function (Blueprint $table) {
            $table->integer('service_id')->unsigned();
            $table->integer('campaign_id')->unsigned();
            $table->nullableTimestamps();

            $table->engine = 'InnoDB';
            $table->primary(['service_id', 'campaign_id']);
            $table->foreign('service_id')->references('id')->on('service__services')->onDelete('cascade');
            $table->foreign('campaign_id')->references('id')->on('campaign__campaigns')->onDelete('cascade');
        });

        Schema::create('surcharge_campaigns', function (Blueprint $table) {
            $table->integer('surcharge_id')->unsigned();
            $table->integer('campaign_id')->unsigned();
            $table->nullableTimestamps();

            $table->engine = 'InnoDB';
            $table->primary(['surcharge_id', 'campaign_id']);
            $table->foreign('surcharge_id')->references('id')->on('surcharge__surcharges')->onDelete('cascade');
            $table->foreign('campaign_id')->references('id')->on('campaign__campaigns')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surcharge_campaigns');
        Schema::dropIfExists('service_campaigns');
        Schema::dropIfExists('room_campaigns');
        Schema::dropIfExists('hotel_campaigns');
        Schema::dropIfExists('campaign__campaigns');
    }
}
