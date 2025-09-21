<?php namespace HesperiaPlugins\Restaurant\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHesperiapluginsRestaurantInfo extends Migration
{
    public function up()
    {
        Schema::table('hesperiaplugins_restaurant_info', function($table)
        {
            $table->text('emails');
            $table->text('telefonos');
            $table->string('latitud', 50);
            $table->string('longitud', 50);
            $table->string('uri', 200);
            $table->dropColumn('email');
        });
    }
    
    public function down()
    {
        Schema::table('hesperiaplugins_restaurant_info', function($table)
        {
            $table->dropColumn('emails');
            $table->dropColumn('telefonos');
            $table->dropColumn('latitud');
            $table->dropColumn('longitud');
            $table->dropColumn('uri');
            $table->string('email', 100);
        });
    }
}
