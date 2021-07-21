<?php

namespace App\Rules\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Rule;

class productName implements Rule
{
    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        return Product::where('user_id', Auth::id())->where('name', $value)->count() == 0;
    }

    public function message()
    {
        return 'This product already exists.';
    }
}
