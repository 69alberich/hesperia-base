<?php namespace Hesperiaplugins\Empleos\Models;

use Model;
use DB;

/**
 * Model
 */
class Oferta extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /**
     * @var array Validation rules
     */
    public $rules = [
        'titulo' => 'required',
        'slug' => 'required',
        'descripcion' => 'required'
    ];

    protected $jsonable = ["requisitos"];
    protected $fillable = [
        'ofertable_type',
        'ofertable_id',
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'hesperiaplugins_empleos_oferta_empleo';

    /*relaciones*/
    public $hasMany = [
    'postulaciones' => ['Hesperiaplugins\Empleos\Models\Postulacion', 'key' => 'oferta_id']
    ];

    public $belongsToMany = [
        'categorias' => [
            'Hesperiaplugins\Empleos\Models\CategoriaOferta',
            'table' => 'hesperiaplugins_empleos_oferta_categoria',
            'key' => 'oferta_id',
            'otherKey' => 'categoria_id'
        ]
    ];

    public $belongsTo = [
      'localidad' => ['Hesperiaplugins\Empleos\Models\Localidad', 'key' => 'localidad_id'],
    ];

    public $morphTo = [
        'ofertable' => []
    ];

    public function getOfertableTypeOptions($value, $formData){
        return ['HesperiaPlugins\Hoteles\Models\Hotel' => 'Hoteles',
                'HesperiaPlugins\Restaurant\Models\Restaurant' => 'Restaurantes'];
    }

    public function getOfertableIdOptions($value, $formData){

        if ($this->ofertable_type == 'HesperiaPlugins\Hoteles\Models\Hotel') {

           return $hotel = Db::table('hesperiaplugins_hoteles_hotel as a')->lists('a.nombre', 'a.id');
        }
        elseif ($this->ofertable_type == 'HesperiaPlugins\Restaurant\Models\Restaurant') {
            return $hotel = Db::table('hesperiaplugins_restaurant_info as b')->lists('b.nombre','b.id');
        }
        else{
            return [' ' => '----'];
        }
    }

    public function scopeHotel($query, $filter){

        return $query->join('hesperiaplugins_hoteles_hotel as h','ofertable_id','=', 'h.id')
                     ->whereIn('ofertable_id', $filter);
    }
}
