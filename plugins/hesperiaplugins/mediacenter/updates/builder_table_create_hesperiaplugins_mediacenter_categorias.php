<?php namespace hesperiaplugins\Mediacenter\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHesperiapluginsMediacenterCategorias extends Migration
{
    public function up()
    {
        Schema::create('hesperiaplugins_mediacenter_categorias', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('titulo', 150);
            $table->string('descripcion', 300)->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('hesperiaplugins_mediacenter_categorias');
    }
}
