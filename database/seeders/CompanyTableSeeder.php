<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'name' => 'Ventas SOS',
            'ruc' => '0104649843001',
            'address' => 'davila chica',
            'phone' => '0987308688',
            'email'=> 'ventas@gmail.com'
        ]);
    }
}
