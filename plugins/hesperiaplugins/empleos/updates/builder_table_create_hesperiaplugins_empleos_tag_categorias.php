<?php namespace hesperiaplugins\Empleos\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHesperiapluginsEmpleosTagCategorias extends Migration
{
    public function up()
    {
        Schema::create('hesperiaplugins_empleos_tag_categorias', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('nombre', 200);
            $table->text('descripcion');
            $table->string('slug', 250);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('hesperiaplugins_empleos_tag_categorias');
    }
}
