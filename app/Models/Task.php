<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected static function boot() 
    {
        parent::boot();
        static::deleting(function($model)
        {
            foreach ($model->task_material()->get() as $task_material)
            {
                $task_material->delete();
            }
        });
    }


    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $with = ['product', 'task_material'];

    public function project() : BelongsTo
    {
        return $this->belongsTo(Project::class)
            ->withOut('task');
    }

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class)
            ->withOut('task');
    }

    public function task_material() : HasMany
    {
        return $this->hasMany(TaskMaterial::class)
            ->orderBy('seq')
            ->withOut('task');
    }
}