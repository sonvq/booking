<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer__customers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            // Your fields
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('identity')->nullable();
            $table->date('birthday')->nullable();
            $table->tinyInteger('gender')->default(0)->comment('0: female, 1: male');
            $table->date('appointment')->nullable();
            $table->text('note')->nullable();
            $table->integer('author_id')->unsigned()->nullable()->comment('User who create this customer');
            $table->integer('country_id')->unsigned()->nullable();

            $table->foreign('country_id')->references('id')->on('country__countries')->onDelete('cascade');
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('customer__customers');
        Schema::enableForeignKeyConstraints();
    }
}
