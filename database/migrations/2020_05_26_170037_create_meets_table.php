<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meets', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('lat',10,8)->nullable();
            $table->decimal('lng',11,8)->nullable();
            $table->json('coords')->nullable();
            $table->integer('device_id')->unsigned()->nullable();
            #$table->timestamps();
            $table->timestamp('dt');


            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));


            #$table->integer('alert_id_1')->unsigned()->nullable();
            #$table->integer('alert_id_2')->unsigned()->nullable();
            #$table->integer('dist')->unsigned()->nullable();
            #$table->integer('time')->unsigned()->nullable();
            #$table->foreign('device_id')->references('id')->on('devices')
            #->onDelete('cascade')->onUpdate('cascade');

            #$table->foreign('alert_id_1')->references('id')->on('alertas')->onDelete('cascade')->onUpdate('cascade');
            #$table->foreign('alert_id_2')->references('id')->on('alertas')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meets');
    }
}
