<div>
    <div class="container">
        <!-- Form to apply filters -->

        <label for="athlete">Athlete:</label>
        <select wire:model="athlete" wire:change="refresh" name="athlete" id="athlete">
            <option value="">All</option>
            <option value="Andrew">Andrew</option>
            <option value="Travis">Travis</option>
        </select>

        <label for="sport_type">Sport Type:</label>
        <select wire:model="sport_type" wire:change="refresh" name="sport_type" id="sport_type">
            <option value="">All</option>
            <option value="Run">Run</option>
            <option value="AlpineSki">AlpineSki</option>
            <option value="Ride">Ride</option>
        </select>
        
        <label for="start_date">Start Date:</label>
        <input wire:model="start_date" wire:change="refresh"  type="date" name="start_date" id="start_date">
        <label for="end_date">End Date:</label>
        <input wire:model="end_date" wire:change="refresh"  type="date" name="end_date" id="end_date">

    </div>
    <div class="container">
        <ul id="activityList">
            @foreach ($activities as $activity)
                <div>
                    <a class="text-danger" style="font-weight: 700;" href="/strava/activities/{{$activity['id']}}">{{$activity->getAthleteName()}}'s {{$activity['sport_type']}} on {{ date('Y-m-d', strtotime($activity['start_date'])) }}</a>
                    <p>Distance = <?php echo number_format($activity['distance']*0.000621371, 1)?> mi </p>
                </div>
            
            @endforeach    
        </ul>
    </div>

    <div class="container">
        <div>
            {{ $activities->appends(app('request')->query())->onEachSide(2)->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
