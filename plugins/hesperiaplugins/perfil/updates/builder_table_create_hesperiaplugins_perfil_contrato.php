<?php namespace hesperiaplugins\Perfil\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHesperiapluginsPerfilContrato extends Migration
{
    public function up()
    {
        Schema::create('hesperiaplugins_perfil_contrato', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('hotel_id');
            $table->integer('usuario_id');
            $table->integer('descuento');
            $table->integer('over');
            $table->date('vence');
            $table->integer('cupomensual');
            $table->integer('cupoobjetivo');
            $table->string('emailcontacto', 100);
            $table->string('telefonocontacto', 50);
            $table->boolean('credito');
            $table->boolean('bolivares');
            $table->boolean('dolares');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('hesperiaplugins_perfil_contrato');
    }
}
