<?php

namespace App\Models;

use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function getImagePathAttribute($value)
    {
        return URL::to('/') . (str_replace('public', '/storage', $this->image));
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
