<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('device_id')->unsigned();
            $table->integer('partner_id')->unsigned();

            $table->unique(['device_id', 'partner_id']);


            $table->foreign('device_id')->references('id')->on('devices')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('partner_id')->references('id')->on('devices')
                ->onDelete('cascade')->onUpdate('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partners');
    }
}
