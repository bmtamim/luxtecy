<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_token',
        'name',
        'phone',
        'address',
        'address_details',
        'latitude',
        'longitude',
        'postal_code',
    ];
}
