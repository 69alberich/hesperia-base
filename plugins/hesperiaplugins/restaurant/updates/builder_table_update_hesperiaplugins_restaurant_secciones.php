<?php namespace HesperiaPlugins\Restaurant\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHesperiapluginsRestaurantSecciones extends Migration
{
    public function up()
    {
        Schema::table('hesperiaplugins_restaurant_secciones', function($table)
        {
            $table->increments('id')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('hesperiaplugins_restaurant_secciones', function($table)
        {
            $table->increments('id')->unsigned()->change();
        });
    }
}
