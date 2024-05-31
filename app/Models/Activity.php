<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $attributes = [
        'name' => 'no name',
    ];

    protected $fillable = [
        'id',
        'athlete_id',
        'elapsed_time', 
        'total_elevation_gain', 
        'sport_type', 
        'start_date', 
        'start_lat', 
        'start_lng', 
        'average_speed', 
        'distance',
    ];

    public function getAthleteName() {
        if ($this->athlete_id === 2167889) {
            return 'Andrew';
        } else if ($this->athlete_id === 36706356) {
            return 'Travis';
        }

    }
}
