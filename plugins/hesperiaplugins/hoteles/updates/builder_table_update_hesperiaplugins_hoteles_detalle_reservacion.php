<?php namespace HesperiaPlugins\Hoteles\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHesperiapluginsHotelesDetalleReservacion extends Migration
{
    public function up()
    {
        if (!Schema::hasTable("hesperiaplugins_hoteles_detalle_reservacion") || !Schema::hasColumn("hesperiaplugins_hoteles_detalle_reservacion", 'postcode')) {
            return;
        }

        Schema::table('hesperiaplugins_hoteles_detalle_reservacion', function($table)
        {
            $table->text('info_adicional');
            
        });
    }
    
    public function down()
    {
        Schema::table('hesperiaplugins_hoteles_detalle_reservacion', function($table)
        {
            $table->dropColumn('info_adicional');
        
        });
    }
}
