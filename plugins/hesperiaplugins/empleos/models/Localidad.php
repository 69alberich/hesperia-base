<?php namespace Hesperiaplugins\Empleos\Models;

use Model;

/**
 * Model
 */
class Localidad extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    public $timestamps = false;

    /**
     * @var array Validation rules
     */
    public $rules = [
        'localidad' => 'required',
        'slug' => 'required',
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'hesperiaplugins_empleos_localidades';

    public $belongsTo = [
      'pais' => ['Hesperiaplugins\Empleos\Models\Pais', 'key' => 'pais_id'],
    ];
}
