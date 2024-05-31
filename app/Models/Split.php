<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Split extends Model
{
    use HasFactory;
    protected $attributes = [
        'hr' => 0,
    ];
    protected $fillable = ['activity_id', 'athlete_id', 'split', 'speed', 'grade', 'lat', 'lng', 'hr', 'altitude'];
}
