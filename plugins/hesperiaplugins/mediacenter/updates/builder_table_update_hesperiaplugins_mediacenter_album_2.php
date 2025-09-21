<?php namespace hesperiaplugins\Mediacenter\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHesperiapluginsMediacenterAlbum2 extends Migration
{
    public function up()
    {
        Schema::table('hesperiaplugins_mediacenter_album', function($table)
        {
            $table->dropColumn('item');
        });
    }
    
    public function down()
    {
        Schema::table('hesperiaplugins_mediacenter_album', function($table)
        {
            $table->text('item');
        });
    }
}
