<?php namespace hesperiaplugins\Empleos\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHesperiapluginsEmpleosOfertaEmpleo extends Migration
{
    public function up()
    {
        Schema::table('hesperiaplugins_empleos_oferta_empleo', function($table)
        {
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->renameColumn('resquisitos', 'requisitos');
        });
    }
    
    public function down()
    {
        Schema::table('hesperiaplugins_empleos_oferta_empleo', function($table)
        {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->renameColumn('requisitos', 'resquisitos');
        });
    }
}
