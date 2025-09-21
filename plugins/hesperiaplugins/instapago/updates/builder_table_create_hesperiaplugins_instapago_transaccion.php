<?php namespace hesperiaplugins\Instapago\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHesperiapluginsInstapagoTransaccion extends Migration
{
    public function up()
    {
        Schema::create('hesperiaplugins_instapago_transaccion', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('afiliado_id');
            $table->string('tarjetahabiente', 255);
            $table->integer('identificacion');
            $table->double('monto', 10, 0);
            $table->integer('status');
            $table->text('voucher')->nullable();
            $table->string('mensaje');
            $table->string('referencia');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('hesperiaplugins_instapago_transaccion');
    }
}
