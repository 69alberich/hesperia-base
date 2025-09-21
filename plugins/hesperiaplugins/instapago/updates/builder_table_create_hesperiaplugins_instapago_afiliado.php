<?php namespace hesperiaplugins\Instapago\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHesperiapluginsInstapagoAfiliado extends Migration
{
    public function up()
    {
        Schema::create('hesperiaplugins_instapago_afiliado', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('llave_privada', 250);
            $table->string('llave_publica', 250);
            $table->string('status', 1);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('hesperiaplugins_instapago_afiliado');
    }
}
