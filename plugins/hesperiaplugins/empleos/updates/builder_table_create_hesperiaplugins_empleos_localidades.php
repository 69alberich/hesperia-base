<?php namespace hesperiaplugins\Empleos\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHesperiapluginsEmpleosLocalidades extends Migration
{
    public function up()
    {
        Schema::create('hesperiaplugins_empleos_localidades', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('localidad', 200);
            $table->integer('pais_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('hesperiaplugins_empleos_localidades');
    }
}
