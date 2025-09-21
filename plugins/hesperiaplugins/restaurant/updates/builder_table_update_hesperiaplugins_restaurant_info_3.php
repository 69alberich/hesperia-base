<?php namespace HesperiaPlugins\Restaurant\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHesperiapluginsRestaurantInfo3 extends Migration
{
    public function up()
    {
        Schema::table('hesperiaplugins_restaurant_info', function($table)
        {
            $table->integer('hotel_id');
        });
    }
    
    public function down()
    {
        Schema::table('hesperiaplugins_restaurant_info', function($table)
        {
            $table->dropColumn('hotel_id');
        });
    }
}
