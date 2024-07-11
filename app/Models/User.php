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
use OpenApi\Attributes as OA;

#[
    OA\Schema(
        title: "User",
        description: "User model",
        required: ["last_name", "first_name", "email", "password"],
        properties: [
            new OA\Property(property: "last_name", description: "Last name of the user", type: "string"),
            new OA\Property(property: "first_name", description: "First name of the user", type: "string"),
            new OA\Property(property: "middle_names", description: "Middle names of the user", type: "string"),
            new OA\Property(property: "avatar", description: "Avatar of the user", type: "string"),
            new OA\Property(property: "gender", description: "Gender of the user", type: "string"),
            new OA\Property(property: "email", description: "Email of the user", type: "string"),
            new OA\Property(property: "password", description: "Password of the user", type: "string"),
            new OA\Property(property: "birth_date", description: "Birth date of the user", type: "string"),
        ],
        type: "object",
        example: [
            "last_name" => "Doe",
            "first_name" => "John",
            "middle_names" => "Smith",
            "avatar" => "https://example.com/avatar.jpg",
            "gender" => "Male",
            "email" => "exampel@mail.com",
            "password" => "password",
            "birth_date" => "1990-01-01",
            "addresses" => [],
            "number_phones" => [],
            "email_verified_at" => "2021-01-01",
            "created_at" => "2021-01-01",
            "updated_at" => "2021-01-01",
            "role" => []
        ],

    )
]
class User extends Authenticatable
{
    use HasApiTokens,
        HasFactory,
        Notifiable,
        HasRoles,
        SoftDeletes,
        Searchable;

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
}
