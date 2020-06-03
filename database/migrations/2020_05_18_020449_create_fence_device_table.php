<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFenceDeviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fence_device', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('device_id')->unsigned()->nullable();
            $table->integer('fence_id')->unsigned()->nullable();

            $table->unique(['device_id', 'fence_id' ]);

            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('fence_id')->references('id')->on('fences')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('fence_device');
    }
}
