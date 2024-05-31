<?php

namespace App\Http\Controllers;

use DateTime;
use Exception;
use Carbon\Carbon;
use App\Models\Tile;
use App\Models\Split;
use App\Models\Activity;
use App\Models\NewActivity;
use Illuminate\Http\Request;
use App\Models\ActivityMatch;
use App\Services\TokenService;
use Illuminate\Support\Facades\DB;
use App\Jobs\DownloadStravaStreams;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class StravaController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin')->only(['apiredirect']);
    }

    public function previous_activity($activity_id){
        $athlete_id = Activity::where('id', $activity_id)->value('athlete_id');
        $prevActivity = Activity::where('id', '<', $activity_id)->where('athlete_id', $athlete_id)
            ->orderBy('id', 'desc')
            ->first();

        if ($prevActivity){
            return $this->show($prevActivity['id']);
        } else {
            return $this->show($activity_id);
        }
    }

    public function next_activity($activity_id){
        $athlete_id = Activity::where('id', $activity_id)->value('athlete_id');
        $nextActivity = Activity::where('id', '>', $activity_id)->where('athlete_id', $athlete_id)
            ->orderBy('id', 'asc')
            ->first();


        if ($nextActivity){
            return $this->show($nextActivity['id']);
        } else {
            return $this->show($activity_id);
        }
    }


    public function index(Request $request) {
        return view('/strava/index');
    }

    public function show($activity_id) {
        $activity = Activity::find($activity_id);
        $splits = Split::where('activity_id', $activity_id)->orderByDesc('split')->get();

        $matched_activity_ids1 = ActivityMatch::where('activity_id1', $activity_id)->pluck('activity_id2')->toArray();
        $matched_activity_ids2 = ActivityMatch::where('activity_id2', $activity_id)->pluck('activity_id1')->toArray();
        $matched_activity_ids = collect(array_merge($matched_activity_ids1, $matched_activity_ids2))->unique();
        $matched_activities = Activity::whereIn('id', $matched_activity_ids)->get();


        return view('/strava/activities', ['activity' => $activity, 'splits'=>$splits, 'matched_activities'=>$matched_activities]);
    }

    // public function filter_Athlete_SportType($athlete, $sport_type) {
    //     $query = Activity::query();
    //     if (!empty($sport_type)) {
    //         $query->where('sport_type', $sport_type);
    //     }

    //     $athletes = [
    //         'Andrew' => 2167889,
    //         'Travis' => 36706356,
    //     ];
    //     if (!empty($athlete)) {
    //         $query->where('athlete_id', $athletes[$athlete]);
    //     }
    //     return $query;
    // }

    // public function filter_Dates($query, $start_date, $end_date)
    // {
    //     if (!empty($start_date)) {
    //         $query->whereDate('start_date', '>=', $start_date);
    //     }

    //     if (!empty($end_date)) {
    //         $query->whereDate('start_date', '<=', $end_date);
    //     }
    //     return $query;
    // }

    public function analysis(Request $request) {
        // $athlete = $request->input('athlete', '');
        // $sport_type = $request->input('sport_type', '');
        // $start_date = $request->input('start_date', '');
        // $end_date = $request->input('end_date', '');

        // $prevFilters = [
        //     'athlete' => $athlete,
        //     'sport_type' => $sport_type, 
        //     'start_date' => $start_date,
        //     'end_date' => $end_date,
        // ];

        // $allActivities = $this->filter_Athlete_SportType($athlete, $sport_type)->get();
        // $yearActivities = $this->filter_Athlete_SportType($athlete, $sport_type)->whereDate('start_date', '>=', now()->subDays(365))->get();
        // $monthActivities = $this->filter_Athlete_SportType($athlete, $sport_type)->whereDate('start_date', '>=', now()->subDays(30))->get();


        // $query = $this->filter_Athlete_SportType($athlete, $sport_type);
        // $filteredActivities = $this->filter_Dates($query, $start_date, $end_date)->get();

        // // Get daily distances for heatmap
        // $query = $this->filter_Athlete_SportType($athlete, $sport_type);
        // $dailyDistances = $this->filter_Dates($query, $start_date, $end_date)
        // ->select(DB::raw('DATE(start_date) as date'), DB::raw('SUM(distance) as total_distance'))
        // ->groupBy('date')
        // ->orderBy('date', 'desc')
        // ->pluck('total_distance', 'date');

        // return view('/strava/analysis', [
        //     'activities' => $filteredActivities,
        //     'allActivities' => $allActivities,
        //     'yearActivities' => $yearActivities,
        //     'monthActivities' => $monthActivities,
        //     'dailyDistances' => $dailyDistances,
        //     'prevFilters' => $prevFilters,
        // ]);

        return view('/strava/analysis');
    }



    // Get authorization for API calls
    public function oauth() {

        $client_id = config('services.strava.client_id');

        // # Rewrite this using params?
        // $url = 'https://www.strava.com/oauth/authorize?' . 
        //     'client_id=' . $client_id . '&redirect_uri=https://afisherproject.com/strava/apiredirect/&response_type=code&scope=activity:read_all';
        
        $url = 'https://www.strava.com/oauth/authorize?' . 
        'client_id=' . $client_id . '&redirect_uri=' . env('APP_URL') . '/strava/apiredirect/&response_type=code&scope=activity:read_all';

        return redirect($url);
    }

    public function apiredirect(Request $request) {
        # Get code from redirect url
        $code = $request->query('code');
        $client_id = config('services.strava.client_id');
        $client_secret = config('services.strava.client_secret');

        
        # Send API query for access token
        $params = [
            'client_id'=>$client_id, 
            'client_secret'=>$client_secret, 
            'code'=>$code, 
            'grant_type'=>'authorization_code',
        ];
        $endpoint = 'https://www.strava.com/oauth/token?';
        $response = Http::post($endpoint, $params);

        # Redirect on bad response
        if ($response->status() !== 200) {
            return redirect('/strava/home')->with('message', 'Error syncing with strava');
        }

        # Store token in cache
        $access_token = $response->json()['access_token'];
        $python_script_path = 'sync_strava_database.py'; # Stored in app directory
        $output = shell_exec("python $python_script_path $access_token 2>&1");

        return redirect('strava/activities')->with('message', 'Successfully updated strava database!');
    }

}
