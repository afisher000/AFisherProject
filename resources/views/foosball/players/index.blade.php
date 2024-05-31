<x-foosball_layout>
    <div class="container card p-4 custom-card-container">
        <div class="container" style="padding:20px;">
            <h1>Active Foosball Players</h1>
        </div>

        <div class="container" style="display:flex; flex-wrap:wrap;">
                @foreach($players as $player)
                    <div class="text-center" style="padding:10px;">
                        <a class="btn btn-danger" style="width:200px; height:40px;" href="players/{{$player['alias']}}">{{str_replace("_", " ", $player['fullname'])}}</a>
                    </div>
                @endforeach
        </div>
    <div>
</x-foosball_layout>