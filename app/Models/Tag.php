<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',
    ];

    public function products()
    {
        return $this->morphedByMany(Product::class, 'taggable');
    }

    public function orders()
    {
        return $this->morphedByMany(Order::class, 'taggable');
    }
}
