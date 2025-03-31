<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pricing extends Model
{

    protected $with = ['material', 'user'];
    protected $appends = ['material_name', 'user_name'];

    public function material() : BelongsTo
    {
        return $this->belongsTo(Material::class)->withOut('pricing');
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class)->withOut('pricing');
    }

    public function getMaterialNameAttribute()
    {
        return $this->material ? $this->material->name: '';
    }

    public function getUserNameAttribute()
    {
        return $this->user ? $this->user->name: '';
    }
}
