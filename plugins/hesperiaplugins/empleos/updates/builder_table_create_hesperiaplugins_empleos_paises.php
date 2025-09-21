<?php namespace hesperiaplugins\Empleos\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHesperiapluginsEmpleosPaises extends Migration
{
    public function up()
    {
        Schema::create('hesperiaplugins_empleos_paises', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('pais', 200);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('hesperiaplugins_empleos_paises');
    }
}
