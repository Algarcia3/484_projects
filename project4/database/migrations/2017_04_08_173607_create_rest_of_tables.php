<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestOfTables extends Migration
{
    /**
     * Run the migrations.
     * All of these have to be done in one file in order to link 
     * the foreign keys together, or else it throws errors.
     * @return void
     */
    public function up()
    {
        // reviews table. all this shit
        Schema::create('reviews', function(Blueprint $table) {
            // defining all of my columns for reviews
            $table->increments('review_id');
            $table->integer('restaurant_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->tinyInteger('rating');
            $table->string('review_tagline');
            $table->text('review');
            $table->timestamps();
        });

        // restaurants table
        Schema::create('restaurants', function(Blueprint $table) {
            $table->increments('restaurant_id');
            $table->integer('review_id')->unsigned();
            $table->integer('menu_id')->unsigned();
            $table->string('restaurant_name');
            $table->string('street_address');
            $table->string('city');
            $table->string('state');
            $table->string('website');
            $table->timestamps();
        });

        // menu table
        Schema::create('menus', function(Blueprint $table) {
            $table->increments('menu_id');
            $table->integer('restaurant_id')->unsigned();
            $table->string('item_name');
            $table->text('menu_description');
            $table->decimal('menu_price', 15, 2);
        });

        // finally, set all of the foreign key constraints between tables
        Schema::table('reviews', function($table) {
            // defining all of the FK constraints for reviews
            $table->foreign('restaurant_id')
                  ->references('restaurant_id')
                  ->on('restaurants');
            // FK constraints for users
            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('users');
        });

        // FK constraints on restaurants
        Schema::table('restaurants', function($table) {
            // defining all of the FK constraints for reviews
            $table->foreign('review_id')
                  ->references('review_id')
                  ->on('reviews');
            // FK constraints for users
            $table->foreign('menu_id')
                  ->references('menu_id')
                  ->on('menus');
        });

        // FK constraints on menus
        Schema::table('menus', function($table) {
            // defining all of the FK constraints for reviews
            $table->foreign('restaurant_id')
                  ->references('restaurant_id')
                  ->on('restaurants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //D-D-D-DROP THE TABLE
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('restaurants');
        Schema::dropIfExists('menus');
    }
}
