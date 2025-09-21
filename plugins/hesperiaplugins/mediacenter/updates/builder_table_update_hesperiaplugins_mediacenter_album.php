<?php namespace hesperiaplugins\Mediacenter\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateHesperiapluginsMediacenterAlbum extends Migration
{
    public function up()
    {
        Schema::rename('hesperiaplugins_mediacenter_albumes', 'hesperiaplugins_mediacenter_album');
    }
    
    public function down()
    {
        Schema::rename('hesperiaplugins_mediacenter_album', 'hesperiaplugins_mediacenter_albumes');
    }
}
