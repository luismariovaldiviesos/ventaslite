<?php

namespace App\Http\Livewire;


use App\Http\Livewire\Scaner;
use App\Models\Category;
use App\Models\Impuesto;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Traits\CartTrait;

class ProductsController extends Scaner //Component
{

	use WithPagination;
	use WithFileUploads;
	use CartTrait;


	public $name,$barcode,$cost,$price,$stock,$alerts,$categoryid,$impuesto_id, $search,$selected_id,$pageTitle,$componentName;
	private $pagination = 5;


	public function paginationView()
	{
		return 'vendor.livewire.bootstrap';
	}


	public function mount()
	{
		$this->pageTitle = 'Listado';
		$this->componentName = 'Productos';
		$this->categoryid = 'Elegir';
        $this->impuesto_id = 'Elegir';
	}

	public function render()
	{
		if(strlen($this->search) > 0)
			$products = Product::join('categories as c','c.id','products.category_id')
		->select('products.*','c.name as category')
		->where('products.name', 'like', '%' . $this->search . '%')
		->orWhere('products.barcode', 'like', '%' . $this->search . '%')
		->orWhere('c.name', 'like', '%' . $this->search . '%')
		->orderBy('products.name', 'asc')
		->paginate($this->pagination);
		else
			$products = Product::join('categories as c','c.id','products.category_id')
		->select('products.*','c.name as category')
		->orderBy('products.name', 'asc')
		->paginate($this->pagination);




		return view('livewire.products.component', [
			'data' => $products,
			'categories' => Category::orderBy('name', 'asc')->get(),
            'impuestos' => Impuesto::orderBy('id','asc')->get()
		])
		->extends('layouts.theme.app')
		->section('content');
	}


	public function Store()
	{
		$rules  =[
			'name' => 'required|unique:products|min:3',
			'cost' => 'required',
			'price' => 'required',
			'stock' => 'required',
			'alerts' => 'required',
			'categoryid' => 'required|not_in:Elegir',
            'impuesto_id' => 'required|not_in:Elegir'
		];

		$messages = [
			'name.required' => 'Nombre del producto requerido',
			'name.unique' => 'Ya existe el nombre del producto',
			'name.min' => 'El nombre del producto debe tener al menos 3 caracteres',
			'cost.required' => 'El costo es requerido',
			'price.required' => 'El precio es requerido',
			'stock.required' => 'El stock es requerido',
			'alerts.required' => 'Ingresa el valor mínimo en existencias',
			'categoryid.not_in' => 'Elige un nombre de categoría diferente de Elegir',
            'impuesto_id.not_in' => 'Elige un impuesto',
		];

		$this->validate($rules, $messages);


		$product = Product::create([
			'name' => $this->name,
			'cost' => $this->cost,
			'price' => $this->price,
			'barcode' => $this->barcode,
			'stock' => $this->stock,
			'alerts' => $this->alerts,
			'category_id' => $this->categoryid,
            'impuesto_id' => $this->impuesto_id
		]);


		$this->resetUI();
		$this->emit('product-added', 'Producto Registrado');


	}


	public function Edit(Product $product)
	{
		$this->selected_id = $product->id;
		$this->name = $product->name;
		$this->barcode = $product->barcode;
		$this->cost = $product->cost;
		$this->price = $product->price;
		$this->stock = $product->stock;
		$this->alerts = $product->alerts;
		$this->categoryid = $product->category_id;
        $this->impuesto_id = $product->impuesto_id;


		$this->emit('modal-show','Show modal');
	}

	public function Update()
	{
		$rules  =[
			'name' => "required|min:3|unique:products,name,{$this->selected_id}",
			'cost' => 'required',
			'price' => 'required',
			'stock' => 'required',
			'alerts' => 'required',
			'categoryid' => 'required|not_in:Elegir',
            'impuesto_id' => 'required|not_in:Elegir'
		];

		$messages = [
			'name.required' => 'Nombre del producto requerido',
			'name.unique' => 'Ya existe el nombre del producto',
			'name.min' => 'El nombre del producto debe tener al menos 3 caracteres',
			'cost.required' => 'El costo es requerido',
			'price.required' => 'El precio es requerido',
			'stock.required' => 'El stock es requerido',
			'alerts.required' => 'Ingresa el valor mínimo en existencias',
			'categoryid.not_in' => 'Elige un nombre de categoría diferente de Elegir',
            'impuesto_id.not_in' => 'Elige un impuesto'
		];

		$this->validate($rules, $messages);

		$product = Product::find($this->selected_id);

		$product->update([
			'name' => $this->name,
			'cost' => $this->cost,
			'price' => $this->price,
			'barcode' => $this->barcode,
			'stock' => $this->stock,
			'alerts' => $this->alerts,
			'category_id' => $this->categoryid,
            'impuesto_id' => $this->impuesto_id
		]);

	    $this->resetUI();
		$this->emit('product-updated', 'Producto Actualizado');


	}



	public function resetUI()
	{
		$this->name ='';
		$this->barcode ='';
		$this->cost ='';
		$this->price ='';
		$this->stock ='';
		$this->alerts ='';
		$this->search ='';
		$this->categoryid ='Elegir';
	    $this->selected_id = 0;
        $this->impuesto_id = 0;

	}

	protected $listeners =[
		'deleteRow' => 'Destroy'
	];

	public function ScanCode($code)
	{
		$this->ScanearCode($code);
		$this->emit('global-msg',"SE AGREGÓ EL PRODUCTO AL CARRITO");
	}


	public function Destroy(Product $product)
	{
		// $imageTemp = $product->image;
		$product->delete();

		// if($imageTemp !=null) {
		// 	if(file_exists('storage/products/' . $imageTemp )) {
		// 		unlink('storage/products/' . $imageTemp);
		// 	}
		// }

		$this->resetUI();
		$this->emit('product-deleted', 'Producto Eliminado');
	}


}


