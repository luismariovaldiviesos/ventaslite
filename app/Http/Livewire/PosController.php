<?php

namespace App\Http\Livewire;

use App\Models\Cliente;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use App\Models\Denomination;
use App\Models\SaleDetail;
use Livewire\Component;

use App\Traits\CartTrait;
use App\Models\Product;
use App\Models\Sale;
use DB;
use DOMDocument;
use Illuminate\Support\Facades\Storage;

class PosController extends Component
{
	use CartTrait;

	public $total,$itemsQuantity, $efectivo, $change;

    public $searchCliente = '';

	public $cliente_id;


	public function mount()
	{
		$this->efectivo =0;
		$this->change =0;
		$this->total  = Cart::getTotal();
		$this->itemsQuantity = Cart::getTotalQuantity();


	}

	public function render()
	{
        $clientesResult = [];
        if(strlen($this->searchCliente) > 0)
        {
            $clientesResult = Cliente::where('nombre','like','%'.$this->searchCliente.'%')
                                        ->orWhere('ruc','like','%'.$this->searchCliente.'%')->get();
            //dd($clientesResult);
        }
        // else{
        //     $this->searchCliente ="Consumidor Final";
        // }
		return view('livewire.pos.component', [
			'denominations' => Denomination::orderBy('value','desc')->get(),
			'cart' => Cart::getContent()->sortBy('name'),
            'clienteResult' => $clientesResult
		])
		->extends('layouts.theme.app')
		->section('content');
	}

	// agregar efectivo / denominations
	public function ACash($value)
	{
		$this->efectivo += ($value == 0 ? $this->total : $value);
		$this->change = ($this->efectivo - $this->total);
	}

	// escuchar eventos
	protected $listeners = [
		'scan-code'  =>  'ScanCode',
		'removeItem' => 'removeItem',
		'clearCart'  => 'clearCart',
		'saveSale'   => 'saveSale',
		'refresh' => '$refresh',
		'print-last' => 'printLast'
	];


	// buscar y agregar producto por escaner y/o manual
	public function ScanCode($barcode, $cant = 1)
	{
		$this->ScanearCode($barcode, $cant);
	}

	// incrementar cantidad item en carrito
	public function increaseQty(Product $product, $cant = 1)
	{
		$this->IncreaseQuantity($product, $cant);
	}

	// actualizar cantidad item en carrito
	public function updateQty(Product $product, $cant = 1)
	{
		if($cant <=0)
			$this->removeItem($product->id);
		else
			$this->UpdateQuantity($product, $cant);
	}

	// decrementar cantidad item en carrito
	public function decreaseQty($productId)
	{
		$this->decreaseQuantity($productId);
	}

	// vaciar carrito
	public function clearCart()
	{
		$this->trashCart();
	}


	// guardar venta
	public function saveSale()
	{
		//dd($this->cliente_id);
		if($this->total <=0)
		{
			$this->emit('sale-error','AGEGA PRODUCTOS A LA VENTA');
			return;
		}
		if($this->efectivo <=0)
		{
			$this->emit('sale-error','INGRESA EL EFECTIVO');
			return;
		}
		if($this->total > $this->efectivo)
		{
			$this->emit('sale-error','EL EFECTIVO DEBE SER MAYOR O IGUAL AL TOTAL');
			return;
		}
        if($this->cliente_id == null){

            $this->emit('sale-error','iNGRESA DATOS DEL CLIENTE');
			return;


        }

		DB::beginTransaction();

		try {

			$sale = Sale::create([
				'total' => $this->total,
				'items' => $this->itemsQuantity,
				'cash' => $this->efectivo,
				'change' => $this->change,
				'user_id' => Auth()->user()->id,
                'cliente_id' => $this->cliente_id
			]);

			if($sale)
			{
				$items = Cart::getContent();
				foreach ($items as  $item) {
					SaleDetail::create([
						'price' => $item->price,
						'quantity' => $item->quantity,
						'product_id' => $item->id,
						'sale_id' => $sale->id,
					]);

					//update stock
					$product = Product::find($item->id);
					$product->stock = $product->stock - $item->quantity;
					$product->save();
				}

			}


            $this->creaXML();

			DB::commit();

			Cart::clear();
			$this->efectivo =0;
			$this->change =0;
			$this->total = Cart::getTotal();
			$this->itemsQuantity = Cart::getTotalQuantity();
			$this->emit('sale-ok','Venta registrada con éxito');
			$this->emit('print-ticket', $sale->id);
            $this->searchCliente = "";
            $this->cliente_id="";




		} catch (Exception $e) {
			DB::rollback();
			$this->emit('sale-error', $e->getMessage());
		}

	}


