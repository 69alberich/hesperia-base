<?php namespace Hesperiaplugins\Empleos\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHesperiapluginsEmpleosPostulaciones2 extends Migration
{
    public function up()
    {
        Schema::table('hesperiaplugins_empleos_postulaciones', function($table)
        {
            $table->text('contactos');
            $table->dropColumn('red');
            $table->dropColumn('cuenta');
        });
    }
    
    public function down()
    {
        Schema::table('hesperiaplugins_empleos_postulaciones', function($table)
        {
            $table->dropColumn('contacto');
            $table->text('red');
            $table->text('cuenta');
        });
    }
}
