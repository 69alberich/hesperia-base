<?php namespace Hesperiaplugins\Perfil\Models;

use Model;
use Db;

/**
 * Model
 */
class Contrato extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /*
     * Validation
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'hesperiaplugins_perfil_contrato';

    //VARIABLE - RUTA DEL MODELO - KEY--> CLAVE-FORANEA EN MI TABLA
    public $belongsTo = [
        'usuario' => ['RainLab\User\Models\User', 'key' => 'usuario_id' , 'conditions' => 'rol_id = 3' ],
        'hotel' => ['HesperiaPlugins\Hoteles\Models\Hotel', 'key' => 'hotel_id' ]
    ];

    public function getHotelOptions(){

      $usuario = $this->usuario["id"];
      //echo 'usuario: ' .$usuario;
      $contratos = Db::table('hesperiaplugins_perfil_contrato')
      ->where('usuario_id', '=', $usuario)
      ->lists('hotel_id');

      $hoteles = [];

      if(count($contratos) > 0){
        $hoteles = Db::table('hesperiaplugins_hoteles_hotel as a')
          ->select('a.nombre', 'a.id')
          ->whereNotIn('a.id', $contratos)
          ->lists('a.nombre', 'a.id');
      }

      return $hoteles;
      //return ['1' => 'Australia', '2' => 'Canada'];
    }
}
