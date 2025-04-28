<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EstimateProductMaterial extends Model
{
    //

    protected $with = ['material'];

    protected $appends = ['material_name'];

    public function material() : BelongsTo
    {
        return $this->belongsTo(Material::class)->withOut('estimate_product_material');
    }

    public function getMaterialNameAttribute()
    {
        return $this->material ? $this->material->name : '';
    }
}
