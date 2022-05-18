<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';
    
    protected $fillable = [ 
        'client_id',
        'value_pay'
    ];

    protected $casts = [
        'created_at'    =>'datetime:Y-m-d H:i:s',
        'updated_at'    =>'datetime:Y-m-d H:i:s'
    ];
}
