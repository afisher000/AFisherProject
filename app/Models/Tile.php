<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tile extends Model
{
    use HasFactory;
    protected $fillable = ['activity_id', 'athlete_id', 'discrete_lat', 'discrete_lng'];
}
