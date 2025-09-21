<?php namespace hesperiaplugins\Mediacenter\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHesperiapluginsMediacenterCategoria extends Migration
{
    public function up()
    {
        Schema::rename('hesperiaplugins_mediacenter_categorias', 'hesperiaplugins_mediacenter_categoria');
        Schema::table('hesperiaplugins_mediacenter_categoria', function($table)
        {
            $table->increments('id')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::rename('hesperiaplugins_mediacenter_categoria', 'hesperiaplugins_mediacenter_categorias');
        Schema::table('hesperiaplugins_mediacenter_categorias', function($table)
        {
            $table->increments('id')->unsigned()->change();
        });
    }
}
