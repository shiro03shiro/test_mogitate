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
        if ($this->image) {
            return Storage::disk('public')->url($this->image);
        }
        $englishNames = [
            'キウイ' => 'kiwi', 'ストロベリー' => 'strawberry', 'オレンジ' => 'orange',
            'スイカ' => 'watermelon', 'ピーチ' => 'peach', 'シャインマスカット' => 'muscat',
            'パイナップル' => 'pineapple', 'ブドウ' => 'grapes', 'バナナ' => 'banana',
            'メロン' => 'melon'
        ];

        $imageName = $englishNames[$this->name] ?? 'default';
        return asset("image/{$imageName}.jpg");
    }
}