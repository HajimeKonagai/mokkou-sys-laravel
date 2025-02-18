<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $with = ['user'];

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'product_user', 'user_id', 'product_id')->withOut('product');
    }
}
