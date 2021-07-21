<?php

namespace App\Http\Requests\Product;

use App\Rules\Product\productName;
use App\Rules\Product\productNameUpdate;
use Illuminate\Foundation\Http\FormRequest;

class Product extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'name'              => ['required', 'string', 'min:3', 'max:255', new productName()],
                    'price'             => 'required|numeric|min:1',
                    'description'       => 'required|string|min:3|max:700',
                    'image'             => 'required|image|mimes:jpg,png,jpeg'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name'              => ['required', 'string', 'min:3', 'max:255', new productNameUpdate($this->product->id)],
                    'price'             => 'required|numeric|min:1',
                    'description'       => 'required|string|min:3|max:700',
                    'image'             => 'nullable|image|mimes:jpg,png,jpeg'
                ];
            }
            default:break;
        }
    }
}
