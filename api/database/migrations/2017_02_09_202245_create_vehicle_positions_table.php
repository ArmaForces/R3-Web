<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclePositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_positions', function (Blueprint $table) {

            $table->integer('mission');
            $table->smallInteger('entity_id');
            $table->float('x', 6, 1);
            $table->float('y', 6, 1);
            $table->float('z', 6, 1);
            $table->smallInteger('direction');
            $table->tinyInteger('key_frame')->default(0);
            $table->string('driver', 60);
            $table->string('crew', 500);
            $table->string('cargo', 2000);
            $table->integer('mission_time');

            $table->index('mission');
            $table->index('entity_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_positions');
    }
}