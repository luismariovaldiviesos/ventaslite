<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Denomination;

class DenominationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Denomination::create([
        	'type' => 'BILLETE',
        	'value' => 100.00
        ]);
         Denomination::create([
        	'type' => 'BILLETE',
        	'value' => 50.00
        ]);
          Denomination::create([
        	'type' => 'BILLETE',
        	'value' => 20.00
        ]);
           Denomination::create([
        	'type' => 'BILLETE',
        	'value' => 10.00
        ]);
            Denomination::create([
        	'type' => 'BILLETE',
        	'value' => 5.00
        ]);
             Denomination::create([
        	'type' => 'BILLETE',
        	'value' => 1.00
        ]);
        Denomination::create([
        	'type' => 'MONEDA',
        	'value' => 1.00
        ]);
              Denomination::create([
        	'type' => 'MONEDA',
        	'value' => 0.50
        ]);
              Denomination::create([
        	'type' => 'MONEDA',
        	'value' => 0.25
        ]);
              Denomination::create([
        	'type' => 'MONEDA',
        	'value' => 0.10
        ]);
              Denomination::create([
        	'type' => 'MONEDA',
        	'value' => 0.5
        ]);
              Denomination::create([
        	'type' => 'MONEDA',
        	'value' => 0.01
        ]);
              Denomination::create([
        	'type' => 'OTRO',
        	'value' => 0
        ]);
    }
}
