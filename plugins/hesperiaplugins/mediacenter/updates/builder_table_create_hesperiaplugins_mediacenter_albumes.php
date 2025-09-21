<?php namespace hesperiaplugins\Mediacenter\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHesperiapluginsMediacenterAlbumes extends Migration
{
    public function up()
    {
        Schema::create('hesperiaplugins_mediacenter_albumes', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('titulo');
            $table->string('descripcion')->nullable();
            $table->text('item');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('hesperiaplugins_mediacenter_albumes');
    }
}
