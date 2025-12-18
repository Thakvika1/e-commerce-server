<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class CartItem extends Model
{

    protected $fillable = ['cart_id', 'product_id', 'qty', 'price'];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
