<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tula extends Model
{
    protected $table = 'tulas';
    protected $fillable = [
        'product_id',
        'active',
        'name',
        'code',
        'price',
    ];
}
