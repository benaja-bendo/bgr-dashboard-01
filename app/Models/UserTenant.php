<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;
use Spatie\Permission\Traits\HasRoles;

class UserTenant extends Authenticatable
{
    use HasApiTokens,
        HasFactory,
        Notifiable,
        HasRoles,
        SoftDeletes,
        Searchable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'last_name',
        'first_name',
        'middle_names',
        'avatar',
        'gender',
        'email',
        'password',
        'birth_date',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function numberPhone(): HasMany
    {
        return $this->hasMany(NumberPhone::class, 'user_id');
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class, 'user_id');
    }

    public function studentInfos(): HasOne
    {
        return $this->hasOne(StudentInfo::class);
    }

    /**
     * Obtenez les événements du calendrier associés à l'UserTenant.
     *
     * @return HasMany
     */
    public function calendarEvents(): HasMany
    {
        return $this->hasMany(CalendarEvent::class, 'user_id');
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'middle_names' => $this->middle_names,
            'email' => $this->email,
            'birth_date' => $this->birth_date,
            'gender' => $this->gender,
        ];
    }

    public function searchableAs(): string
    {
        return 'tenant_' . tenant('id') . '_users';
    }
}
