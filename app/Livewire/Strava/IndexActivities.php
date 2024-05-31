<?php

namespace App\Livewire\Strava;

use Livewire\Component;
use App\Models\Activity;
use Livewire\WithPagination;


class IndexActivities extends Component
{
    public $athlete;
    public $sport_type;
    public $start_date;
    public $end_date;


    public function render()
    {
        return view('livewire.strava.index-activities', $this->getActivities());
    }

    public function refresh() {
        return;
    }

    public function getActivities() {
        $athletes = [
            'Andrew' => 2167889,
            'Travis' => 36706356,
        ];

        $query = Activity::query();

        // Apply filters to query
        if (!empty($this->sport_type)) {
            $query->where('sport_type', $this->sport_type);
        }

        if (!empty($this->athlete)) {
            $query->where('athlete_id', $athletes[$this->athlete]);
        }

        if (!empty($this->start_date)) {
            $query->whereDate('start_date', '>=', $this->start_date);
        }

        if (!empty($this->end_date)) {
            $query->whereDate('start_date', '<=', $this->end_date);
        }

        $filteredActivities = $query->orderByDesc('start_date')->paginate(10);
        return ['activities' => $filteredActivities];
    }
}
