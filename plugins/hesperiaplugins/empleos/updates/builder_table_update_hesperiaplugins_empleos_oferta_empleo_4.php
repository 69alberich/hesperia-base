<?php namespace hesperiaplugins\Empleos\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHesperiapluginsEmpleosOfertaEmpleo4 extends Migration
{
    public function up()
    {
        Schema::table('hesperiaplugins_empleos_oferta_empleo', function($table)
        {
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('ind_activo');
            $table->text('requisitos')->nullable();
            $table->string('slug', 250);
            $table->integer('localidad_id');
        });
    }
    
    public function down()
    {
        Schema::table('hesperiaplugins_empleos_oferta_empleo', function($table)
        {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('ind_activo');
            $table->dropColumn('requisitos');
            $table->dropColumn('slug');
            $table->dropColumn('localidad_id');
        });
    }
}
