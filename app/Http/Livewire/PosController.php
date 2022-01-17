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

class PosController extends Component
{
	use CartTrait;

	public $total,$itemsQuantity, $efectivo, $change;

    public $searchCliente = '';


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
        else{
            $this->searchCliente ="Consumidor Final";
        }
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

		DB::beginTransaction();

		try {

			$sale = Sale::create([
				'total' => $this->total,
				'items' => $this->itemsQuantity,
				'cash' => $this->efectivo,
				'change' => $this->change,
				'user_id' => Auth()->user()->id
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


			DB::commit();

			Cart::clear();
			$this->efectivo =0;
			$this->change =0;
			$this->total = Cart::getTotal();
			$this->itemsQuantity = Cart::getTotalQuantity();
			$this->emit('sale-ok','Venta registrada con éxito');
			$this->emit('print-ticket', $sale->id);




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

    public function seleccionaCliente($id)
    {
        dd($id);
    }

    //https://www.youtube.com/watch?v=BGNLi9Cojbs
}

