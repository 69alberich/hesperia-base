<?php namespace hesperiaplugins\Mediacenter\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHesperiapluginsMediacenterAlbumCategoria extends Migration
{
    public function up()
    {
        Schema::create('hesperiaplugins_mediacenter_album_categoria', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('album_id');
            $table->integer('categoria_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('hesperiaplugins_mediacenter_album_categoria');
    }
}
