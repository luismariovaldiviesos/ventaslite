<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Impuesto;
use Livewire\Component;
use Livewire\WithPagination;

class ImpuestoController extends Component
{
    use WithPagination;
    public $nombre,$porcentaje,$codigo,$search,$selected_id,$pageTitle,$componentName;
	private $pagination = 5;


	public function paginationView()
	{
		return 'vendor.livewire.bootstrap';
	}

    public function mount()
	{
		$this->pageTitle = 'Listado';
		$this->componentName = 'Impuestos';

	}


    public function render()
	{
		if(strlen($this->search) > 0)
			$data = Impuesto::where('nombre', 'like', '%' . $this->search . '%')->paginate($this->pagination);
		else
			$data = Impuesto::orderBy('id','desc')->paginate($this->pagination);



		return view('livewire.impuestos.component', ['data' => $data])
		->extends('layouts.theme.app')
		->section('content');
	}

    public function resetUI()
	{
		$this->nombre ='';
		$this->search ='';
		$this->selected_id =0;
	}

    public function Edit($id)
	{
		$record = Impuesto::find($id, ['id','nombre','porcentaje','codigo']);
        $this->selected_id = $record->id;
		$this->nombre = $record->nombre;
		$this->porcentaje = $record->porcentaje;
        $this->codigo = $record->codigo;
		$this->emit('show-modal', 'show modal!');
	}

    public function Store()
	{
		$rules = [
			'nombre' => 'required',
            'porcentaje' => 'required|numeric',
            'codigo' => 'required|numeric'

		];

		$messages = [
			'nombre.required' => 'Nombre del impuesto es requerido',
            'porcentaje.required' => 'Porcentaje del impuesto es requerido',
            'codigo.required' => 'Codigo del impuesto es requerido',
			'porcentaje.numeric' => 'Porcentaje del impuesto es en decimal ejemplo 12.00',
			'codigo.numeric' => 'El codigo debe ser un número entero'
		];

		$this->validate($rules, $messages);

		$impuesto = Impuesto::create([
			'nombre' => $this->nombre,
            'porcentaje' => $this->porcentaje,
            'codigo' => $this->codigo,
		]);
		$this->resetUI();
		$this->emit('impuesto-added','Impuesto  Registrado');

	}

    public function Update()
	{
		$rules =[
			'nombre' => 'required',
            'porcentaje' => 'required|numeric',
            'codigo' => 'required|numeric'
		];

		$messages =[
			'nombre.required' => 'Nombre del impuesto es requerido',
            'porcentaje.required' => 'Porcentaje del impuesto es requerido',
            'codigo.required' => 'Codigo del impuesto es requerido',
			'porcentaje.numeric' => 'Porcentaje del impuesto es en decimal ejemplo 12.00',
			'codigo.numeric' => 'El codigo debe ser un número entero'
		];

		$this->validate($rules, $messages);


		$impuesto = Impuesto::find($this->selected_id);
		$impuesto->update([
			'nombre' => $this->nombre,
            'porcentaje' => $this->porcentaje,
            'codigo' => $this->codigo
		]);



		$this->resetUI();
		$this->emit('impuesto-updated', 'Impuesto  Actualizad0');
	}

    protected  $listeners = [
		'deleteRow' => 'Destroy'
	];

    public function Destroy (Impuesto $impuesto){

        $impuesto->delete();
        $this->resetUI();
        $this->emit('impuesto-deleted', 'Impuesto Eliminado');
    }
}
