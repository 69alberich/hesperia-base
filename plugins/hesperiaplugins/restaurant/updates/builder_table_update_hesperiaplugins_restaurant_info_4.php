<?php namespace HesperiaPlugins\Restaurant\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHesperiapluginsRestaurantInfo4 extends Migration
{
    public function up()
    {
        Schema::table('hesperiaplugins_restaurant_info', function($table)
        {
            $table->text('direccion');
        });
    }
    
    public function down()
    {
        Schema::table('hesperiaplugins_restaurant_info', function($table)
        {
            $table->dropColumn('direccion');
        });
    }
}
