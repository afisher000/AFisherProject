<?php
namespace App\Services;


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class TokenService {
    public static function getKrogerToken() {
        $token = Cache::get('kroger_access_token');

        if ($token === null) {
            # Encode token
            $client_id = config('services.kroger.client_id');
            $client_secret = config('services.kroger.client_secret');
            $client_token = base64_encode($client_id . ':' . $client_secret);

            $response = Http::asForm()
            ->withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => 'Basic ' . $client_token,
            ])
            ->post('https://api.kroger.com/v1/connect/oauth2/token/', [
                'grant_type' => 'client_credentials',
                'scope' => 'product.compact',
            ]);

            $token = $response->json()['access_token'];

            Cache::put('kroger_access_token', $token, now()->addMinutes(30));
        }

        return $token;
    }

    public static function getStravaToken() {
        $token = Cache::get('strava_access_token');

        if ($token === null) {
            $client_id = config('services.strava.client_id');
            $client_secret = config('services.kroger.client_secret');
            $redirect_url = 'localhost:8000/strava/home';

            $url = 'https://www.strava.com/oauth/authorize?' . 
                'client_id=' . $client_id . '&redirect_uri='. $redirect_url .'&response_type=code&scope=activity:read_all';
            redirect('/strava/home/');
        }
        return $token;
    }
}