<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'email',
        'password',
        'household_id',
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

    public function household()
    {
        return $this->belongsTo(Household::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function categories()
    {
        if ($this->household_id) {
            return Category::where('household_id', $this->household_id);
        }
        return Category::whereRaw('0 = 1'); // Return empty query
    }

    public function stores()
    {
        if ($this->household_id) {
            return Store::where('household_id', $this->household_id);
        }
        return Store::whereRaw('0 = 1'); // Return empty query
    }

    public function setting()
    {
        if ($this->household_id) {
            return $this->hasOneThrough(
                Setting::class,
                Household::class,
                'id', // Foreign key on households table
                'household_id', // Foreign key on settings table
                'household_id', // Local key on users table
                'id' // Local key on households table
            );
        }
        return $this->hasOne(Setting::class)->whereRaw('0 = 1'); // Return empty relation
    }
}
