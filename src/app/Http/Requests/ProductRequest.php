<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'seasons' => 'required|array|min:1',
            'seasons.*' => 'exists:seasons,id',
            'description' => 'nullable|string|max:1000',
        ];
    }
}
