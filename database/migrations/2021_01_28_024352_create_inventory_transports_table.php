<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryTransportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_transports', function (Blueprint $table) {
            $table->id();
            $table->integer('vehicle_id');
            $table->unsignedBigInteger('type_vehicle_id');
            $table->string('model');
            $table->integer('quantity')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('type_vehicle_id')->references('id')->on('types_vehicles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_transports');
    }
}
