<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'delivery_info',
        'description',
        'unit_type',
        'unit',
        'fee',
        'rules',
        'status',
        'position',
    ];

    protected $casts = [
        'rules' => 'array'
    ];
}
