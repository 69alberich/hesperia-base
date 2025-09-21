<?php namespace hesperiaplugins\Empleos\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHesperiapluginsEmpleosOfertaEmpleo extends Migration
{
    public function up()
    {
        Schema::create('hesperiaplugins_empleos_oferta_empleo', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('titulo', 250);
            $table->text('descripcion');
            $table->text('resquisitos')->nullable();
            $table->string('slug', 250);
            $table->integer('localidad_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('hesperiaplugins_empleos_oferta_empleo');
    }
}
