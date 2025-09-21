<?php namespace Hesperiaplugins\Empleos\Models;

use Model;

/**
 * Model
 */
class Postulacion extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    /**
     * @var string The database table used by the model.
     */
    public $table = 'hesperiaplugins_empleos_postulaciones';
    protected $jsonable = ['contactos'];

    /*Relaciones*/

    public $belongsTo = [
      'oferta' => ['Hesperiaplugins\Empleos\Models\Oferta', 'key' => 'oferta_id'],
    ];

    public $attachOne = [
      'archivo' => 'System\Models\File'
    ];

    public function scopeCategorias($query, $filter){

      return $query->whereHas('oferta',function($oferta) use($filter){
        $oferta->whereHas('categorias',function($categoria) use($filter){
          return $categoria->whereIn('id', $filter);
        });
      });
  
    }
}
