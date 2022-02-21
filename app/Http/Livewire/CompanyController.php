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
            'razonSocial' => 'required',
            'nombreComercial' => 'required',
            'ruc' => 'required|max:13',
            'estab' => 'required|max:3',
            'ptoEmi' => 'required|max:3',
            'dirMatriz' => 'required',
            'dirEstablecimiento' => 'required',
            'telefono' => 'required',
            'email' => "required|email|unique:companies,email,{$this->selected_id}",
            'ambiente' => 'required|max:1',
            'tipoEmision' => 'required|max:1',
            'contribuyenteEspecial' => 'required|max:13',
            'obligadoContabilidad' => 'required|max:2'

        ];

        $messages =[
            'razonSocial.required' => 'Ingrese la razón social de la empresa',
            'nombreComercial.required' => 'Ingrese el nombre comercial de la empresa',
            'estab.required' => 'Ingrese el código del establecimiento',
            'estab.max' => 'Código del establecimiento debe ser máximo 3  caracteres',
            'ruc.required' => 'Ingrese un ruc ',
            'ruc.max' => 'Ruc debe tener máximo 13 caracteres ',
            'ptoEmi.required' => 'Ingrese un punto de emisión ',
            'ptoEmi.max' => 'Punto emision  debe tener máximo 3 caracteres ',
            'dirMatriz.required' => 'Ingrese la direccion matriz',
            'dirEstablecimiento.required' => 'Ingrese la direccion de establecimiento',
            'telefono.required' => 'Ingrese el teléfono del establecimiento',
            'email.required' => 'Ingrese el correo ',
            'email.email' => 'Ingrese un correo válido',
            'ambiente.required' => 'Ingrese  el ambiente del sistema',
            'ambiente.max' => 'El ambiente debe ser de un solo caracter',
            'tipoEmision.required' => 'Ingrese  el tipo de emision',
            'tipoEmision.max' => 'El tipo de emisión debe ser de un solo caracter',
            'contribuyenteEspecial.required' => 'Ingrese si es contribuyente especial',
            'contribuyenteEspecial.max' => 'El codigo contribuyente especial debe tener máximo 13 caracteres',
            'obligadoContabilidad.required' => 'Campo requerido',
            'obligadoContabilidad.max' => 'El campo debe tener máximo 2 caracteres',


        ];

        $this->validate($rules, $messages);

       // DB::table('clinicas')->truncate(); // eliminando la info de la tabla
       $empresa = Company::find($this->selected_id);
       //dd($clinica);
        $empresa->update([
            'razonSocial' => $this->razonSocial,
            'nombreComercial' => $this->nombreComercial,
            'ruc' => $this->ruc,
            'estab' => $this->estab,
            'ptoEmi' => $this->ptoEmi,
            'dirMatriz' => $this->dirMatriz,
            'dirEstablecimiento' => $this->dirEstablecimiento,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'ambiente' => $this->ambiente,
            'tipoEmision' => $this->tipoEmision,
            'contribuyenteEspecial' => $this->contribuyenteEspecial,
            'obligadoContabilidad' => $this->obligadoContabilidad
        ]);
         $this->emit('empresa-added','Datos de Empresa guardado correctamente');

    }
}
