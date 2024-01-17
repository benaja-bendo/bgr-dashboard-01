<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'street',
        'number',
        'complement',
        'city',
        'zipcode',
        'country',
    ];

    public function user() :belongsTo
    {
        return $this->belongsTo(User::class);
    }
}
