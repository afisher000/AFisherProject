<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'athlete_id',
    ];
}
