<?php namespace HesperiaPlugins\Hoteles\Components;

use Cms\Classes\ComponentBase;
use HesperiaPlugins\Hoteles\Models\Upselling as UpsellingModel;
use HesperiaPlugins\Hoteles\Models\CategoriaUpselling;
use HesperiaPlugins\Hoteles\Models\Moneda;
use Flash;
use Session;
use Redirect;
use Carbon\Carbon;

class ListaUpselling extends ComponentBase{

  public $upsellings;
  public $monedas;

  public $implement = [
        'HesperiaPlugins.Hoteles.Behaviors.UtilityFunctions'
    ];

  public function defineProperties(){

    return [
            'moneda' => [
              'title' => 'Moneda',
              'type' => 'dropdown',
              'default'=> '3'
            ],
            /*'categorias' => [
                'title' => 'Categorias',
                'type' => 'dropdown',
            ],
            
            'tag' => [
             'title'             => 'Tag',
             'description'       => 'Tags que tiene el upselling',
             'type'              => 'string'
            ],
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
           'options'     => ['1'=>'1', '3'=>'3', '5'=>'5'],

         ],
         'destacados' => [
          'title'       => '¿Sólo destacados?',
          'type'        => 'checkbox',
         ],*/
         'codes' => [
          'title'             => "Codes/ID'",
          'description'       => 'Escribe los ids de upsellings separados por coma',
          'type'              => 'string'
          ]
        ];
  }

  public function componentDetails(){
    return [
      'name'=> 'Lista Upselling',
      'description' => 'Lista de upsellings'
    ];
  }

  public function onRun(){
    //$this->addJs('assets/js/upselling.js');
  }
  public function onRender(){
      if (empty($this->upsellings)) {
          //$this->monedas = $this->page['monedas'] = $this->cargarMonedas();
          $this->upsellings = $this->cargarUpsellings();
      }
  }

  public function cargarUpsellings(){
    $hoy = new Carbon;
    $propiedades["checkin"] = $hoy;
    $propiedades["checkout"] = $hoy;
    $propiedades["moneda"] = $this->property("moneda");

    $categoria = $this->property("categorias");

    $upsellings = UpsellingModel::whereHas("categorias", function($query) use ($categoria) {
      $query->where("id", $categoria);
    });
    if (($tag = $this->property("tag"))!= null ) {
      $upsellings->whereHas("tags", function($query) use ($tag){
        $query->where("tag", $tag);
      });
    }
    if ($this->property("destacados") == 1) {
      $upsellings->where("destacado", 1);
    }

    //$upsellings= $upsellings->get();

    //$propiedades["hotel"] = $upselling->hotel_id;

    //$upselling->precios = $upselling->isDisponible($propiedades);
    //$this->page["propiedades"]= $propiedades;
    $tg = $this->property('tag');
    //echo "$categoria";
    return $upsellings->get();
  }

  public function getUpsellingById(){
    
    $stringCodes = $this->property("codes");

    $arrayCodes = explode(",", $stringCodes);
    $idsImploded = implode(',',$arrayCodes);

    $upsellings = UpsellingModel::whereIn("id", $arrayCodes)
    ->orderByRaw("FIND_IN_SET(id,'$idsImploded')");


    return $upsellings->get();
  }

  public function cargarMonedas(){
    $monedas = Moneda::select("id", "moneda", "acronimo")->get();
    return $monedas;
  }

  public function getCategoriasOptions(){
    return CategoriaUpselling::lists('nombre', 'id');
  }

  public function getMonedaOptions(){
    return Moneda::lists('moneda', 'id');
  }

  public function getUpsellingFromArray($codes){

    $arrayCodes = explode(",", $codes);
    $idsImploded = implode(',',$arrayCodes);
    $upsellings = UpsellingModel::whereIn("id", $arrayCodes)
    ->orderByRaw("FIND_IN_SET(id,'$idsImploded')");


    return $upsellings->get();
  }
}
