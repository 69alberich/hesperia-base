<?php namespace HesperiaPlugins\Restaurant\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHesperiapluginsRestaurantSecciones2 extends Migration
{
    public function up()
    {
        Schema::table('hesperiaplugins_restaurant_secciones', function($table)
        {
            $table->integer('restaurant_id');
            $table->renameColumn('titulo', 'nombre');
        });
    }
    
    public function down()
    {
        Schema::table('hesperiaplugins_restaurant_secciones', function($table)
        {
            $table->dropColumn('restaurant_id');
            $table->renameColumn('nombre', 'titulo');
        });
    }
}
