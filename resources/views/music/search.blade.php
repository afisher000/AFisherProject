<x-music_layout>

    <div class="container card p-4 custom-card-container" >
        <div class="container custom-card-header">
            <h1>Search Songs</h1>
        </div>

        <div class="container">
            <form action="{{ url()->current() }}" method="get">
                @csrf
                <div class='mb-1'>
                    <label for="attribute" style="width:50px;">By:</label>
                    <select name="attribute" id="attribute" style="height:30px; width:150px;">
                        <option value="artistTerm" {{ $prevFilters['attribute'] === 'artistTerm' ? 'selected' : '' }}>Artist name</option>
                        <option value="songTerm" {{ $prevFilters['attribute'] === 'songTerm' ? 'selected' : '' }}>Song name</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>
                <div class='mb-2'>
                    <label for="query" style="width:50px;">Query:</label>
                    <input type="text" id="query" name="query" style="width:150px;" value="{{ isset($prevFilters['query']) ? $prevFilters['query'] : '' }}">
                </div>
                <button type="submit" class="btn btn-danger">Search</button>
            </form>
        </div>

        <div class="container custom-card-header">
            <h1>Results</h1>
        </div>

        <div class="container">
            <ul style="list-style-type: none;">
                @foreach($songs as $song)
                    <li>
                        <img class="play-icon" src="{{ asset('images/play_icon.png') }}" style="padding-right:10;" width="30" height="20" class="m-0" data-preview="{{$song['previewUrl']}}">
                        <a class="text-danger" href="/music/search/song/{{$song['trackId']}}">{{$song['trackName']}} by {{$song['artistName']}}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const playIcons = document.querySelectorAll('.play-icon');
            let currentAudio = null;
        
            playIcons.forEach((icon, index) => {
                icon.addEventListener('click', function() {
                    const previewUrl = this.getAttribute('data-preview');
                    playAudio(previewUrl);
                });
            });
            
            function playAudio(previewUrl) {
                if (currentAudio) {
                    currentAudio.pause();
                }
        
                currentAudio = new Audio(previewUrl);
                currentAudio.play();
            }
        });
        </script>

</x-music_layout>