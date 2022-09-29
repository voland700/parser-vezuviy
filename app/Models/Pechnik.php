<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Pechnik extends Model
{
    protected $table = 'pechniks';
    protected $fillable = [
        'product_id',
        'active',
        'name',
        'code',
        'price',
    ];
}
