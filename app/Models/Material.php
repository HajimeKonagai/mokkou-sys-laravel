<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Material extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $with = ['user', 'pricing'];
    protected $appends = ['user_price'];

    public function pricing(): HasMany
    {
        return $this->hasMany(Pricing::class)->withOut('material');
    }

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class, Pricing::class, 'material_id', 'user_id')->withOut('material');
    }

    public function getUserPriceAttribute()
    {
        if (request()->has('user_id'))
        {
            $pricing = $this->pricing()->where('user_id', request()->input('user_id'))->first();
            if ($pricing) return $pricing->price;
        }

        return false;
    }
}
