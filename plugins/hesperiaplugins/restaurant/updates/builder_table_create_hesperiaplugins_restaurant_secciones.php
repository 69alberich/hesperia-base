<?php namespace HesperiaPlugins\Restaurant\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHesperiapluginsRestaurantSecciones extends Migration
{
    public function up()
    {
        Schema::create('hesperiaplugins_restaurant_secciones', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('titulo', 120);
            $table->text('descripcion');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('hesperiaplugins_restaurant_secciones');
    }
}
