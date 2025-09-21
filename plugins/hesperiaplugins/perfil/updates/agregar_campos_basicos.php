<?php namespace HesperiaPlugins\Perfil\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AgregarDatosBasicos extends Migration
{

    public function up()
    {
        Schema::table('users', function($table)
        {
            
            $table->string('identificacion');
            $table->text('direccion')->nullable();
            $table->text('telefonos')->nullable();
            $table->integer('rol_id')->nullable();
            $table->integer('padre_id')->nullable();
        });
    }

    public function down()
    {
        $table->dropDown([
            'identificacion',
            'direccion',
            'telefonos',
            'rol_id',
            'padre_id'
        ]);
    }

}
