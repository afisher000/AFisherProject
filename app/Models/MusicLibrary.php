<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MusicLibrary extends Model
{
    use HasFactory;
    protected $fillable = ['artist', 'name'];
}
