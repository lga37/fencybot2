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
            $table->decimal('lat_fence',10,8)->nullable();
            $table->decimal('lng_fence',11,8)->nullable();

            $table->unsignedFloat('dist')->nullable();
            $table->timestamp('dt')->nullable();
            $table->char('type',1)->default(0);
            $table->integer('fence_id')->unsigned()->nullable();
            $table->integer('device_id')->unsigned()->nullable();

            $table->timestamps();
            $table->foreign('fence_id')->references('id')->on('fences')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('device_id')->references('id')->on('devices')
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
        Schema::dropIfExists('alerts');
    }
}
