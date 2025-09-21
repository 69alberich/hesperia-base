<?php namespace hesperiaplugins\Perfil;

use System\Classes\PluginBase;
use RainLab\User\Controllers\Users as UsersController;
use RainLab\User\Models\User as UserModel;

class Plugin extends PluginBase{

    public function registerComponents(){
    }

    public function registerSettings(){
    }

    public function boot(){

        UserModel::extend(function($model){
            $model->belongsTo['rol'] = ['Hesperiaplugins\Perfil\Models\Rol', 'key' => 'rol_id'];
        });

        UserModel::extend(function($model){
            $model->belongsTo['padre'] = ['Rainlab\User\Models\user', 'key' => 'padre_id', 'conditions' => 'rol_id = 3'];
        });

        UserModel::extend(function($model){
            $model->hasMany['contratos'] = ['Hesperiaplugins\Perfil\Models\Contrato', 'key' => 'id'];
        });

    	UsersController::extendFormFields(function($form, $model, $context){

            if($model->rol_id == 4){
                $form->addTabFields([
                    'identificacion' => [
                        'label' => 'Identificación',
                        'type'  => 'text',
                        'tab'   => 'Perfil'
                    ],
                    'direccion' => [
                        'label' => 'Dirección',
                        'type'  => 'text',
                        'tab'   => 'Perfil'
                    ],
                    'telefonos' => [
                        'label' => 'Telefonos',
                        'type'  => 'textarea',
                        'tab'   => 'Perfil'
                    ],
                    'rol' => [
                        'label' => 'Rol Id',
                        'nameFrom' => 'descripcion',
                        'type'  => 'relation',
                        'tab'   => 'Perfil'
                    ],
                    'padre' => [
                        'label' => 'Padre Id',
                        'select' => "concat (name, ' ', surname)",
                        'type'  => 'relation',
                        'tab'   => 'Perfil',

                    ]

                ]);
            }else{
                $form->addTabFields([
                    'identificacion' => [
                        'label' => 'Identificación',
                        'type'  => 'text',
                        'tab'   => 'Perfil'
                    ],
                    'direccion' => [
                        'label' => 'Dirección',
                        'type'  => 'text',
                        'tab'   => 'Perfil'
                    ],
                    'telefonos' => [
                        'label' => 'Telefonos',
                        'type'  => 'textarea',
                        'tab'   => 'Perfil'
                    ],
                    'rol' => [
                        'label' => 'Rol Id',
                        'nameFrom' => 'descripcion',
                        'type'  => 'relation',
                        'tab'   => 'Perfil'
                    ]

                ]);
            }



    	});
    }
}
