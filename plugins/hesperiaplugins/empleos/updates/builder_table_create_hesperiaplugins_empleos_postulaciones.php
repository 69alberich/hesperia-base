<?php namespace hesperiaplugins\Empleos\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateHesperiapluginsEmpleosPostulaciones extends Migration
{
    public function up()
    {
        Schema::create('hesperiaplugins_empleos_postulaciones', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nombre', 200);
            $table->text('mensaje');
            $table->string('email', 200);
            $table->integer('oferta_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('hesperiaplugins_empleos_postulaciones');
    }
}
