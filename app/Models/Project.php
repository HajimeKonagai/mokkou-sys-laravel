<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $appends = ['total_price'];

    public function task() : HasMany
    {
        return $this->hasMany(Task::class)
            ->orderBy('seq')
            ->withOut('project');
    }

    public function order(): HasMany
    {
        return $this->hasMany(Order::class, )->without('project');
    }

    public function getTotalPriceAttribute()
    {
        $tasks = $this->task()->without(['order'])->get();
        $total = 0;
        foreach ($tasks as $task)
        {
            $price = is_numeric($task->price) ? $task->price: 0;
            $quantity = is_numeric($task->quantity) ? $task->quantity: 0;
            $total += $price * $quantity;
        }

        return $total;
    }
}
