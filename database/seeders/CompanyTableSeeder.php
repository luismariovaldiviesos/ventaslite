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
            'razonSocial' => 'Khipu Desarrollo de Software',
            'nombreComercial' => 'Khipu Desarrollo de Software',
            'ruc' => '0104649843001',
            'address' => 'Dávila Chica y MAnuel Moreno',
            'phone' => '0987308688',
            'email'=> 'khipusistemas@gmail.com'
        ]);
    }
}
