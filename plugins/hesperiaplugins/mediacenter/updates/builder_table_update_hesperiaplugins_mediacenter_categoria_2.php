<?php namespace hesperiaplugins\Mediacenter\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHesperiapluginsMediacenterCategoria2 extends Migration
{
    public function up()
    {
        Schema::table('hesperiaplugins_mediacenter_categoria', function($table)
        {
            $table->string('slug', 150);
            $table->renameColumn('titulo', 'nombre');
        });
    }
    
    public function down()
    {
        Schema::table('hesperiaplugins_mediacenter_categoria', function($table)
        {
            $table->dropColumn('slug');
            $table->renameColumn('nombre', 'titulo');
        });
    }
}
