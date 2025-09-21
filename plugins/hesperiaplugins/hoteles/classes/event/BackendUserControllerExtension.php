<?php namespace HesperiaPlugins\Hoteles\Classes\Event;

use Backend\Controllers\Users as UsersController;
use Backend\Models\User as UserModel;

class BackendUserControllerExtension {

    public function subscribe($obEvent){

        UsersController::extendFormFields(function ($form, $model, $context) {
            // Prevent extending of related form instead of the intended User form
            if (!$model instanceof UserModel) {
               
                return;
            }
           
            $form->addTabFields([
                'hoteles' => [
                    'tab' => 'Hoteles',
                    'type'  => 'relation',
                    'context' => ['update', 'preview'],
                    "nameFrom" =>  "nombre"
                ],
                
                
            ]);
            
        });
        /*
        OrdersController::extend(function($controller) {
            
            $this->addDynamicMethods($controller);

            if (!isset($controller->relationConfig)) {
                $controller->addDynamicProperty('relationConfig');
            }
        
            // Splice in configuration safely
            $myConfigPath = '$/qchsoft/shopplus/config/order_payment_relation.yaml';

            $controller->relationConfig = $controller->mergeConfig(
                $controller->relationConfig,
                $myConfigPath
            );

            $user = BackendAuth::getUser();
            if($user){
                if(!$user->hasAccess("change-order-status")){
                    $myPreviewConfigPath = '$/qchsoft/shopplus/config/order_controller_config_list.yaml';
                    $controller->listConfig =  $myPreviewConfigPath;
                }else{
                    $myPreviewConfigPath = '$/qchsoft/shopplus/config/order_controller_custom_config_list.yaml';
                    $controller->listConfig =  $myPreviewConfigPath;
                }
            }
            
        });

        */

    }
    
}