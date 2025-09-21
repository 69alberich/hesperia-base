<?php namespace hesperiaplugins\Mediacenter\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHesperiapluginsMediacenterAlbum4 extends Migration
{
    public function up()
    {
        Schema::table('hesperiaplugins_mediacenter_album', function($table)
        {
            $table->string('item', 350)->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('hesperiaplugins_mediacenter_album', function($table)
        {
            $table->text('item')->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
}
