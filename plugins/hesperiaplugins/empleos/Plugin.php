<?php namespace Hesperiaplugins\Empleos;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    	return[
    	  'HesperiaPlugins\Empleos\Components\ListaEmpleos' => 'listaempleos',
    	  'HesperiaPlugins\Empleos\Components\Empleo' => 'empleo'
    	];
    }

    public function registerSettings()
    {
    }

    public function registerListColumnTypes(){
        return [
            
            'tipo' => [$this, 'getTypelName'],
        ];
    }

    public function getTypelName($value, $column, $record){
       return  $tipoEmpresa = $value["nombre"];
       
    }
}
