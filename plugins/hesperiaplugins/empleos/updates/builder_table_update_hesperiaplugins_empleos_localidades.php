<?php namespace Hesperiaplugins\Empleos\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHesperiapluginsEmpleosLocalidades extends Migration
{
    public function up()
    {
        Schema::table('hesperiaplugins_empleos_localidades', function($table)
        {
            $table->string('slug', 250);
        });
    }
    
    public function down()
    {
        Schema::table('hesperiaplugins_empleos_localidades', function($table)
        {
            $table->dropColumn('slug');
        });
    }
}
