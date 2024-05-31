<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\MiscController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\KrogerController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\StravaController;
use App\Http\Livewire\Foosball\IndexGames;
use App\Http\Controllers\FoosballController;
use App\Http\Controllers\FlashcardController;
use App\Http\Controllers\KrogerAPIController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// See docs: The Basics/Controllers/ResourceControllers


# Home
Route::get('/', function () {return view('home');});
Route::get('/home', function () {return view('home');});
Route::get('/about-the-website', function () {return view('about-the-website');});

# Research
Route::get('/research/overview', function () {return view('/research/overview');});
Route::get('/research/publications', function () {return view('/research/publications');});
Route::get('/research/download-resume', function () {
    $resume_pdf = public_path('test.pdf'); 
    return response()->download($resume_pdf, 'Andrew_Fisher_Resume.pdf');
});

# User Routes
Route::get('users/register', [UserController::class, 'create'])->middleware('guest');
Route::post('/users', [UserController::class, 'store']);
Route::post('users/logout', [UserController::class, 'logout']);
Route::get('users/confirmlogout', [UserController::class, 'confirmlogout']);
Route::get('users/login', [UserController::class, 'login'])->name('login')->middleware('guest');
Route::post('users/authenticate', [UserController::class, 'authenticate']);
Route::get('users/accessdenied', [UserController::class, 'accessdenied']);

// ### Foosball Routes ###
Route::post('/foosball/games', [FoosballController::class, 'store_game']);
Route::post('/foosball/games/upload', [FoosballController::class, 'upload_games'])->middleware(('ipwhitelist'));
Route::get('/foosball/games/upload', function() {return view('/foosball/games/upload');});#->middleware(('ipwhitelist'));
Route::post('/foosball/players/upload', [FoosballController::class, 'upload_players']);#->middleware(('ipwhitelist'));
Route::get('/foosball/players/upload', function() {return view('/foosball/players/upload');});#->middleware(('ipwhitelist'));
Route::post('/foosball/ratings/upload', [FoosballController::class, 'upload_ratings']);#->middleware(('ipwhitelist'));
Route::get('/foosball/ratings/upload', function() {return view('/foosball/ratings/upload');});#->middleware(('ipwhitelist'));
//Route::get('/foosball/livewire/update', [IndexGames::class, 'update']);

Route::get('/foosball/home', function() {return view('/foosball/home');});
Route::get('/foosball/ratings', [FoosballController::class, 'ratings']);
Route::get('/foosball/games', [FoosballController::class, 'index_games']);
Route::get('/foosball/players', [FoosballController::class, 'index_players']);
Route::get('/foosball/players/{alias}', [FoosballController::class, 'show_player']);
Route::get('/foosball/games/create', [FoosballController::class, 'create_game']);
Route::get('/foosball/games/delete', [FoosballController::class, 'delete_game']);
Route::get('/foosball/games/{id}/edit', [FoosballController::class, 'edit_game']);



// Route::prefix('foosball')->group(function () {
//     Route::resource('games', GameController::class); #->middleware('role:admin');
//     Route::resource('players', PlayerController::class);#->middleware('role:admin');
// });

// ### Kroger Routes ###
Route::get('/kroger/home', function() {return view('/kroger/home');});

Route::prefix('kroger')->group(function (){
    Route::resource('products', KrogerController::class);
});

Route::get('kroger/search', function () {return view('/kroger/search');});
Route::post('kroger/search_results', [KrogerController::class, 'search_results']);
Route::get('kroger/search_results', function () {return view('kroger/search');});
Route::get('kroger/create/{ID}', [KrogerController::class, 'create']);

// Route::prefix('kroger/api')->group(function (){
//     Route::resource('products', KrogerAPIController::class);
// });

# Strava Routes
Route::get('/strava/home', function () {return view('strava/home');});
Route::get('/strava/oauth', [StravaController::class, 'oauth']);
Route::get('/strava/apiredirect', [StravaController::class, 'apiredirect']);
Route::get('/strava/previous_activity/{activity_id}', [StravaController::class, 'previous_activity']);
Route::get('/strava/next_activity/{activity_id}', [StravaController::class, 'next_activity']);
Route::get('/strava/analysis', [StravaController::class, 'analysis']);
Route::prefix('strava')->group(function(){
    Route::resource('activities', StravaController::class);
});

# Music Routes
Route::get('music/home', function() {return view('/music/home');});
Route::get('music/search', [MusicController::class, 'search']);
Route::get('music/search/song/{id}', [MusicController::class, 'show_song']);
Route::prefix('music')->group(function(){
    Route::resource('tracks', MusicController::class);
});

# Memory Routes
Route::get('flashcards/home', function() {return view('/flashcards/home');})->middleware('role:admin');
Route::get('flashcards/practice', [FlashcardController::class, 'practice'])->middleware('role:admin');
Route::post('flashcards/upload', [FlashcardController::class, 'upload'])->middleware('role:admin');
Route::get('/flashcards/upload', function() {return view('/flashcards/upload');})->middleware('role:admin');


# Budget Routes
Route::get('budget/home', function () {return view('/budget/home');})->middleware('role:admin');

# Misc
Route::get('misc/weights', [MiscController::class, 'enter_weight'])->middleware('role:admin');
Route::post('misc/weights', [MiscController::class, 'store_weight'])->middleware('role:admin');

# Machine Learning Blog and posts
Route::get('/machine-learning/home', function () {return view('machine-learning/home');});
Route::get('/machine-learning/posts/validation', function () {return view('machine-learning/posts/validation');});
Route::get('/machine-learning/posts/feature_engineering', function () {return view('machine-learning/posts/feature_engineering');});
Route::get('/machine-learning/posts/MNIST', function () {return view('machine-learning/posts/MNIST');});
