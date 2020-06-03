<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('lat',10,8);
            $table->decimal('lng',11,8);
            #dist
            #dt
            #type 0,1,2

            #$table->integer('fence_id')->unsigned();
            #$table->integer('device_id')->unsigned();
            #'tem q ser pois se excluir os fencedevice deixa nulo aqui'
            $table->integer('fencedevice_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('fencedevice_id')->references('id')->on('fence_device')
                ->onDelete('set null')->onUpdate('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alerts');
    }
}
