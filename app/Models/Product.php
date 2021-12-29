<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    // protected $table = 'products';

    protected $fillable = [
        'product_id', 
        'product_name', 
        'product_key', 
        'product_price', 
        'active',
        'catagory_id',
    ];    
}
