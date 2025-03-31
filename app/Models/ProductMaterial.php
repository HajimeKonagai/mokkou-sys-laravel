<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductMaterial extends Model
{
    protected $with = ['material', 'product'];
    protected $appends = ['material_name', 'product_name'];

    public function material() : BelongsTo
    {
        return $this->belongsTo(Material::class)->withOut('product_material');
    }

    public function product() : BelongsTo
    {
        return $this->belongsTo(User::class)->withOut('product_material');
    }

    public function getMaterialNameAttribute()
    {
        return $this->material ? $this->material->name: '';
    }

    public function getProductNameAttribute()
    {
        return $this->user ? $this->user->name: '';
    }
}
