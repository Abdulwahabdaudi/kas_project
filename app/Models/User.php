<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    
    const ROLE_USER = 0;
    const ROLE_ADMIN = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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


    // Define role accessor
    protected function role(): Attribute
    {
        return new Attribute(
            get: fn($value) => ['user', 'admin'][$value] ?? 'user',
        );
    }

    // Check if the user is an admin
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }
        
    


    public function products() :BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }
    public function createdOrders()
    {
        return $this->hasMany(Order::class, 'created_by');
    }

}
