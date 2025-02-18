<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    // protected $with = ['detail', 'detail.user'];

    /*
    protected $casts = [
        'ordered_at' => 'date:Y-m-d',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    */

    public function detail() : HasMany
    {
        return $this->hasMany(OrderDetail::class)->withOut('order');
    }
}
