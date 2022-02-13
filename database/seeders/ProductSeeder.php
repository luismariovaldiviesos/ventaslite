<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
        	'name' => 'taco bajo mujer',
        	'cost' => 40,
        	'price' => 50,
        	'barcode' => '1',
        	'stock' => 25,
        	'alerts' => 10,
        	'category_id' => 1,
            'impuesto_id' => 1
        ]);
    }
}
