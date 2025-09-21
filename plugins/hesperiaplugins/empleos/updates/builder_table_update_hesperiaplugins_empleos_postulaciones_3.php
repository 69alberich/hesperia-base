<?php namespace Hesperiaplugins\Empleos\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHesperiapluginsEmpleosPostulaciones3 extends Migration
{
    public function up()
    {
        Schema::table('hesperiaplugins_empleos_postulaciones', function($table)
        {
            $table->renameColumn('contacto', 'contactos');
        });
    }
    
    public function down()
    {
        Schema::table('hesperiaplugins_empleos_postulaciones', function($table)
        {
            $table->renameColumn('contactos', 'contacto');
        });
    }
}
