<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return Storage::disk('public')->url($this->image);
        }
        // 2. public/image/内の静的画像（英語名で検索）
        $englishNames = [
            'キウイ' => 'kiwi', 'ストロベリー' => 'strawberry', 'オレンジ' => 'orange',
            'スイカ' => 'watermelon', 'ピーチ' => 'peach', 'シャインマスカット' => 'muscat',
            'パイナップル' => 'pineapple', 'ブドウ' => 'grapes', 'バナナ' => 'banana',
            'メロン' => 'melon'
        ];

        $imageName = $englishNames[$this->name] ?? strtolower(str_replace([' ', '　'], '', $this->name));
        $imagePath = "image/{$imageName}.jpg";

        if (file_exists(public_path($imagePath))) {
            return asset($imagePath);
        }

        // 3. デフォルト画像
        return asset('image/default.jpg');
    }
}
