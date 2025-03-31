<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EstimateProduct extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $with = ['product', 'product_material'];
    protected $appends = ['product_name'];

    public function product_material() : HasMany
    {
        return $this->hasMany(EstimateProductMaterial::class)->withOut('product', 'estimate_product');
    }

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class)->withOut('product', 'estimate_product');
    }



    public function getProductNameAttribute()
    {
        return $this->product ? $this->product->name : '';
    }
}
