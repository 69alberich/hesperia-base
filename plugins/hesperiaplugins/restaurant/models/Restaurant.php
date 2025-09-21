<?php namespace HesperiaPlugins\Restaurant\Models;
use Illuminate\Support\Facades\DB;
use Model;
//use Database;
/**
 * Model
 */
class Restaurant extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /*
     * Validation
     */
    public $rules = [
      'nombre' => 'required',
      'slug' => 'required',
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
    public $table = 'hesperiaplugins_restaurant_info';

    public function getRecomendados($id){
      return $recomendados = Restaurant::where('id', '<>', $id)->get();
      //return $recomendados = Db::table($this->table)->where('id', '<>', $id)->get();
    }

    /*relaciones*/

    protected $jsonable = ['telefonos','emails'];

    public $attachOne = [
      'banner'=> 'System\Models\File',
      'foto_portada'=>'System\Models\File'
    ];

    public $hasMany = [
       'secciones' => ['HesperiaPlugins\Restaurant\Models\Seccion', 'key' => 'restaurant_id']
     ];

     public $attachMany = [
       'galeria'=> 'System\Models\File'
     ];

     public $belongsTo = [
      'hotel' => ['HesperiaPlugins\Hoteles\Models\Hotel', 'key' => 'hotel_id']
     ];
}
