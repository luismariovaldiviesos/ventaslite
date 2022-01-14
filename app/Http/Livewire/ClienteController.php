<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Cliente;

class ClienteController extends Component
{

    use WithPagination;

    public $nombre,$ruc,$telefono,$direccion,$email,$selected_id;
    public $pageTitle, $componentName, $search;
    private $pagination = 10;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle ='Listado';
        $this->componentName ='Clientes';
        $this->status ='Elegir';
    }




    public function render()
    {
        if(strlen($this->search) > 0)
        $data = Cliente::where('nombre', 'like', '%' . $this->search . '%')
                ->select('*')->orderBy('id','asc')->paginate($this->pagination);
    else
       $data = Cliente::select('*')->orderBy('id','asc')->paginate($this->pagination);
        return view('livewire.cliente.component', [
            'data' => $data
            ]
        )->extends('layouts.theme.app')
        ->section('content');;
    }

    public function resetUI()
    {
        $this->nombre ='';
        $this->ruc ='';
        $this->direccion ='';
        $this->telefono ='';
        $this->email='';
        $this->search ='';
        $this->status ='Elegir';
        $this->selected_id =0;
        $this->resetValidation();
        $this->resetPage();
    }

    public function edit(Cliente $cliente)
    {
        $this->selected_id = $cliente->id;
        $this->nombre = $cliente->nombre;
        $this->ruc = $cliente->ruc;
        $this->telefono = $cliente->telefono;
        $this->direccion = $cliente->direccion;
        $this->email = $cliente->email;
        $this->emit('show-modal','open!');

    }

    protected $listeners =[
        'deleteRow' => 'destroy',
        'resetUI' => 'resetUI'
    ];

    public function Store()
    {

        $rules =[
            'nombre' => 'required|min:3',
            'ruc' => 'required|unique:clientes',
            'telefono' => 'required',
            'email' => 'unique:clientes|email'
        ];

        $messages =[
            'nombre.required' => 'Ingresa el nombre del cliente',
            'nombre.min' => 'El nombre del cliente debe tener al menos 3 caracteres',
            'ruc.required' => 'Ingresa ruc o cédula del cliente',
            'ruc.unique' => 'El Ruc o Cedula ya existe en el sistema',
            'telefono.required' => 'Teléfono del cliente es requerido'
        ];
        $this->validate($rules, $messages);
        $cliente = Cliente::create([
            'nombre' => $this->nombre,
            'ruc' => $this->ruc,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'email' => $this->email
        ]);

        $this->resetUI();
        $this->emit('cliente-added','Usuario Registrado');
    }

    public function Update()
    {

        $rules =[
            'email' => "unique:clientes,email,{$this->selected_id}",
            'nombre' => 'required|min:3',
            'telefono' => 'required',
            'ruc' => "unique:clientes,ruc,{$this->selected_id}",

        ];

        $messages =[
            'nombre.required' => 'Ingresa el nombre',
            'nombre.min' => 'El nombre del usuario debe tener al menos 3 caracteres',
            'email.unique' => 'El email ya existe en sistema',
            'ruc.unique' => 'El ruc-cedula ya existe en sistema',
            'telefono.required' => 'Ingresa el telefono'


        ];

        $this->validate($rules, $messages);

        $cliente = Cliente::find($this->selected_id);
        //dd($cliente);
        $cliente->update([
            'nombre' => $this->nombre,
            'ruc' => $this->ruc,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'email' => $this->email
        ]);
        $this->resetUI();
        $this->emit('cliente-updated','Usuario Actualizado');

    }

    public function destroy(Cliente $cliente)
    {
       $cliente->delete();
       $this->resetUI();
    	$this->emit('cliente-deleted', 'Cliente  Eliminado');
    }

}
