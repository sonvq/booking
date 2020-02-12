<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company__companies', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            // Your fields
            $table->string('name');
            $table->text('description')->nullable();

            $table->decimal('amount_buy', 14, 2)->nullable();
            $table->string('change_buy')->comment('increase/decrease')->nullable();
            $table->string('type_buy')->comment('number/percentage')->nullable();

            $table->decimal('amount_sell', 14, 2)->nullable();
            $table->string('change_sell')->comment('increase/decrease')->nullable();
            $table->string('type_sell')->comment('number/percentage')->nullable();

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
        Schema::dropIfExists('company__companies');
        Schema::enableForeignKeyConstraints();
    }
}
