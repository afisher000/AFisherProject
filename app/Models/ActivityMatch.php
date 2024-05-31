<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityMatch extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'activity_id1',
        'activity_id2',
    ];
}
