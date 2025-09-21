<?php namespace Hesperiaplugins\Empleos\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHesperiapluginsEmpleosPostulaciones extends Migration
{
    public function up()
    {
        Schema::table('hesperiaplugins_empleos_postulaciones', function($table)
        {
            $table->text('red');
            $table->text('cuenta');
        });
    }
    
    public function down()
    {
        Schema::table('hesperiaplugins_empleos_postulaciones', function($table)
        {
            $table->dropColumn('red');
            $table->dropColumn('cuenta');
        });
    }
}
