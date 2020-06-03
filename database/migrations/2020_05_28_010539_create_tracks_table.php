<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('lat',10,8);
            $table->decimal('lng',11,8);

            $table->tinyInteger('type')->unsigned()->nullable();
            $table->float('dist')->unsigned()->nullable();

            $table->integer('device_id')->unsigned()->nullable();
            $table->integer('fence_id')->unsigned()->nullable();
            $table->integer('meet_id')->unsigned();

            #$table->timestamp('dt',6);
            #$table->timestamps();

            $table->timestamp('dt');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));


            $table->foreign('meet_id')->references('id')->on('meets')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('device_id')->references('id')->on('devices')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('fence_id')->references('id')->on('fences')
                ->onDelete('set null')->onUpdate('cascade');



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracks');
    }
}
