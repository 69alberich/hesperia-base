<?php namespace HesperiaPlugins\Instapago\Components;

use Cms\Classes\ComponentBase;

use HesperiaPlugins\Instapago\Models\Transaccion as Transaccion;
use HesperiaPlugins\Instapago\Models\Afiliado as Afiliado;

use Redirect;
use Flash;
use Lang;
use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Carbon\Carbon;


class Pasarela extends ComponentBase{
		public $afiliadoId;
    public $monto;
    public $referencia;
    public $afiliado;
		public $year;
		public $months;

	public function componentDetails(){
		return[
			'name' => 'Pasarela de Pago',
			'description' => 'Pasarela de pago de Instapago, etc etc etc.'
		];
	}

	public function defineProperties()
    {
        return [
            'afiliadoId' => [
                'title'       => 'Id afiliado',
                'description' => 'Id del afiliado a consultar'
            ],
            'monto' => [
                'title'       => 'Monto',
                'description' => 'Monto a procesar'
            ],
            'referencia' => [
                'title'       => 'Referencia',
                'description' => 'Referencia de factura o servicio a pagar'
            ],
						'year' => [
                'title'       => 'Año de Vigencia',
                'description' => 'Año desde para vigenia',
								'default' => Carbon::now()->year,
            ]
        ];
    }

    public function onRun(){ /*Corre antes del render*/
        $this->addJs('assets/js/onPay.js');

				/*if ($this->page["monto"]) {

					echo "<h2>ya le pasé el monto</h2>";
				}else{
					echo "<h2>no hay monto aún</h2>";
				}*/
    }

    public function onRender(){ /*Aqui es donde se deben recuperar los parametros*/
			$fecha = Carbon::now();
			$this->year = $fecha->year;
			$this->months = array(
				"Enero" => "01",
				"Febrero" => "02",
				"Marzo" => "03",
				"Abril" => "04",
				"Mayo" => "05",
				"Junio" => "06",
				"Julio" => "07",
				"Agosto" => "08",
				"Septiembre" => "09",
				"Octubre" => "10",
				"Noviembre" => "11",
				"Diciembre" => "12",
			);
    }

	protected function datosAfiliado($id){

		$afiliado = Afiliado::where('id', $id)
               ->get();
        return $afiliado;

	}

    public function onPay(){
        /*
         * Validate input
         */
				 $id = null;
				 $data = post();
				 $obj = null;
				 //var_dump($data);
				 //return 0;
				 if ($data["afl"]) {
					 $id = $data["afl"];
				}else{
						$id = $this->property('afiliadoId');
				}
				if ($this->property("monto")) {
					$monto = $this->property("monto");
				}else{
					try {
					    $monto = Crypt::decrypt($data["mt"]);
					}
					catch (DecryptException $ex) {
					    $monto = null;
					}
				}
				//$flight = Flight::where('active', 1)->first();
				$afiliado = Afiliado::where("id", "=", $id)->first();
				//return $afiliado;

				/*$array = array(
					"success" => true,
					"message" => "Aprobado",
					"id" => null,
					"code"=> "400",
					"reference" => null,
					"voucher" => null,
					"ordernumber" => null,
					"sequence" => null,
					"approval" => null,
					"lote" => null,
					"responsecode" => null,
					"deferred" => false,
					"datetime" => null,
					"amount" => null,
					"authid" => null,
					"transaccion" => 34
				);

				return json_encode($array);*/

				 if ($afiliado && $monto && $afiliado->status_id = 1) {
				 		//PROCEDIMIENTO DE PAGO
						 $url = 'https://api.instapago.com/payment';

						 $fields = array(
								 "KeyID"             => $afiliado->llave_privada, //requerido
								 "PublicKeyId"       => $afiliado->llave_publica, //requerido
								 "Amount"            => $monto, //requerido
								 "Description"       => "Prueba pasarela de Pago por Maria Cristovao - Marketing", //requerido
								 "CardHolder"        => $data["nombre_tarjeta"], //requerido
								 "CardHolderId"      => $data["identificacion"], //requerido
								 "CardNumber"        => $data["numero_tarjeta"], //requerido
								 "CVC"               => $data["cvc"], //requerido
								 "ExpirationDate"    => $data["mes_expira"].'/'.$data["anio_expira"], //requerido
								 "StatusId"          => "2", //requerido
								 "IP"                => $_SERVER["REMOTE_ADDR"] //requerido
						 );
						 $ch = curl_init();
						 curl_setopt($ch, CURLOPT_URL,$url);
						 curl_setopt($ch, CURLOPT_POST, 1);
						 curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($fields));
						 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						 $server_output = curl_exec ($ch);
						 curl_close ($ch);
						 $obj = json_decode($server_output);
						 if($obj != NULL){
								 $transaccion = new Transaccion();
								 $transaccion->tarjetahabiente = $data["nombre_tarjeta"];
								 $transaccion->identificacion = $data["identificacion"];
								 $transaccion->monto = $monto;
								 $transaccion->status = $obj->code;
								 $transaccion->mensaje = $obj->message;
								 $transaccion->voucher = html_entity_decode($obj->voucher);
								 $transaccion->afiliado_id = $afiliado->id;
								 $transaccion->referencia = "reserva de habitaciones";
								 $transaccion->save();
								 $message = $obj->message;
						 }
				 }
				 $retorno = null;
				 if ($obj->success == true) {
				 	$retorno = array(
						"success" => true,
						"voucher" => $obj->voucher,
						"transaccion" => $transaccion->id
					);
				}else{
					/*$mensaje = utf8_encode($obj->message);
					$obj->message = $mensaje;*/
					$retorno = $obj;
				}
				 return json_encode($retorno);
    }

}
