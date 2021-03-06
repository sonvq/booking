<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier__suppliers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            // Your fields
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->text('description')->nullable();

            $table->decimal('amount', 14, 2);
            $table->string('change')->comment('increase/decrease');
            $table->string('type')->comment('number/percentage');

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
        Schema::dropIfExists('supplier__suppliers');
    }
}
