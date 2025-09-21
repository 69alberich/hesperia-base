<?php namespace HesperiaPlugins\Hoteles\Classes\Event;

use Backend\Controllers\Users as UsersController;
use Backend\Models\User as UserModel;
use HesperiaPlugins\Hoteles\Models\Hotel;

class BackendUserModelExtension {

    public function subscribe($obEvent){
        
        
        UserModel::extend(function($model) {

            if (!$model instanceof UserModel) {
               
                return;
            }
            //pregunta si el modelo ha sido creado, si lo descomento no funciona en create 
            
            $model->belongsToMany["hoteles"]= [Hotel::class, 
                'table' => 'hesperiaplugins_hoteles_hotel_agente'];
    
        });
    }
}
