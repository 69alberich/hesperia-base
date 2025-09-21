<?php namespace HesperiaPlugins\Hoteles\Models;

use Model;
use Db;
/**
 * Model
 */
class Hotel extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /*
     * Validation
     */
    public $rules = [
      'nombre' => 'required',
      'descripcion' => 'required',
      'slug' => 'required',
      'informacion' => 'required',
      'emails_notificacion.*.nombre' => 'required',
      'emails_notificacion.*.email' => 'required|email'
    ];

    public $customMessages = [
      'emails_notificacion.*.nombre.required' => 'El campo nombre es obligatorio',
      'emails_notificacion.*.email.required'  => 'El campo email es obligatorio',
      'emails_notificacion.*.email.email'  => 'El campo email tiene un formato incorrecto',
    ];

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    protected $jsonable = ['telefonos','emails', 'atributos', 'lugares', 'emails_notificacion'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'hesperiaplugins_hoteles_hotel';


    /*Relaciones*/

   public $attachOne = [
     'banner'=> 'System\Models\File',
     'foto_inicio'=>'System\Models\File'
   ];

   public $attachMany = [
     'galeria'=> 'System\Models\File'
   ];

   public $belongsToMany =[
     'regimenes' => [
       'HesperiaPlugins\Hoteles\Models\Regimen',
       'table' => 'hesperiaplugins_hoteles_hotel_regimen'
     ],
     'tipo_pagos' => [
      'HesperiaPlugins\Hoteles\Models\TipoPago',
      'table' => 'hesperiaplugins_hoteles_hotel_tipo_pago'
    ]
   ];

   public $hasMany = [
      'habitaciones' => ['HesperiaPlugins\Hoteles\Models\Habitacion', 'key' => 'hotel_id'],
      'servicios' => ['HesperiaPlugins\Hoteles\Models\Servicio', 'key' => 'hotel_id'],
      'restaurantes' =>['HesperiaPlugins\Restaurant\Models\Restaurant', 'key'=>'hotel_id'],
      'novedades' =>['HesperiaPlugins\Hoteles\Models\Novedad', 'key'=>'hotel_id'],
      'impuestos' =>['HesperiaPlugins\Hoteles\Models\Impuesto', 'key'=>'hotel_id'],
      'datosBancarios' =>['HesperiaPlugins\Hoteles\Models\DatosBancarios', 'key'=>'hotel_id']
    ];

    public function getImpuestos($moneda){
      $impuestos =  Impuesto::where('moneda_id', $moneda)->where('hotel_id', $this->id)->get();
      return $impuestos;
    }
}
