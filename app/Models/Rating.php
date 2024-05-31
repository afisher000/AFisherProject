<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Game;

class Rating extends Model
{
    use HasFactory;
    protected $fillable = ['game_id', 'player_id', 'offense', 'defense'];


}
