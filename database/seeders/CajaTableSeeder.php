<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Caja;

class CajaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Caja::create([
            'direccion' => 'davila chica',
            'estab' => '001',
            'ptoEmi' => '001',
            'companie_id' => 1

        ]);
    }
}
