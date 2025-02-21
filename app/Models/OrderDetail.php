<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $appends = [
        'product_name', 'user_name',
        'order_code', 'order_deadline_at',
    ];

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

    public function getOrderCodeAttribute()
    {
        return $this->order ? $this->order->code : '';
    }

    public function getOrderDeadlineAtAttribute()
    {
        return $this->order && $this->order->deadline_at ? date('Y-m-d', strtotime($this->order->deadline_at)) : '';
    }


    public function scopeSupplier($query)
    {
        //　発注済のみ
        $query->whereHas('order', function ($q)
        {
            return $q->where('orders.status', 1);
        });

        if (\Auth::user())
        {
            $query->where('user_id', \Auth::user()->id);
        }

        return $query;
    }
}
