<?php

namespace App\Livewire\Foosball;

use App\Models\Game;
use App\Models\Player;
use App\Models\Rating;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class PlayerRatingChanges extends Component
{
    public $player;
    public $color = 'all';
    public $side = 'all';
    public $outcome = 'all';

    public function render()
    {
        $this->dispatch('refreshJS', $this->getRatingChanges());
        return view('livewire.foosball.player-rating-changes');
    }

    public function refresh() {
        return;
    }

    public function getRatingChanges() {
        $player_id = Player::where('alias', $this->player)->value('id');

        // Get subtable from player perspective for easier filtering
        $gameSub = DB::table('games')->select('id','date', 'score', 
        DB::raw('CASE WHEN WO='.$player_id.' OR WD='.$player_id.' THEN color WHEN color="red" THEN "blue" WHEN color="blue" THEN "red" ELSE "none" END AS color'),
        DB::raw('CASE WHEN WO='.$player_id.' OR WD='.$player_id.' THEN 1 ELSE 0 END AS is_win'),
        DB::raw('CASE WHEN WO='.$player_id.' OR LO='.$player_id.' THEN 1 ELSE 0 END AS is_offense'),
        DB::raw('CASE WHEN WO='.$player_id.' THEN WD WHEN WD='.$player_id.' THEN WO WHEN LO='.$player_id.' THEN LD WHEN LD='.$player_id.' THEN LO ELSE 0 END AS teammate'));

        
        $results = DB::table('ratings')->select('rating_change', 'gameSub.date', 'gameSub.score', 'gameSub.color', 'gameSub.is_win', 'gameSub.is_offense', 'gameSub.teammate')
        ->joinSub($gameSub, 'gameSub', function($join) {
            $join->on('ratings.game_id', '=', 'gameSub.id');
        })->where('player_id', $player_id);

        $filteredResults = DB::table('ratings')->select('rating_change', 'gameSub.date', 'gameSub.score', 'gameSub.color', 'gameSub.is_win', 'gameSub.is_offense', 'gameSub.teammate', 'gameSub.id as game_id')
        ->joinSub($gameSub, 'gameSub', function($join) {
            $join->on('ratings.game_id', '=', 'gameSub.id');
        })->where('player_id', $player_id);
        
        // Apply filters
        if ($this->color!=='all') {
            $filteredResults = $filteredResults->where('gameSub.color', $this->color);
        }

        if ($this->side==='offense') {
            $filteredResults = $filteredResults->where('gameSub.is_offense', 1);
        } 
        else if ($this->side==='defense') {
            $filteredResults = $filteredResults->where('gameSub.is_offense', 0);
        } 

        if ($this->outcome==='win') {
            $filteredResults = $filteredResults->where('gameSub.is_win', 1);
        } 
        else if ($this->outcome==='loss') {
            $filteredResults = $filteredResults->where('gameSub.is_win', 0);
        } 

        $teammateResults = DB::table('ratings')
        ->select('players.alias as teammate', DB::raw('AVG(ratings.rating_change) as mean_rating_change, STD(ratings.rating_change) as std_rating_change'))
        ->joinSub($filteredResults, 'filterSub', function($join) {
            $join->on('ratings.game_id', '=', 'filterSub.game_id');
        })
        ->join('players', 'filterSub.teammate', '=', 'players.id')
        ->where('ratings.player_id', $player_id)
        ->where('players.is_active', 1)
        ->groupBy('players.alias')
        ->orderBy('mean_rating_change', 'desc');

        return ['results' => $results->get(), 'filteredResults' => $filteredResults->get(), 'teammateResults'=> $teammateResults->get()];
    }
}
