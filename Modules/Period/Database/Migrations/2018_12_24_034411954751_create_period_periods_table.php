<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriodPeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('period__periods', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            // Your fields
            $table->string('name');
            $table->integer('cod');

            $table->timestamps();

            $table->integer('campaign_id')->unsigned()->nullable();
            $table->foreign('campaign_id')->references('id')->on('campaign__campaigns')->onDelete('cascade');
        });

        Schema::create('hotel_periods', function (Blueprint $table) {
            $table->integer('hotel_id')->unsigned();
            $table->integer('period_id')->unsigned();
            $table->nullableTimestamps();

            $table->engine = 'InnoDB';
            $table->primary(['hotel_id', 'period_id']);
            $table->foreign('hotel_id')->references('id')->on('hotel__hotels')->onDelete('cascade');
            $table->foreign('period_id')->references('id')->on('period__periods')->onDelete('cascade');
        });

        Schema::create('country_periods', function (Blueprint $table) {
            $table->integer('country_id')->unsigned();
            $table->integer('period_id')->unsigned();
            $table->nullableTimestamps();

            $table->engine = 'InnoDB';
            $table->primary(['country_id', 'period_id']);
            $table->foreign('country_id')->references('id')->on('country__countries')->onDelete('cascade');
            $table->foreign('period_id')->references('id')->on('period__periods')->onDelete('cascade');
        });

        Schema::create('period_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('period_id')->unsigned();
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();

            $table->foreign('period_id')->references('id')->on('period__periods')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('period_dates');
        Schema::dropIfExists('country_periods');
        Schema::dropIfExists('hotel_periods');
        Schema::dropIfExists('period__periods');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
