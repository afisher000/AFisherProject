<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Game;
use App\Models\Player;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

// Common resource routes:
// index - show all games
// show - show single game
//create - show form to create game
// store - store new game
// edit - show form to edit game
// update - update game
// delete - delete game




class FoosballController extends Controller
{
    // Show all listings
    public function index_games(Request $request) {
        return view('/foosball/games/index');
    }

    // Send to create form
    public function create_game() {
        return view('/foosball/games/create', [
            'players' => Player::pluck('alias')->sort(), 
            'colors' => ['red','blue']
        ]);
    }


    // Form to edit existing game
    public function edit_game($id) {
        $game = Game::find($id);
        return view('/foosball/games/edit', [
            'game' => $game,
            'players' => Player::pluck('alias')->sort(), 
            'colors' => ['red','blue']
        ]);
    }

    // Update game in database
    public function update_game($id, Request $request) {
        $formFields = $request->validate([
            'WO' => 'required|distinct',
            'WD' => 'required|distinct',
            'LO' => 'required|distinct',
            'LD' => 'required|distinct',
            'color' => 'required',
            'score' => 'required|integer|between:0,9'
        ]);
        $game = Game::find($id);
        if ($game) {
            $game->update($formFields);
        }
        return redirect('/foosball/games')->with('message', 'Game updated successfully');
    }




    // Show all listings
    public function index_players() {
        $players = Player::orderBy('alias', 'asc')->where('players.is_active', '1')->get();
        return view('/foosball/players/index', ['players' => $players]);
    }

    // Return player listings via api
    public function api_index() {
        $players = Player::all();
        return response()->json($players);
    }


    // Send to create form
    public function create_player() {
        return view('/foosball/players/create');
    }

    // Store new game
    public function store_player(Request $request) {
        $formFields = $request->validate([
            'alias' => 'required|unique:players,alias',
            'fullname' => 'required|unique:players,fullname',
        ]);

        Player::create($formFields);
        return redirect('/foosball/players')->with('message', 'Game added successfully');
    }

    // Display player page
    public function show_player($alias) {

        # Get ratings for plotting all players
        $players = Player::where('is_active', 1)->get();
        $allRatings = Rating::select('games.date', 'ratings.offense', 'ratings.defense')
        ->join('games', 'games.id', '=', 'ratings.game_id')->get();


        $player = Player::where('alias', $alias)->first();
        $ratings = Rating::select('games.date', 'ratings.offense', 'ratings.defense')
        ->join('games', 'games.id', '=', 'ratings.game_id')
        ->where('ratings.player_id', $player['id'])->get();

        return view('/foosball/players/player', [
            'player' => $player, 
            'ratings' => $ratings,
            'allRatings' => $allRatings
        ]);
    }

    public function ratings(Request $request) {
        $sortby = $request->input('sortby', 'average');
        $prevFilters = [
            'sortby' => $sortby,
        ];

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

        $ratings = $rating_query->get();
        return view('/foosball/ratings', ['prevFilters'=>$prevFilters, 'ratings'=>$ratings]);
    }

    public function upload_games(Request $request) {
        $request->validate([
            'table_csv' => 'required|file|mimes:csv,txt',
        ]);

        // Insert into database
        $csv_data = array_map('str_getcsv', file($request->file('table_csv')));

        $header = ['id', 'WO', 'WD', 'LO', 'LD', 'score', 'color', 'date'];
        $formattedData = [];
        foreach ($csv_data as $row) {
            $formattedData[] = array_combine($header, $row);
        }

        Game::truncate();
        Game::insert($formattedData);

        return redirect()->back()->with('success', 'CSV data has been imported into the database.');
    }
    public function upload_players(Request $request) {

        $request->validate([
            'table_csv' => 'required|file|mimes:csv,txt',
        ]);

        // Insert into database
        $csv_data = array_map('str_getcsv', file($request->file('table_csv')));
        Player::truncate();

        foreach ($csv_data as $row) {
            Log::info($csv_data);
            Player::create([
                'id' => $row[0],
                'alias' => $row[1],
                'fullname' => $row[2],
                'is_active' => $row[3],
            ]);

        }
        return redirect()->back()->with('success', 'CSV data has been imported into the database.');
    }

    public function upload_ratings(Request $request) {
        $request->validate([
            'table_csv' => 'required|file|mimes:csv,txt',
        ]);

        // Insert into database
        $csv_data = array_map('str_getcsv', file($request->file('table_csv')));

        $header = ['id', 'player_id', 'game_id', 'offense', 'defense', 'rating_change'];

        

        $formattedData = [];
        foreach ($csv_data as $row) {
            $formattedData[] = array_combine($header, $row);
        }


        Log::info($csv_data);
        Rating::truncate();
        Rating::insert($formattedData);

        return redirect()->back()->with('success', 'CSV data has been imported into the database.');
    }
    // Store new game
    public function store_game(Request $request) {
        $formFields = $request->validate([
            'WO' => 'required|distinct',
            'WD' => 'required|different:WO',
            'LO' => 'required|different:WO|different:WD',
            'LD' => 'required|different:WO|different:WD|different:LO',
            'color' => 'required',
            'score' => 'required|integer|between:0,9',
        ]);

        $gameFields = [
            'WO' => Player::where('alias', $formFields['WO'])->value('id'),
            'WD' => Player::where('alias', $formFields['WD'])->value('id'),
            'LO' => Player::where('alias', $formFields['LO'])->value('id'),
            'LD' => Player::where('alias', $formFields['LD'])->value('id'),
            'color' => $formFields['color'],
            'score' => $formFields['score'],
            'date' => Carbon::today(),
        ];

        // ddd($gameFields);
        Game::create($gameFields);
        return redirect('/foosball/games')->with('message', 'Game added successfully');
    }
}
