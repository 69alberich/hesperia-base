<?php namespace HesperiaPlugins\Hoteles\Components;

use Cms\Classes\ComponentBase;
use Hesperiaplugins\Hoteles\Models\Paquete;

class ListaPaquetes extends ComponentBase{

	public $paquetes;

	public function componentDetails(){
	    return [
	        'name' => 'Lista Paquetes',
	        'description' => 'Lista de Paquetes'
	    ];
	}

	public function defineProperties(){
	    return [
        	'num_slides' => [
	            'title'       => 'Cantidad slides',
	            'type'        => 'dropdown',
	            'default'     => '1',
	            'placeholder' => 'Select units',
	            'options'     => ['1'=>'1', '3'=>'3'],
      		],
            'max_items' => [
	            'title'       => 'Cantidad Máxima',
	            'type'        => 'dropdown',
	            'default'     => '1',
	            'placeholder' => 'Select units',
	            'options'     => ['1'=>'1', '3'=>'3', '5'=>'5']
       	  	],
       	  	'sortOrder' => [
                'title'       => 'Ordenar paquetes por',
                'description' => '',
                'type'        => 'dropdown',
                'default'     => 'created_at asc'
            ],
            'ind_destacado' => [
	          'title'       => '¿Sólo destacados?',
	          'type'        => 'checkbox',
         	]
	    ];
    }

    public function onRun(){

   		$this->cargarPaquetes();
  	}

  	public function onRender(){

      if (empty($this->paquetes)) {
          $this->paquetes = $this->page['paquetes'] = $this->cargarPaquetes();
      }
 	}

    public function cargarPaquetes(){
    	
    	$paquetes = Paquete::listPaquetes([

    		'sortOrder'     => $this->property('sortOrder'),
    		'ind_destacado' => $this->property('ind_destacado')
    	]);

    	return $paquetes->get();
    }

    public function getsortOrderOptions(){
    	return $opcionesOrdenamiento = [
	        'created_at asc' => 'Fecha de creación (ascending)',
	        'created_at desc' => 'Fecha de creación (descending)'
    	];
  	}
}