<?php

namespace App\Livewire\Foosball;

use App\Models\Game;
use App\Models\Player;
use Livewire\Component;
use Livewire\WithPagination;

class IndexGames extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $W1='';
    public $W2='';
    public $L1='';
    public $L2='';
    public $min_score='';
    public $max_score='';
    public $start_date;
    public $end_date;


    public function update() {
        return;
    }
    public function render()
    {
        return view('livewire.foosball.index-games', $this->getGames());
    }

    public function refresh() {
        return;
    }

    public function getGames() {
        // Build filter querys (use closure functions to use orWhere with query builder)
        $query = Game::query()
        ->select('games.id', 'p1.alias as WO', 'p2.alias as WD', 'p3.alias as LO', 'p4.alias as LD', 'games.score', 'games.color', 'games.date', 'ratings.rating_change')
        ->join('players as p1', 'games.WO', '=', 'p1.id')
        ->join('players as p2', 'games.WD', '=', 'p2.id')
        ->join('players as p3', 'games.LO', '=', 'p3.id')
        ->join('players as p4', 'games.LD', '=', 'p4.id')
        ->join('ratings', function ($join) {
            $join->on('ratings.game_id', '=', 'games.id')
                 ->on('ratings.player_id', '=', 'p1.id'); // Adjust this to match the specific player column you want to join with in the ratings table
        });

        if (!empty($this->W1)) {
            $W1 = $this->W1;
            $query->where(function($query) use ($W1) {
                $query->where('WO', $W1)->orWhere('WD', $W1);
            });
        }

        if (!empty($this->W2)) {
            $W2 = $this->W2;
            $query->where(function($query) use ($W2) {
                $query->where('WO', $W2)->orWhere('WD', $W2);
            });
        }

        if (!empty($this->L1)) {
            $L1 = $this->L1;
            $query->where(function($query) use ($L1) {
                $query->where('LO', $L1)->orWhere('LD', $L1);
            });
        }

        if (!empty($this->L2)) {
            $L2 = $this->L2;
            $query->where(function($query) use ($L2) {
                $query->where('LO', $L2)->orWhere('LD', $L2);
            });
        }

        if (!($this->min_score==='')) {
            $query->where('score', '>=', $this->min_score);
        }

        if (!($this->max_score==='')) {
            $query->where('score', '<=', $this->max_score);
        }

        if (!empty($this->start_date)) {
            $query->whereDate('date', '>=', $this->start_date);
        }

        if (!empty($this->end_date)) {
            $query->whereDate('date', '<=', $this->end_date);
        }

        // Get filtered games, reset pagination
        $games = $query->orderByDesc('id')->paginate(10, ['*'], 'paginationPage');
        $this->resetPage('paginationPage');
        
        // Get player list
        $players = Player::orderBy('alias', 'asc')->where('is_active', 1)->get();


        return [
            'games' => $games,
            'players' => $players,
        ];
    }
}
