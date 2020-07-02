<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        $inserts = [
            ['name'=>'accounting'],['name'=>'airport'],['name'=>'amusement_park'],
            ['name'=>'aquarium'],['name'=>'art_gallery'],['name'=>'atm'],['name'=>'bakery'],['name'=>'bank'],['name'=>'bar'],['name'=>'beauty_salon'],['name'=>'bicycle_store'],['name'=>'book_store'],['name'=>'bowling_alley'],['name'=>'bus_station'],['name'=>'cafe'],['name'=>'campground'],['name'=>'car_dealer'],['name'=>'car_rental'],['name'=>'car_repair'],['name'=>'car_wash'],['name'=>'casino'],['name'=>'cemetery'],['name'=>'church'],['name'=>'city_hall'],['name'=>'clothing_store'],['name'=>'convenience_store'],['name'=>'courthouse'],['name'=>'dentist'],['name'=>'department_store'],['name'=>'doctor'],['name'=>'drugstore'],['name'=>'electrician'],['name'=>'electronics_store'],['name'=>'embassy'],['name'=>'fire_station'],['name'=>'florist'],['name'=>'funeral_home'],['name'=>'furniture_store'],['name'=>'gas_station'],['name'=>'gym'],['name'=>'hair_care'],['name'=>'hardware_store'],['name'=>'hindu_temple'],['name'=>'home_goods_store'],['name'=>'hospital'],['name'=>'insurance_agency'],['name'=>'jewelry_store'],['name'=>'laundry'],['name'=>'lawyer'],['name'=>'library'],['name'=>'light_rail_station'],['name'=>'liquor_store'],['name'=>'local_government_office'],['name'=>'locksmith'],['name'=>'lodging'],['name'=>'meal_delivery'],['name'=>'meal_takeaway'],['name'=>'mosque'],['name'=>'movie_rental'],['name'=>'movie_theater'],['name'=>'moving_company'],['name'=>'museum'],['name'=>'night_club'],['name'=>'painter'],['name'=>'park'],['name'=>'parking'],['name'=>'pet_store'],['name'=>'pharmacy'],['name'=>'physiotherapist'],['name'=>'plumber'],['name'=>'police'],['name'=>'post_office'],['name'=>'primary_school'],['name'=>'real_estate_agency'],['name'=>'restaurant'],['name'=>'roofing_contractor'],['name'=>'rv_park'],['name'=>'school'],['name'=>'secondary_school'],['name'=>'shoe_store'],['name'=>'shopping_mall'],['name'=>'spa'],['name'=>'stadium'],['name'=>'storage'],['name'=>'store'],['name'=>'subway_station'],['name'=>'supermarket'],['name'=>'synagogue'],['name'=>'taxi_stand'],['name'=>'tourist_attraction'],['name'=>'train_station'],['name'=>'transit_station'],['name'=>'travel_agency'],['name'=>'university'],
            ['name'=>'veterinary_care'],['name'=>'zoo']

        ];

        foreach($inserts as $ins){

            DB::table('types')->insert( $ins );

        }




    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('types');
    }
}
