<?php

namespace App\Jobs;

use DateTime;
use App\Models\Tile;
use App\Models\Split;
use App\Models\Activity;
use App\Models\NewActivity;
use Illuminate\Bus\Queueable;
use App\Services\TokenService;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class DownloadStravaStreams implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        # Download activities for athlete
        $strava_access_token = TokenService::getStravaToken();
        $max_pages = 15;
        $endpoint = 'https://www.strava.com/api/v3/activities?';

        for ($ipage=1; $ipage<= $max_pages; $ipage++){

            # Get activites on page
            $params = [
                'access_token'=>$strava_access_token,
                'per_page'=>200,
                'page'=>$ipage,
            ];
            $response = Http::get($endpoint, $params);

            $activities = $response->json();

            if (count($activities)<1){
                break;
            }

            foreach($activities as $activity){
                # Check if activity in database
                $exists = Activity::where('id', $activity['id'])->exists();

                # If not, add activity to database
                if (!$exists){

                    $new_activity['id'] = $activity['id'];
                    $new_activity['athlete_id'] = $activity['athlete']['id'];
                    $new_activity['elapsed_time'] = $activity['elapsed_time'];
                    $new_activity['total_elevation_gain'] = $activity['total_elevation_gain'];
                    $new_activity['sport_type'] = $activity['sport_type'];
                    $new_activity['average_speed'] = $activity['average_speed'];

                    if (array_key_exists('average_cadence', $activity)){
                        $new_activity['average_cadence'] = $activity['average_cadence'];
                    };

                    # Parse latlng
                    if (array_key_exists(0, $activity)){
                        $new_activity['start_lat'] = $activity['start_latlng'][0];
                        $new_activity['start_lng'] = $activity['start_latlng'][1];
                    };

                    # Change datetime structure to one mysql recognizes
                    $dateTime = new DateTime($activity['start_date']);
                    $new_activity['start_date'] = $dateTime->format('Y-m-d H:i:s');
                    Activity::create($new_activity);
                    NewActivity::create($new_activity);
                }

            }
        };


        # Download streams in NewActivity
        $params = [
            'access_token'=>$strava_access_token,
            'keys'=>'distance,latlng,time,altitude',
            'key_by_type'=>'true',
        ];

        $activity_ids = NewActivity::pluck('id');
        foreach ($activity_ids as $activity_id){

            # Skip if exists in splits
            if (Split::where('activity_id', $activity_id)->exists()){
                continue;
            }

            # Download stream
            $endpoint = "https://www.strava.com/api/v3/activities/" . $activity_id . "/streams?";
            $response = Http::get($endpoint, $params);

            # Redirect on bad response
            if ($response->status() !== 200) {
                return;
            }

            $stream = $response->json();
            ddd($response);

            # Compute splits
            $latlngData = $stream['latlng']['data'];
            $distanceData = $stream['distance']['data'];
            $altitudeData = $stream['altitude']['data'];
            $timeData = $stream['time']['data'];

            $splitDistance = 100;
            $splitLats = [];
            $splitLngs = [];

            $prevTime = $timeData[0];
            $prevDist = $distanceData[0];
            $prevAltitude = $altitudeData[0];
            $prevSplit = 1;
            for ($j=1; $j<count($timeData); $j++){
                # Check if new split
                if (($distanceData[$j]/$splitDistance)>$prevSplit) {
                    # Compute split data
                    $splitSpeed = ($distanceData[$j]-$prevDist)/($timeData[$j]-$prevTime);
                    $splitGrade = ($altitudeData[$j]-$prevAltitude)/($distanceData[$j]-$prevDist);
                    $splitLat = $latlngData[$j][0];
                    $splitLng = $latlngData[$j][1];
                    $splitNumber = floor($distanceData[$j]/$splitDistance);

                    $splitLats[] = $splitLat;
                    $splitLngs[] = $splitLng;


                    # Add to database
                    $splitData = [
                        'activity_id'=>$activity_id,
                        'speed'=>$splitSpeed,
                        'grade'=>$splitGrade,
                        'lat'=>$splitLat,
                        'lng'=>$splitLng,
                        'split'=>$splitNumber,
                    ];
                    Split::create($splitData);

                    # Update prev values
                    $prevTime = $timeData[$j];
                    $prevDist = $distanceData[$j];
                    $prevAltitude = $altitudeData[$j];
                    $prevSplit = $splitNumber+1;
                }
            };

            # Compute discrete latlngs for tiles
            $pairs = [];
            for ($j=0; $j<count($splitLats); $j++){
                # Convert to tens of arcseconds (300meters)
                $discrete_lat = floor($splitLats[$j]*3600/10);
                $discrete_lng = floor($splitLngs[$j]*3600/10);
                $key = "{$discrete_lat},{$discrete_lng}";
                $pairs[$key] = ['lat'=>$discrete_lat, 'lng'=>$discrete_lng];
            }
            
            $uniquePairs = array_values($pairs);
            foreach ($uniquePairs as $pair) {
                $tileData = [
                    'activity_id'=>$activity_id,
                    'discrete_lat'=>$pair['lat'],
                    'discrete_lng'=>$pair['lng'],
                ];
                Tile::create($tileData);
            }

            # Remove from NewActivities
            NewActivity::find($activity_id)->delete();

        }


    }
}
