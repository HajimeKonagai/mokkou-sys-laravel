<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $appends = [];

    public function order(): HasMany
    {
        return $this->hasMany(Order::class, )->without('project');
    }

    public function getTotalPriceAttribute()
    {
        $orders = $this->order()->without(['order'])->get();
        $total = 0;
        foreach ($orders as $order)
        {
            foreach ($order->detail as $detail)
            {
                $price = is_numeric($detail->price) ? $detail->price: 0;
                $quantity = is_numeric($detail->quantity) ? $detail->quantity: 0;
                $total += $price * $quantity;
            }
        }

        return $total;
    }
}
