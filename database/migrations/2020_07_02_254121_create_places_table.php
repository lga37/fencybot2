<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->increments('id');
            $table->string('place_key')->nullable();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            
            $table->integer('type_id')->unsigned();

            $table->decimal('lat',10,8);
            $table->decimal('lng',11,8);


            $table->timestamps();

            $table->foreign('type_id')->references('id')->on('types')
            ->onUpdate('cascade')->onDelete('cascade');




        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('places');
    }
}
