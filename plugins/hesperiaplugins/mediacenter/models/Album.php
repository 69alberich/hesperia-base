<?php namespace hesperiaplugins\Mediacenter\Models;

use Model;

/**
 * Model
 */
class Album extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    protected $jsonable = ['item'];

    /*
     * Validation
     */
    public $rules = [

        'titulo'     => 'required',
        'archivo'    => 'required',
        'categorias' => 'required'
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'hesperiaplugins_mediacenter_album';

    /*Relaciones*/
    public $attachMany = [
   'archivo' => 'System\Models\File'
];

    public $belongsToMany = [
        'categorias' =>[
            'HesperiaPlugins\MediaCenter\Models\Categoria',
            'table' =>'hesperiaplugins_mediacenter_album_categoria'
        ]
    ];

     public $belongsTo = [
     'hotel' => ['HesperiaPlugins\Hoteles\Models\Hotel', 'key' => 'hotel_id']
     //VARIABLE - RUTA DEL MODELO - KEY--> CLAVE-FORANEA EN MI TABLA
    ];



    public function isImagen($file){

        $formatos = ['gif', 'jpg', 'jpeg', 'bmp', 'JPG', 'GIF', 'JPEG', 'BMP','png','PNG'];
        // creo un arreglo con los posiles formatos de imagen, tanto en mayuscula como minuscula
        $ext = $file->extension;
        // pregunto por la extenxion del archivo que estoy recibiendo como parametro y lo paso a la variable $ext
        if (in_array($ext, $formatos)) {  //con el metodo in_array pregunto si un valor existe en un arreglo dado
            return true;
        }else{
            return false;
        }
    }

    public function isImagenPNG($file){

        $formatos = ['png','PNG'];
        $ext = $file->extension;

        if (in_array($ext, $formatos)) { 
            return true;
        } else{
            return false;
        }
    }

    public function isAudio($file){

        $formatos = ['mp3', 'ogg', 'wav', 'wma', 'm4a','MP3','WAV','WMA','M4A','OGG'];
        $ext = $file->extension;
        if (in_array($ext, $formatos)) {
            return true;
        }else {
            return false;
        }
    }

    public function isVideo($file){

        $formatos = ['mp4', 'avi', 'mov', 'mpg','MP4','AVI','MOV','MPG'];
        $ext = $file->extension;
        if (in_array($ext, $formatos)) {
            return true;
        }else {
            return false;
        }
    }

    public function isPDF($file){

        $formatos = ['pdf','PDF'];
        $ext = $file->extension;

        if (in_array($ext, $formatos)) {
            return true;
        }else {
            return false;
        }
    }
}