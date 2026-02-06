<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'description', 'image'];

    protected $casts = [
        'price' => 'integer',
    ];

    public function getImageUrlAttribute()
    {
        // 1. アップロード画像優先（storage内）
        if ($this->image) {
            return Storage::disk('public')->url($this->image);
        }
        // 2. public/image/内の静的画像（英語名で検索）
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