	public function printTicket($ventaId)
	{
		return \Redirect::to("print://$ventaId");

	}


	public function printLast()
	{
		$lastSale = Sale::latest()->first();

		if($lastSale)
			$this->emit('print-last-id', $lastSale->id);
	}

    public function seleccionaCliente(Cliente $cliente)
    {
        $this->cliente_id = $cliente->id;
		$this->searchCliente = $cliente->nombre;

    }

    //https://www.youtube.com/watch?v=BGNLi9Cojbs


    public function creaXML()
    {

        $xml = new DOMDocument('1.0','utf-8');
        $xml->formatOutput = true;
        $xml_fac = $xml->createElement('factura');
        $cabecera = $xml->createAttribute('id');
        $cabecera->value = 'comprobante';
        $cabecerav = $xml->createAttribute('version');
        $cabecerav->value ='1.00';

        $xml_inf =$xml->createElement('infoTributaria');  //info
        $xml_amb =$xml->createElement('ambiente','1'); // ambiente  1 pruebas
        $xml_tip =$xml->createElement('tipoEmision','1'); //tipo
        $xml_raz =$xml->createElement('razonSocial','Valdivieso Solano Luis Mario'); // razon social
        $xml_nom =$xml->createElement('nombreComercial','Valdivieso Solano Luis Mario'); //nombre comercial
        $xml_ruc =$xml->createElement('ruc','0104649843001'); // en tabla

        $xml_cla =  $xml->createElement('claveAcceso','2110201101179214673900110020010000000011234567813'); // se genera automaticamente mertodo
        $xml_doc =  $xml->createElement('codDoc','01'); // factura se genera auntomaitico
        $xml_est =  $xml->createElement('estab','001'); // estabecimeinto configurar   REVISAR
        $xml_emi =  $xml->createElement('ptoEmi','001'); // punto emision  REVISAR
        $xml_sec =  $xml->createElement('secuencial','000000001'); // secuencia (9 digitos ) REVISAR
        $xml_dir =  $xml->createElement('dirMatriz','Davila chica y manuel moreno'); // dir matriz


        $xml_def = $xml->createElement('infoFactura');
        $xml_fec = $xml->createElement('fechaEmision','21/10/2012'); // FECHA VENTA
        $xml_des = $xml->createElement('dirEstablecimiento','Davila chica y manuel moreno');  //
        $xml_obl = $xml->createElement('obligadoContabilidad','SI'); //  INTERNO
        $xml_ide = $xml->createElement('tipoIdentificacionComprador','04');  // 05 CEDULA 0ALGO RUC  REVISAR RUC COMPRADOR
        $xml_rco = $xml->createElement('razonSocialComprador','razo social del comprador'); // NOMBRE CLIENTE
        $xml_idc = $xml->createElement('identificacionComprador','1713328506001');  // RUC O CEDIULA CLIENTE
        $xml_tsi = $xml->createElement('totalSinImpuestos','295000.00');   // VENTA
        $xml_tds = $xml->createElement('totalDescuento','00.00'); // DESCUENTOS REVISAR

        $xml_ips = $xml->createElement('totalConImpuestos','00.00');
        $xml_tim = $xml->createElement('totalImpuesto','00.00');
        $xml_tco = $xml->createElement('codigo','2'); // codigo impuesto
        $xml_cpr = $xml->createElement('codigoProcentaje','2');
        $xml_bas = $xml->createElement('baseImponible','1.00');
        $xml_val = $xml->createElement('valor','0');

        $xml_pro = $xml->createElement('propina','0.00');
        $xml_imt = $xml->createElement('importeTotal','1.00');
        $xml_mon = $xml->createElement('moneda','DOLAR'); // INTERNO

        $xml_pgs = $xml->createElement('pagos');
        $xml_pag = $xml->createElement('pago');
        $xml_fpa = $xml->createElement('formaPago','01');   // formas pagos  REVISAR
        $xml_tot = $xml->createElement('total','1.00');
        $xml_pla = $xml->createElement('plazo','30');
        $xml_uti = $xml->createElement('unidadTiempo','dias');

        $xml_dts = $xml->createElement('detalles');
        $xml_det = $xml->createElement('detalle');
        $xml_cop = $xml->createElement('codigoPrincipal','cod008');  // COD PRODUCTO
        $xml_dcr = $xml->createElement('descripcion','formateos'); // DESC PRODUCTO
        $xml_can = $xml->createElement('cantidad','1');   // CANTIDAD PRODUCTO
        $xml_pru = $xml->createElement('precioUnitario','20'); // PRECIO UNITARIO
        $xml_dsc = $xml->createElement('descuento','0'); // DESCUENTO
        $xml_tsm = $xml->createElement('precioTotalSinImpuesto','20');  // TOTAL

        $xml_ips = $xml->createElement('impuestos');
        $xml_ipt = $xml->createElement('impuesto');
        $xml_cdg = $xml->createElement('codigo','2');
        $xml_cpt = $xml->createElement('codigoPorcentaje','2');
        $xml_trf = $xml->createElement('tarifa','0.00');
        $xml_bsi = $xml->createElement('baseImponible','1.00');
        $xml_vlr = $xml->createElement('valor','2');

        $xml_ifa = $xml->createElement('infoAdicional');
        $xml_cp1 = $xml->createElement('campoAdicional','tucorreo@mail.com');
        $atributo = $xml->createAttribute('nombre');
        $atributo->value='email';

        //cerrar tags

        $xml_inf->appendChild($xml_amb);
        $xml_inf->appendChild($xml_tip);
        $xml_inf->appendChild($xml_raz);
        $xml_inf->appendChild($xml_nom);
        $xml_inf->appendChild($xml_ruc);
        $xml_inf->appendChild($xml_cla);
        $xml_inf->appendChild($xml_doc);
        $xml_inf->appendChild($xml_est);
        $xml_inf->appendChild($xml_emi);
        $xml_inf->appendChild($xml_sec);
        $xml_inf->appendChild($xml_dir);

        $xml_fac->appendChild($xml_inf);

            $xml_def->appendChild($xml_fec);
            $xml_def->appendChild($xml_des);
            $xml_def->appendChild($xml_obl);
            $xml_def->appendChild($xml_ide);
            $xml_def->appendChild($xml_rco);
            $xml_def->appendChild($xml_idc);
            $xml_def->appendChild($xml_tsi);
            $xml_def->appendChild($xml_tds);
            $xml_def->appendChild($xml_imt);
            $xml_def->appendChild($xml_tim);
            $xml_def->appendChild($xml_tco);
            $xml_def->appendChild($xml_cpr);
            $xml_def->appendChild($xml_bas);
            $xml_def->appendChild($xml_val);

        $xml_fac->appendChild($xml_def);


        $xml_def->appendChild($xml_pro);
        $xml_def->appendChild($xml_imt);
        $xml_def->appendChild($xml_mon);

        $xml_def->appendChild($xml_pgs);
        $xml_pgs->appendChild($xml_pag);
        $xml_pag->appendChild($xml_tot);
        $xml_pag->appendChild($xml_pla);
        $xml_pag->appendChild($xml_uti);


        $xml_fac->appendChild($xml_dts);
        $xml_dts->appendChild($xml_det);
        $xml_det->appendChild($xml_cop);
        $xml_det->appendChild($xml_dcr);
        $xml_det->appendChild($xml_can);
        $xml_det->appendChild($xml_pru);
        $xml_det->appendChild($xml_dsc);
        $xml_det->appendChild($xml_tsm);
        $xml_det->appendChild($xml_ips);
        $xml_ips->appendChild($xml_ipt);
        $xml_ipt->appendChild($xml_cdg);
        $xml_ipt->appendChild($xml_cpt);
        $xml_ipt->appendChild($xml_trf);
        $xml_ipt->appendChild($xml_bsi);
        $xml_ipt->appendChild($xml_vlr);

        $xml_fac->appendChild($xml_ifa);
        $xml_ifa->appendChild($xml_cp1);
        $xml_cp1->appendChild($atributo);

        $xml_fac->appendChild($cabecera);
        $xml_fac->appendChild($cabecerav);
        $xml->appendChild($xml_fac);
      //Se eliminan espacios en blanco
        $xml->preserveWhiteSpace = false;

        //Se ingresa formato de salida
        $xml->formatOutput = true;

        //Se instancia el objeto
        $xml_string =$xml->saveXML();


        //nombre unico
        $customFileName = uniqid() . ' _.' . 'xml';

        //Y se guarda en el nombre del archivo 'achivo.xml', y el obejto nstanciado
        Storage::disk('local')->put('archivo'.$customFileName,$xml_string);

    }



}

