<?php

namespace App\Http\Controllers;

use App\Models\MusicLibrary;
use App\Models\Track;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MusicController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin')->only(['store', 'update']);
    }
    
    public function show_song($id) {
        # Get song from api
        $endpoint = "https://itunes.apple.com/lookup?";
        $params = [
            'id'=>$id,
            'entity'=>'song',
        ];
        $response = Http::get($endpoint, $params);
        $song = $response->json()['results'][0];
        //ddd($song);
        return view('/music/create', ['song'=> $song]);
    }


    public function search(Request $request) {

        if (!isset($request['query'])){
            $prevFilters = ['attribute'=>'songTerm', 'query'=>''];
            $songs = [];
        } else {
            # Parse form requests if exists
            $attribute = $request->input('attribute');
            $query = $request->input('query');

            $prevFilters = [
                'attribute' => $attribute,
                'query' => $query,
            ];

            $endpoint = "https://itunes.apple.com/search?";
            $params = [
                'limit'=>30,
                'entity'=>'song',
                'attribute'=>$attribute,
                'term' => $query,
            ];

            $response = Http::get($endpoint, $params);
            $songs = $response->json()['results'];
            //ddd($songs[1]);
        }

        return view('/music/search', [
            'prevFilters'=>$prevFilters,
            'songs'=>$songs,
        ]);
        
    }
    public function index() {
        # Pass current playlist to music/index.blade.php
        return view('/music/index', ['tracks' => Track::latest()->get()]);
    }

    public function create() {
        return view('/music/create');
    }

    public function store(Request $request) {
        $formFields = $request->validate([
            'url' => 'required|url|max:255',
            'artist' => 'required|max:45',
            'name' => 'required|max:45',
        ]);

        # Convert to title case
        $formFields['artist'] = ucwords($formFields['artist']);
        $formFields['name'] = ucwords($formFields['name']);

        # Check if exists in music library
        if (MusicLibrary::where('artist', $formFields['artist'])->where('name', $formFields['name'])->count()==0) {
            # Create new database entries
            Track::create($formFields);
            MusicLibrary::create($formFields);

            # Redirect to music list
            return redirect('music/tracks');
        } else {
            return redirect('music/tracks')->with('message', 'Song already exists in itunes library');
        }
    }

    public function edit(Track $track) {
        return view('music/edit', ['track'=>$track]);
    }

    public function update(Request $request, Track $track) {
        $formFields = $request->validate([
            'url' => 'required|max:255',
            'artist' => 'required|max:45',
            'name' => 'required|max:45',
        ]);

        # Convert to title case
        $formFields['artist'] = Str::title($formFields['artist']);
        $formFields['name'] = Str::title($formFields['name']);

        # Update or delete entry
        if ($request->input('action')==='update'){
            $track->update($formFields);
        } elseif ($request->input('action')==='delete'){
            $track->delete();
        }

        return redirect('music/tracks');
    }
}