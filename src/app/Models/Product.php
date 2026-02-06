<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'image', 'description'];

    protected $casts = [
        'price' => 'integer',
    ];

    public function seasons()
    {
        return $this->belongsToMany(Season::class, 'product_season');
    }

    public function getImageUrlAttribute()
    {
        $imageNames = [
            'kiwi.png',
            'strawberry.png',
            'orange.png',
            'watermelon.png',
            'peach.png',
            'muscat.png',
            'pineapple.png',
            'grapes.png',
            'banana.png',
            'melon.png'
        ];
        $index = ($this->id - 1) % 10;
        return asset("images/products/{$imageNames[$index]}");
    }
}