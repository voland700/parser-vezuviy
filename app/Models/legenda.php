<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class legenda extends Model
{
    protected $table = 'legendas';
    protected $fillable = [
        'product_id',
        'active',
        'name',
        'code',
        'price',
    ];
}
