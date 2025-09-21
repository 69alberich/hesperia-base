<?php namespace HesperiaPlugins\Restaurant\Models;

use Model;

/**
 * Model
 */
class Plato extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /*
     * Validation
     */
    public $rules = [
        'nombre' => 'required',
        'descripcion' => 'required',
        'foto' => 'required|mimes:jpeg'
    ];

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'hesperiaplugins_restaurant_platos';

    /* relaciones */

    public $attachOne = [
      'foto'=> 'System\Models\File'
    ];

    public $belongsTo = [
     'seccion' => ['HesperiaPlugins\Restaurant\Models\Seccion', 'key' => 'seccion_id']
    ];
}
