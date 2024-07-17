<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Ramsey\Uuid\Uuid;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'email',
        'password',
        'referred_by',
        'balance',
        'stripe_customer_id',
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

    public static function boot()
    {
        parent::boot();
        static::creating(function (User $user) {
            $user->code = Uuid::uuid4();
        });
    }


    public function refer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(User::class, 'referred_by')->with('referrals');
    }

    public function directReferrals(): HasMany
    {
        return $this->hasMany(User::class, 'referred_by', 'id');
    }

    public function bonuses(): HasMany
    {
        return $this->hasMany(Bonus::class, 'sender_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'user_id');
    }
}
