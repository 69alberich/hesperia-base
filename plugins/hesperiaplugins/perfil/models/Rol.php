<?php namespace Hesperiaplugins\Perfil\Models;

use Model;

/**
 * Model
 */
class Rol extends Model
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
    public $table = 'hesperiaplugins_perfil_roles';

    public $hasMany = [
        'user' => ['RainLab\User\Models\User']
    ];
}
