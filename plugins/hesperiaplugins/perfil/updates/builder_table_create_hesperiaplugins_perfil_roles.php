<?php namespace hesperiaplugins\Perfil\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHesperiapluginsPerfilRoles extends Migration
{
    public function up()
    {
        Schema::create('hesperiaplugins_perfil_roles', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('descripcion', 200);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('hesperiaplugins_perfil_roles');
    }
}
