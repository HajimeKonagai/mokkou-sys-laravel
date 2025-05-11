<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $with = ['product_material'];

    public function product_material(): HasMany
    {
        return $this->hasMany(ProductMaterial::class)
            ->orderBy('seq')
            ->withOut('product');
    }
}
