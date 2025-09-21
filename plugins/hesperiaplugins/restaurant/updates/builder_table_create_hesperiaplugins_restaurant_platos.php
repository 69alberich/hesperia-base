<?php namespace HesperiaPlugins\Restaurant\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHesperiapluginsRestaurantPlatos extends Migration
{
    public function up()
    {
        Schema::create('hesperiaplugins_restaurant_platos', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nombre', 150);
            $table->text('descripcion');
            $table->integer('seccion_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('hesperiaplugins_restaurant_platos');
    }
}
