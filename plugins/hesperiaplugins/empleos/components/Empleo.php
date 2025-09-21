<?php namespace Hesperiaplugins\Empleos\Components;
use Cms\Classes\ComponentBase;
use Hesperiaplugins\Empleos\Models\Oferta;
use Input;
use Flash;
use Validator;
use ValidationException;
use Hesperiaplugins\Empleos\Models\Postulacion;
use System\Models\File;

class Empleo extends ComponentBase{

  public $empleo;

  public function componentDetails()
    {
        return [
            'name' => 'Oferta especifica',
            'description' => 'Muestra una oferta de empleo'
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title'       => 'Slug',
                'description' => 'slug',
                'default'     => '{{ :slug }}',
                'type'        => 'string'
            ],
        ];
    }
  public function onRun(){
    $this->addJs('assets/js/repeater-field.js');
    $this->empleo = $this->page["oferta"] = $this->cargarOferta();
  }

  public function cargarOferta(){

    $slug = $this->property('slug');
    $oferta = Oferta::where('slug', $slug)->first();
    return $oferta;
  }

    public function onEnviarPostulacion(){
        $data = post();
        $documento = Input::file("documento");
        $data["documento"] = $documento;

        $contactos = $data["contactos"];
        $flag = true;
        $i = 0;
        foreach ($contactos as $key => $contacto) {

            if ($i == 0) {
                if ($contacto["red"] == "" || $contacto["cuenta"] == "") {
                $flag = false;
                }
            }else{
                if ($contacto["red"] == "" || $contacto["cuenta"] == "") {
                unset($data["contactos"][$key] );
                }
            }
            
            $i++;
        }

        if ($flag) {
            $data["contacto"] = "1";  
        }

         $rules = [
         'nombre' => 'required|min:5',
         'email' => 'required|email|unique:hesperiaplugins_empleos_postulaciones,email',
         'contacto' =>'required',
         'documento' => 'mimes:pdf|max:2048|required',
         'mensaje' => 'required'
        ];

        $messages = [
            'contacto.required' => 'Ingrese la informacion de contactos correctamente',
        ];

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $postulacion = new Postulacion();

        $postulacion->nombre = $data["nombre"];
        $postulacion->email = $data["email"];
        $postulacion->mensaje = $data["mensaje"];
        $postulacion->oferta_id = $data["oferta_id"];
        
        $postulacion->contactos = $data["contactos"];
        $postulacion->save();

        $fileToUpload = new File;
        $fileToUpload->fromPost(Input::file("documento"));
        
        $fileToUpload->save();

        $postulacion->archivo()->add($fileToUpload);
        $postulacion->save();
        return true;
        
        
    }
}

?>
