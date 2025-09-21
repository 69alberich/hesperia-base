<?php namespace HesperiaPlugins\Restaurant\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHesperiapluginsRestaurantInfo2 extends Migration
{
    public function up()
    {
        Schema::table('hesperiaplugins_restaurant_info', function($table)
        {
            $table->renameColumn('uri', 'slug');
        });
    }
    
    public function down()
    {
        Schema::table('hesperiaplugins_restaurant_info', function($table)
        {
            $table->renameColumn('slug', 'uri');
        });
    }
}
