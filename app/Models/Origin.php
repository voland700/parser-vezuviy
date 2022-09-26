<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Origin extends Model
{
    protected $table = 'origins';
    protected $fillable = [
        'name',
        'code',
        'price',
    ];

}
