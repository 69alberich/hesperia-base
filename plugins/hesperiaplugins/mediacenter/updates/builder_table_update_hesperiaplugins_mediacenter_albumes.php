<?php namespace hesperiaplugins\Mediacenter\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHesperiapluginsMediacenterAlbumes extends Migration
{
    public function up()
    {
        Schema::table('hesperiaplugins_mediacenter_albumes', function($table)
        {
            $table->increments('id')->unsigned(false)->change();
            $table->string('titulo', 150)->change();
            $table->string('descripcion', 300)->change();
        });
    }
    
    public function down()
    {
        Schema::table('hesperiaplugins_mediacenter_albumes', function($table)
        {
            $table->increments('id')->unsigned()->change();
            $table->string('titulo', 255)->change();
            $table->string('descripcion', 255)->change();
        });
    }
}
