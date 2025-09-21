<?php namespace HesperiaPlugins\Hoteles\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHesperiapluginsHotelesReservacion4 extends Migration
{
    public function up()
    {
        Schema::table('hesperiaplugins_hoteles_reservacion', function($table)
        {
            $table->integer('pago_insite')->default(0);
            //$table->integer('compra_id')->nullable(false)->default(null)->change();
            //$table->integer('paquete_id')->nullable(false)->default(null)->change();
            //$table->dropColumn('paquete_id');
        });
    }
    
    public function down()
    {
        Schema::table('hesperiaplugins_hoteles_reservacion', function($table)
        {
            $table->dropColumn('pago_insite');
            //$table->integer('compra_id')->nullable()->default(NULL)->change();
            //$table->integer('paquete_id')->nullable()->default(NULL)->change();
            //$table->integer('paquete_id')->nullable()->default(NULL);
        });
    }
}