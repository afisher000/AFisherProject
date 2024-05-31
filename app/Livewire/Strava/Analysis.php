<?php

namespace App\Livewire\Strava;

use Livewire\Component;
use App\Models\Activity;
use Illuminate\Support\Facades\DB;

class Analysis extends Component
{

    public $athlete = 'all';
    public $sport_type = '';
    public $start_date;
    public $end_date;

    public function render()
    {
        $data = $this->getData();
        $this->dispatch('refreshJS', $data);
        return view('livewire.strava.analysis', $data);
    }

    public function refresh() {
        return;
    }

    public function getData() {
        $query = Activity::query();

        // Sport and athlete filtering
        if (!empty($this->sport_type)) {
            $query->where('sport_type', $this->sport_type);
        }


        if ($this->athlete!=='all') {
            $athletes = [
                'Andrew' => 2167889,
                'Travis' => 36706356,
            ];
            $query->where('athlete_id', $athletes[$this->athlete]);
        }

        // Use subJoin to avoid affecting query
        $allActivities = Activity::select('*')->joinSub($query, 'filtered', function ($join) {$join->on('activities.id', '=', 'filtered.id');})->get();
        $monthActivities = Activity::select('*')->joinSub($query, 'filtered', function ($join) {$join->on('activities.id', '=', 'filtered.id');})
            ->whereDate('activities.start_date', '>=', now()->subDays(30))->get();
        $yearActivities = Activity::select('*')->joinSub($query, 'filtered', function ($join) {$join->on('activities.id', '=', 'filtered.id');})
            ->whereDate('activities.start_date', '>=', now()->subDays(365))->get();


        // Add date filtering
        if (!empty($this->start_date)) {
            $query->whereDate('start_date', '>=', $this->start_date);
        }

        if (!empty($this->end_date)) {
            $query->whereDate('start_date', '<=', $this->end_date);
        }


        $filteredActivities = $query->get();

        // Get daily distances for heatmap
        $dailyDistances = Activity::select(DB::raw('DATE(activities.start_date) as date'), DB::raw('SUM(activities.distance) as total_distance'))
        ->joinSub($query, 'filtered', function ($join) {$join->on('activities.id', '=', 'filtered.id');})
        ->groupBy('date')
        ->orderBy('date', 'desc')
        ->pluck('total_distance', 'date');

        $dailyTimes = Activity::select(DB::raw('DATE(activities.start_date) as date'), DB::raw('SUM(activities.elapsed_time) as total_time'))
        ->joinSub($query, 'filtered', function ($join) {$join->on('activities.id', '=', 'filtered.id');})
        ->groupBy('date')
        ->orderBy('date', 'desc')
        ->pluck('total_time', 'date');

        return [
            'activities' => $filteredActivities,
            'allActivities' => $allActivities,
            'yearActivities' => $yearActivities,
            'monthActivities' => $monthActivities,
            'dailyDistances' => $dailyDistances,
            'dailyTimes' => $dailyTimes,
            'athlete' => $this->athlete,
        ];
    }
}
