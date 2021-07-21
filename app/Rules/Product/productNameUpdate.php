<?php

namespace App\Rules\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Rule;

class productNameUpdate implements Rule
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function passes($attribute, $value)
    {
        return Product::where('id', '!=', $this->id)->where('user_id', Auth::id())->where('name', $value)->count() == 0;
    }

    public function message()
    {
        return 'This product already exists.';
    }
}
