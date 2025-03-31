<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'staff',
        'address',
        'email',
        'password',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['material_price'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function scopeSupplier($query)
    {
        $query->where('is_admin', false);
    }

    public function pricing(): HasMany
    {
        return $this->hasMany(Pricing::class);
    }

    public function material(): BelongsToMany
    {
        return $this->belongsToMany(Material::class, Pricing::class, 'user_id', 'material_id')->withOut('user');
    }

    public function getMaterialPriceAttribute()
    {
        if (request()->has('material_id'))
        {
            $pricing = $this->pricing()->where('material_id', request()->input('material_id'))->first();
            if ($pricing) return $pricing->price;
        }

        return false;
    }
}
