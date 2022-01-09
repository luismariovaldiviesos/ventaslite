<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Illuminate\Validation\Rule;

class ProductsImport implements ToModel, WithHeadingRow,  WithValidation, SkipsOnError
{
    use SkipsErrors;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Product([
            'name'            => $row['nombre'],
            'barcode'         => $row['codigo'],
            'cost'            => $row['costo'],
            'price'           => $row['precio'],
            'stock'           => $row['stock'],
            'alerts'          => $row['alerts'],
            'image'           => '',
            'category_id'     => Category::where('name', $row['categoria'])->first()->id,
        ]);
    }

    //encabezados del archivo excel
    public function rules(): array
    {
        return [
            'name' => Rule::unique('products', 'name'),
        ];
    }
}
