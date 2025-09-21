<?php namespace HesperiaPlugins\Restaurant\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHesperiapluginsRestaurantInfo extends Migration
{
    public function up()
    {
        Schema::create('hesperiaplugins_restaurant_info', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nombre', 150);
            $table->text('descripcion');
            $table->string('email', 100);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('hesperiaplugins_restaurant_info');
    }
}
