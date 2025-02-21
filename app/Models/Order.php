<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    // protected $with = ['detail', 'detail.user'];
    protected $appends = ['code', 'project_name', 'status_text'];



    /*
    protected $casts = [
        'ordered_at' => 'date:Y-m-d',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    */

    public function project() : BelongsTo
    {
        return $this->belongsTo(Project::class)->withOut('order');
    }

    public function detail() : HasMany
    {
        return $this->hasMany(OrderDetail::class)->withOut('order');
    }


    public function getCodeAttribute()
    //public function getCodeAttribute()
    {
        return config('mokkou.order_id_prefix').str_pad($this->id, config('mokkou.order_id_pad'), '0', STR_PAD_LEFT);
    }

    public function getProjectNameAttribute()
    //public function getCodeAttribute()
    {
        return $this->project ? $this->project->name : '';
    }

    public function getStatusTextAttribute()
    //public function getCodeAttribute()
    {
        $status = config('mokkou.order_status.'.$this->status);
        return $status ? $status: '';
    }
}
