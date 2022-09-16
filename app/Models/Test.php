<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;
    protected $table = 'tests';
    protected $fillable = [
            'name',
            'categories',
            'category',
            'artNamber',
            'image',
            'more',
            'price',
            'description',
            'options',
            'documentation',
            'video',
            'allowed',
    ];





}
