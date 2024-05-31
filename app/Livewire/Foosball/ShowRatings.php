<?php

namespace App\Livewire\Foosball;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShowRatings extends Component
{

    public string $selection = 'average';
    public $ratings;

    public function render()
    {      
        $this->ratings = $this->fetchRatings();
        return view('livewire.foosball.show-ratings');
    }

    public function refresh() {
        # Dummy function to force refresh of page/call to render. 
        return;
    }

    private function fetchRatings() {
        $sortby = $this->selection;
        $rating_query = DB::table('ratings as r')
        ->select('p.alias as player', 'r.offense', 'r.defense',  DB::raw('(r.offense+r.defense)/2 as average'))
        ->join(DB::raw('(SELECT player_id, MAX(game_id) AS latest_game_id FROM ratings GROUP BY player_id) subquery'), function ($join) {
            $join->on('r.player_id', '=', DB::raw('subquery.player_id'));
            $join->on('r.game_id', '=', DB::raw('subquery.latest_game_id'));
        })
        ->join('players as p', 'r.player_id', '=', 'p.id')->where('p.is_active', '1');

        
        if ($sortby==='average') {
            $rating_query->orderBy('average', 'desc');
        } else if ($sortby==='offense') {
            $rating_query->orderBy('offense', 'desc');
        }else if ($sortby==='defense') {
            $rating_query->orderBy('defense', 'desc');
        }

        return $rating_query->get();
    }
}
