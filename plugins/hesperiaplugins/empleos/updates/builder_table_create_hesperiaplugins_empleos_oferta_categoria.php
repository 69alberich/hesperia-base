<?php namespace hesperiaplugins\Empleos\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHesperiapluginsEmpleosOfertaCategoria extends Migration
{
    public function up()
    {
        Schema::create('hesperiaplugins_empleos_oferta_categoria', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('oferta_id');
            $table->integer('categoria_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('hesperiaplugins_empleos_oferta_categoria');
    }
}
