<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cliente::create([
            'nombre' => 'Pedro Guerra',
            'ruc' => '010104649843',
            'telefono' => '088888879',
            'direccion' => 'Centro',
            'email' => 'pedro@mail'
        ]);
        Cliente::create([
            'nombre' => 'Silvio Rodriguez',
            'ruc' => '010104649844',
            'telefono' => '088888879',
            'direccion' => 'Sur',
            'email' => 'silvio@mail'
        ]);

        Cliente::create([
            'nombre' => 'Victor jara',
            'ruc' => '010104649845',
            'telefono' => '088888879',
            'direccion' => 'Norte',
            'email' => 'victor@mail'
        ]);
    }
    }

