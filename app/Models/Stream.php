<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    use HasFactory;
    protected $fillable = ['activity_id', 'time', 'distance', 'ele', 'lat', 'lon', 'cad', 'hr'];
}
