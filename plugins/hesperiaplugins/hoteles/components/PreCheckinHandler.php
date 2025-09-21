<?php namespace HesperiaPlugins\Hoteles\Components;

use Cms\Classes\ComponentBase;
use HesperiaPlugins\Hoteles\Models\Reservacion;
use HesperiaPlugins\Hoteles\Models\DetalleReservacion;
use Crypt;
use Input;
use Storage;
use Illuminate\Contracts\Encryption\DecryptException;

class PreCheckinHandler extends ComponentBase{

    public $reserva;

    public function defineProperties(){
        return [
          'reserva_id' => [
              'title'       => 'ID reservación',
              'description' => 'Si ya existe la reservación, se cargará desde url',
              'default'     => '{{ :reserva_id }}',
              'type'        => 'string'
          ]
        ];

    }

    public function componentDetails(){
        return [
          'name'=> 'Pre-chekin handler',
          'description' => 'funciones para hacer pre-checkin'
        ];
      }

    public function onRun(){
        $id_decrypt = null;
        if ($this->param('reserva_id')) {

            $reservacion = Reservacion::where("codigo", $this->param('reserva_id'))->first();
            if($reservacion == null){

                try {
                    $id_decrypt = Crypt::decrypt($this->param("reserva_id"));
                }
                catch (DecryptException $ex) {
                    //
                }
            }
            
            if($id_decrypt){
                $reservacion = Reservacion::find($id_decrypt);
            }
           
        }

        if($reservacion->info_adicional != null ){
            $this->reserva = null;
        }else{
            $this->reserva = $reservacion;
        }
        

        //trace_log($this->reserva->id);
    }


    public function onSave(){
       //$file = Input::file("archivo2");
       $data = Input::all();
       $decrypted = null;
        trace_log($data);

       if (isset($data["codigo"])) {
        $reservacion = Reservacion::where("codigo", $data["codigo"])->first();
        }

        if($reservacion == null){
            try {
                $decrypted = Crypt::decrypt($this->param('reserva_id'));
            }
            catch (DecryptException $ex) {
                $decrypted = null;
            }

            $reservacion = Reservacion::find($decrypted);
        }
           
        $directory = "media/documentos/".$reservacion->id;

       Storage::makeDirectory($directory);

       // trace_log($data["info_adicional"]);

       $reservacion->info_adicional = [$data["info_adicional"]];

       $reservacion->save();
       
       $arDetallesId = array();

       foreach ($data as $key => $value) {
            $index = explode("-", $key);
            if($index[0]== "d" ){
                if (!isset($arDetallesId[$index[2]])) {
                    $arDetallesId[$index[2]] = array();
                }
                 
            }
       }
       
       foreach ($data as $key => $value) {
           
           $index = explode("-", $key);
         

           if($index[0]== "d" ){
           
           // $detalle = DetalleReservacion::find($index[2]);
            
            if (isset($data[$key]["huespedes"])) {

                $arHuespedes = $data[$key]["huespedes"];

                if (isset($arHuespedes["documento"])) {

                    $file = $arHuespedes["documento"];
                    $filePath = Storage::put($directory,
                    $file);
                    $fileName = str_replace("media","", $filePath);
                    
                    $data[$key]["huespedes"]["documento"] = $fileName;

                    
                } 
                
                if (isset($arDetallesId[$index[2]]["huespedes"])) {
                   // trace_log("push".$index[2]);
                    array_push($arDetallesId[$index[2]]["huespedes"], $data[$key]["huespedes"]);
                }else{
                    //trace_log("not-push".$index[2]);
                    $arDetallesId[$index[2]]["huespedes"] = array($data[$key]["huespedes"]);
                }
            }

            if (isset($data[$key]["info_adicional"])) {
                $arDetallesId[$index[2]]["info_adicional"] =  [$data[$key]["info_adicional"]]; 
            }
           }
           
       }
       //trace_log($arDetallesId);

       foreach ($arDetallesId as $key => $value) {
        $detalle = DetalleReservacion::find($key);
        if(isset($value["info_adicional"])){
            //$detalle->info_adicional = $value["info_adicional"];
        }
        
        $detalle->huespedes = $value["huespedes"];
        $detalle->save();
       }
       //trace_log($arDetallesId);
       
    }
}