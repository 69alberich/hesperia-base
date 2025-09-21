<?php namespace Hesperiaplugins\Empleos\Models;

use Model;

/**
 * Model
 */
class CategoriaOferta extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    public $timestamps = false;

    /**
     * @var array Validation rules
     */
    public $rules = [
        'nombre' => 'required',
        'slug' => 'required'
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'hesperiaplugins_empleos_tag_categorias';

    public $belongsToMany = [
        'ofertas' => ['Hesperiaplugins\Empleos\Models\Oferta',
            'table' => 'hesperiaplugins_empleos_oferta_categoria',
            'key' => 'oferta_id',
            'otherKey' => 'categoria_id'
        ]
    ];
}
