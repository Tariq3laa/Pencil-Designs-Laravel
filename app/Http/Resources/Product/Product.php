<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'price' => $this->price,
            'image' => $this->image_path,
            'description' => $this->description,
        ];
    }
}
