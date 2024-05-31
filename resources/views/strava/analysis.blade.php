<x-strava_layout>
    <?php $attributes = ['id', 'athlete_id', 'elapsed_time', 'name', 'sport_type']; ?>
    <div class="container custom-card-container" style="position:relative;">
        <div class="container custom-card-header">
            <h1> Strava Analysis </h1>
        </div>

        @livewire('strava.analysis')

    </div>




   





    </x-strava_layout>