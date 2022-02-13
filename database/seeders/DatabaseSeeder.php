<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(DenominationSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ImpuestosSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(CompanyTableSeeder::class);
        $this->call(ClienteSeeder::class);
        $this->call(CajaTableSeeder::class);


    }
}
