<?php namespace hesperiaplugins\Instapago\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHesperiapluginsInstapagoAfiliado extends Migration
{
    public function up()
    {
        Schema::table('hesperiaplugins_instapago_afiliado', function($table)
        {
            $table->string('nombre', 250)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('hesperiaplugins_instapago_afiliado', function($table)
        {
            $table->dropColumn('nombre');
        });
    }
}
