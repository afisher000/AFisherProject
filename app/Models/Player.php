<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Game;

class Player extends Model
{
    use HasFactory;
    protected $fillable = ['alias', 'fullname', 'is_active'];

    // HELPER FUNCTIONS FOR STATISTICS
    public function computeWinPct($filters = []) {
        $player_id = $this->id;

        // Apply filters
        $query = Game::query();
        foreach( $filters as $filter) {
            if ($filter ==='red') {
                $query->where('color', 'red');
            }
            if ($filter ==='blue') {
                $query->where('color', 'blue');
            }
            if ($filter ==='tenzero') {
                $query->where('score', 0);
            }
            if ($filter ==='offense') {
                $query->where(function($query) use ($player_id) {
                    $query->where('WO', $player_id)
                        ->orWhere('LO', $player_id);
                });
            }
            if ($filter ==='defense') {
                $query->where(function($query) use ($player_id) {
                    $query->where('WD', $player_id)
                        ->orWhere('LD', $player_id);
                });
            }
        }
        $filteredGames = $query->get();

        # Compute statistics
        
        $wins = $filteredGames->where('WO', $player_id)->count() + $filteredGames->where('WD', $player_id)->count();
        $losses =$filteredGames->where('LO', $player_id)->count() + $filteredGames->where('LD', $player_id)->count();

        if (($wins+$losses)>0) {
            $winpct = number_format( $wins/($wins+$losses)*100, 1);
        } else {
            $winpct = -1;
        }       

        return compact('wins', 'losses', 'winpct');
    }

    public function marginOfVictory($filters = []) {
        $player_id = $this->player_id;

        // Apply filters
        $query = Game::query();
        foreach( $filters as $filter) {
            if ($filter ==='red') {
                $query->where('color', 'r');
            }
            if ($filter ==='blue') {
                $query->where('color', 'b');
            }
        }
        $filteredGames = $query->get();

        $margins = range(-10,10);
        $counts = [];
        foreach ($margins as $margin) {
            if ($margin<0) {
                $score = 10 + $margin;

                $query = $filteredGames->where('score', $score)->toQuery();
                $counts[] = $query->where(function($query) use ($player_id) {
                    $query->where('LO', $player_id)->orWhere('LD', $player_id);
                })->count();

            } else if ($margin>0) {
                $score = 10 - $margin;

                $query = $filteredGames->where('score', $score)->toQuery();
                $counts[] = $query->where(function($query) use ($player_id) {
                    $query->where('WO', $player_id)->orWhere('WD', $player_id);
                })->count();
            } else {
                $counts[] = 0;
            }
        }
        return ['margins'=>$margins, 'counts'=>$counts];

    }



}
