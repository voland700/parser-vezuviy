<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Temporary extends Model
{
    protected $table = 'temporaries';
    protected $fillable = [
        'product_id',
        'active',
        'name',
        'code',
        'price',
    ];
}
