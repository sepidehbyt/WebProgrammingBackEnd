<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('logo');
            $table->unsignedInteger('opening_time');
            $table->unsignedInteger('closing_time');
            $table->unsignedInteger('average_rate');
            $table->unsignedInteger('address_id');
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
        Schema::dropIfExists('restaurant');
    }
}
