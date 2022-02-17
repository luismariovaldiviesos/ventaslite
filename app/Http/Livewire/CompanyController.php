<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\Company;
use Livewire\Component;

class CompanyController extends Component
{
    public $razonSocial, $nombreComercial, $ruc,$estab,$ptoEmi,$dirMatriz,$dirEstablecimiento,
         $telefono, $email, $ambiente,$tipoEmision,$contribuyenteEspecial,$obligadoContabilidad, $selected_id;

    public  function  mount()
    {
        $empresa = Company::all();

        if ($empresa->count()> 0)
        {
           $this->selected_id = $empresa[0]->id;
            $this->razonSocial = $empresa[0]->razonSocial;
            $this->nombreComercial = $empresa[0]->nombreComercial;
            $this->ruc = $empresa[0]->ruc;
            $this->estab = $empresa[0]->estab;
            $this->ptoEmi = $empresa[0]->ptoEmi;
            $this->dirMatriz = $empresa[0]->dirMatriz;
            $this->dirEstablecimiento = $empresa[0]->dirEstablecimiento;
            $this->telefono = $empresa[0]->telefono;
            $this->email = $empresa[0]->email;
            $this->ambiente = $empresa[0]->ambiente;
            $this->tipoEmision = $empresa[0]->tipoEmision;
            $this->contribuyenteEspecial = $empresa[0]->contribuyenteEspecial;
            $this->obligadoContabilidad = $empresa[0]->obligadoContabilidad;
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
