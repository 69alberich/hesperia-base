<?php namespace HesperiaPlugins\Restaurant\Models;

use Model;

/**
 * Model
 */
class Seccion extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /*
     * Validation
     */
    public $rules = [
        'nombre' => 'required',
        'descripcion' => 'required',
        'banner' => 'required|mimes:jpeg'
    ];

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'hesperiaplugins_restaurant_secciones';

    /*relaciones*/

    public $attachOne = [
      'banner'=> 'System\Models\File'
    ];

    public $belongsTo = [
     'restaurant' => ['HesperiaPlugins\Restaurant\Models\Restaurant', 'key' => 'restaurant_id']
    ];

    public $hasMany = [
       'platos' => ['HesperiaPlugins\Restaurant\Models\Plato', 'key' => 'seccion_id']
     ];
}
