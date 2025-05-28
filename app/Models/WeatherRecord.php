<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherRecord extends Model
{
    use HasFactory;

    protected $table = 'weather_records';

    protected $fillable = [
        'city_name',
        'weather_data',
        'consulted_at',
    ];

    protected $casts = [
        'weather_data' => 'array',
        'consulted_at' => 'datetime',
    ];
}
