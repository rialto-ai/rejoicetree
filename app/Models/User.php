<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'image',
        'password',
        'provider',
        'provider_id',
        'email_verified_at',
        'littlelink_name',
        'rejoice_role',
        'organization_name',
        'organization_type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function visits()
    {
        return visits($this)->relation();
    }

    public function socialAccounts()
    {
        return $this->hasMany(SocialAccount::class);
    }

    public function creatorProfile()
    {
        return $this->hasOne(CreatorProfile::class);
    }

    /**
     * Get the Rejoice profile, creating an empty one on demand so callers can
     * safely read/write profile fields for any user.
     */
    public function profile(): CreatorProfile
    {
        return $this->creatorProfile()->firstOrCreate(['user_id' => $this->id]);
    }

    /**
     * Whether this user can access the Rejoice admin / review tooling. The
     * core LinkStack admin role is always allowed.
     */
    public function isRejoiceReviewer(): bool
    {
        if (($this->role ?? '') === 'admin') {
            return true;
        }

        return in_array($this->rejoice_role, config('rejoice.admin_roles', []), true);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (config('linkstack.disable_random_user_ids') != 'true') {
                if (is_null(User::first())) {
                    $user->id = 1;
                } else {
                    $numberOfDigits = config('linkstack.user_id_length') ?? 6;
    
                    $minIdValue = 10**($numberOfDigits - 1);
                    $maxIdValue = 10**$numberOfDigits - 1;
    
                    do {
                        $randomId = rand($minIdValue, $maxIdValue);
                    } while (User::find($randomId));
    
                    $user->id = $randomId;
                }
            }
        });
    }
}
