<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\RolesEnum;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\Features;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, HasRoles, HasSlug, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
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
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $appends = [
        'two_factor_enabled',
    ];

    public function getTwoFactorEnabledAttribute(): bool
    {
        return Features::enabled(Features::twoFactorAuthentication())
            && $this->hasAttribute('two_factor_secret')
            && $this->two_factor_secret !== null;
    }

    public function createProfilePhotoUrl(): string
    {
        $firstCharacter = $this->email[0];

        $integerToUse = is_numeric($firstCharacter)
            ? ord(mb_strtolower($firstCharacter)) - 21
            : ord(mb_strtolower($firstCharacter)) - 96;

        return 'https://www.gravatar.com/avatar/'
            . md5($this->email)
            . '?s=200&d=https://s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-'
            . $integerToUse
            . '.png';
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function services(): HasMany
    {
        return $this->hasMany(EmployeeService::class, 'employee_id', 'id');
    }

    public function schedule(): HasOne
    {
        return $this->hasOne(Schedule::class, 'employee_id', 'id');
    }

    public function exclusions(): HasMany
    {
        return $this->hasMany(WorkBreak::class, 'break_id', 'id');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function scopeEmployee($query)
    {
        return $query->whereHas('roles', function ($query): void {
            $query->where('name', RolesEnum::Employee->value);
        });
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

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
}
