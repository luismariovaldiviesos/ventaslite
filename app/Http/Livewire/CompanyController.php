<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\Company;
use Livewire\Component;

class CompanyController extends Component
{
    public $name, $address, $phone, $ruc, $email, $selected_id;

    public  function  mount()
    {
        $empresa = Company::all();

        if ($empresa->count()> 0)
        {
           $this->selected_id = $empresa[0]->id;
            $this->name = $empresa[0]->nombreComercial;
            $this->address = $empresa[0]->address;
            $this->phone = $empresa[0]->phone;
            $this->ruc = $empresa[0]->ruc;
            $this->email = $empresa[0]->email;

        }

    }
    public function render()
    {

        return view('livewire.company.component')->extends('layouts.theme.app')
        ->section('content');
    }


    public function Guardar()
    {
       // $this->selected_id = $this->id;
      //    dd($this->imagen);
        $rules = [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'ruc' => 'required',
            'email' => "required|email|unique:companies,email,{$this->selected_id}"

        ];

        $messages =[
            'name.required' => 'Ingresa el nombre',
            'address.required' => 'Ingresa una direccion ',
            'phone.required' => 'Ingresa un telefono ',
            'ruc.required' => 'Ingresa un ruc ',
            'email.required' => 'Ingresa el correo ',
            'email.email' => 'Ingresa un correo válido',
        ];

        $this->validate($rules, $messages);

       // DB::table('clinicas')->truncate(); // eliminando la info de la tabla
       $empresa = Company::find($this->selected_id);
       //dd($clinica);
        $empresa->update([
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
            'ruc' => $this->ruc,
            'email' => $this->email
        ]);

         $this->emit('empresa-added','Datos de Empresa guardado correctamente');

    }
}
