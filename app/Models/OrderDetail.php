<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $appends = ['product_name', 'user_name'];

    public function order() : BelongsTo
    {
        return $this->belongsTo(Order::class)->withOut('detail');
    }

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class)->withOut(['detail', 'order_detail']);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class)->withOut(['detail', 'order_detail']);
    }


    public function getProductNameAttribute()
    {
        return $this->product ? $this->product->name : '';
    }

    public function getUserNameAttribute()
    {
        return $this->user ? $this->user->name : '';
    }
}
