<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estimate extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $with = ['estimate_product'];

    public function estimate_product() : HasMany
    {
        return $this->hasMany(EstimateProduct::class)
            ->orderBy('seq')
            ->withOut('estimate');
    }


}
