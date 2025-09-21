<?php namespace hesperiaplugins\Instapago;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    	return [
            'hesperiaplugins\Instapago\Components\Pasarela' => 'pasarela'
        ];
    }

    public function registerSettings()
    {
    }
}
