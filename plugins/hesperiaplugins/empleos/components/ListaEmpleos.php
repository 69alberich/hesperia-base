<?php namespace Hesperiaplugins\Empleos\Components;

use Cms\Classes\ComponentBase;
use Hesperiaplugins\Empleos\Models\Oferta;

class ListaEmpleos extends ComponentBase{

	public $empleos;
  public $ofertaId;
    public function componentDetails(){
	    return [
	        'name' => 'Lista de Empleos',
	        'description' => 'Muestra un listado de ofertas de empleo'
	    ];
	}

	public function defineProperties(){
	    return [
	        'slug' => [
                'title'       => 'Slug',
                'description' => 'slug',
                'default'     => '',
                'type'        => 'string'
            ],
          'filter' => [
            'title'       => 'Filtro',
            'type'        => 'dropdown',
            'default'     => '',
            'placeholder' => 'Seleccione filtro',
            'options'     => ['1'=>'Categoria', '2'=>'Localidad','3'=>'Empresa']
        ]  
	    ];
    }

	public function prepareVars(){

    $slug = $this->property('slug');
    
		if($this->property('filter') == '1'){

			$this->empleos = $this->page["empleos"] = Oferta::whereHas('categorias', function($categorias) use($slug){ 
        $categorias->where('slug','=', $slug); 
      })->where('ind_activo',1)->get();
    	
      }elseif($this->property('filter') == '2'){

        $this->empleos = $this->page["empleos"] = Oferta::whereHas('localidad', function($localidad) use($slug){ 
        $localidad->where('slug','=', $slug); 
      })->where('ind_activo',1)->get();

    	}elseif($this->property('filter') == '3'){
        
        $this->ofertaId = $this->param('id');
        $oferta = Oferta::find($this->ofertaId);

        if($oferta->ofertable_type == "HesperiaPlugins\Hoteles\Models\Hotel" ){

          $this->empleos = $this->page["empleos"] = Oferta::where('ofertable_id',$oferta->ofertable_id)->where('ofertable_type','HesperiaPlugins\Hoteles\Models\Hotel')->where('ind_activo',1)->get();
        }
        if($oferta->ofertable_type == "HesperiaPlugins\Restaurant\Models\Restaurant"){

          $this->empleos = $this->page["empleos"] = Oferta::where('ofertable_id',$oferta->ofertable_id)->where('ofertable_type','HesperiaPlugins\Restaurant\Models\Restaurant')->where('ind_activo',1)->get();
        }

      }else{
        
    		$this->empleos = $this->page["empleos"] = Oferta::where('ind_activo',1)->get();
    	}
  	}

  public function onRun(){

   	$this->prepareVars();
  }
}

?>