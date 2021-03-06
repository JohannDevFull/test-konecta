<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    
    protected $fillable = [ 
        'name',
        'ref',
        'unitary_value', 
        'weight',
        'fk_category_id', 
        'stock'
    ];

    protected $casts = [
        'created_at'    =>'datetime:Y-m-d H:i:s',
        'updated_at'    =>'datetime:Y-m-d H:i:s'
    ];
}
