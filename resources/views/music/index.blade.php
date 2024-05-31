<x-music_layout>

    <div class="container card p-4 custom-card-container">
        <div class="container" style="padding:20px;">
            <h1>Music Queue </h1>
        </div>

        <div class="container">
            @foreach($tracks as $track)
                <div>
                    <a class="text-danger" href="/music/tracks/{{$track['id']}}/edit">{{$track['name']}} by {{$track['artist']}}</a>
                </div>
            @endforeach
        </div>
    </div>

</x-music_layout>