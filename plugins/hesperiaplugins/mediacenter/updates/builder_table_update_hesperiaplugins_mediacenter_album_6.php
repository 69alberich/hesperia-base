<?php namespace hesperiaplugins\Mediacenter\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHesperiapluginsMediacenterAlbum6 extends Migration
{
    public function up()
    {
        Schema::table('hesperiaplugins_mediacenter_album', function($table)
        {
            $table->integer('hotel_id');
        });
    }
    
    public function down()
    {
        Schema::table('hesperiaplugins_mediacenter_album', function($table)
        {
            $table->dropColumn('hotel_id');
        });
    }
}
