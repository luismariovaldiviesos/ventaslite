<?php

namespace App\Http\Livewire;

use App\Imports\CategoriesImport;
use App\Imports\ProductsImport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Category;
use App\Models\Product;

class ImportController extends Component
{
    use WithFileUploads;

    public $contCategories, $contProducts, $fileCategories, $fileProducts;

    public function render()
    {
        return view('livewire.import.component')
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function uploadCategories()
    {
        $this->validate([
            'fileCategories' => 'required|mimes:xlsx,xls'
        ]);
        $cantBefore = Category::count();
        $import = new CategoriesImport();
        Excel::import($import, $this->fileCategories);
        //$this->contCategories = $import->getRowCount();
        $this->fileCategories = '';
        $cantAfter = Category::count() - $cantBefore;
        $this->emit('global-msg', "SE IMPORTARON  $cantAfter CATEGORÍAS");
    }

    public function uploadProducts()
    {
        $this->validate([
            'fileProducts' => 'required|mimes:xlsx,xls'
        ]);
        $cantBefore = Product::count();
        $import = new ProductsImport();
        Excel::import($import, $this->fileProducts);
        //$this->contProducts = $import->getRowCount();
        $this->fileProducts = '';
        $cantAfter = Product::count() - $cantBefore;
        $this->emit('global-msg', "SE IMPORTARON  $cantAfter PRODUCTOS");
    }
}
