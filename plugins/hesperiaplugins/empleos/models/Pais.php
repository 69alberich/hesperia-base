<?php namespace Hesperiaplugins\Empleos\Models;

use Model;

/**
 * Model
 */
class Pais extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    public $timestamps = false;

    /**
     * @var array Validation rules
     */
    public $rules = ['pais' => 'required'
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'hesperiaplugins_empleos_paises';
}
