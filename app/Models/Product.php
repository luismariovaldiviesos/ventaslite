<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	use HasFactory;

	protected $fillable = ['name','barcode','cost','price','stock','alerts','category_id'];


	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function ventas()
	{
		return $this->hasMany(SaleDetail::class);
	}

   // un producto puede tener varios impuestos
   public function impuestos(){

        return $this->belongsToMany(Impuesto::class,'impuesto_producto');
    }




	public function getPriceAttribute($value)
	{
		//comma por punto
		//return str_replace('.', ',', $value);
		// punto por coma
		return str_replace(',', '.', $value);
	}
	public function setPriceAttribute($value)
	{
        //$this->attributes['price'] = str_replace(',', '.', $value);
		$this->attributes['price'] =str_replace(',', '.', preg_replace( '/,/', '', $value, preg_match_all( '/,/', $value) - 1));

	}


}
