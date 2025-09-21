<?php namespace Hesperiaplugins\Empleos\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHesperiapluginsEmpleosOfertaEmpleo5 extends Migration
{
    public function up()
    {
        Schema::table('hesperiaplugins_empleos_oferta_empleo', function($table)
        {
            $table->integer('ofertable_id');
            $table->string('ofertable_type', 150);
        });
    }
    
    public function down()
    {
        Schema::table('hesperiaplugins_empleos_oferta_empleo', function($table)
        {
            $table->dropColumn('ofertable_id');
            $table->dropColumn('ofertable_type');
        });
    }
}
