<?php namespace hesperiaplugins\Empleos\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHesperiapluginsEmpleosOfertaEmpleo2 extends Migration
{
    public function up()
    {
        Schema::table('hesperiaplugins_empleos_oferta_empleo', function($table)
        {
            $table->integer('ind_activo');
        });
    }
    
    public function down()
    {
        Schema::table('hesperiaplugins_empleos_oferta_empleo', function($table)
        {
            $table->dropColumn('ind_activo');
        });
    }
}
