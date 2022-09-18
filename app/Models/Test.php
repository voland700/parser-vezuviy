<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;
    protected $table = 'tests';
    protected $fillable = [
            'link',
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

    public function getPropertiesAttribute()
    {
        return ($this->options) ? json_decode($this->options, true) : null;
    }
}
