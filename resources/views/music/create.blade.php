<x-music_layout>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-4  custom-card-container">
            <h2 class="text-center mb-4">Track Information</h2>
            <form action="/music/tracks" method="POST">
                @csrf


                <div class="form-floating mb-3">
                    @if($errors->has('url'))
                        <input type="text" name='url' value="{{old('url')}}" class="form-control is-invalid" id="url">
                        @error('url')
                            <label style="font-weight:bold;" for="url">URL - {{$message}}</label>
                        @enderror
                    @else
                        <input class="form-control" type="text" value="{{old('url')}}" id="url" name="url">
                        <label style="font-weight:bold;" for="url">URL</label>
                    @endif
                </div>

                <div class="form-floating mb-3">
                    @if($errors->has('artist'))
                        <input type="text" name='artist' value="{{old('artist')}}" class="form-control is-invalid" id="artist">
                        @error('artist')
                            <label style="font-weight:bold;" for="artist">Artist - {{$message}}</label>
                        @enderror
                    @else
                        <input class="form-control" type="text" value="{{ isset($song) ? $song['artistName'] : old('artist')}}" id="artist" name="artist">
                        <label style="font-weight:bold;" for="artist">Artist</label>
                    @endif
                </div>
                
                <div class="form-floating mb-3">
                    @if($errors->has('name'))
                        <input type="text" name='name' value="{{old('name')}}" class="form-control is-invalid" id="name">
                        @error('name')
                            <label style="font-weight:bold;" for="name">Track - {{$message}}</label>
                        @enderror
                    @else
                        <input class="form-control" type="text" value="{{ isset($song) ? $song['trackName'] : old('name')}}" id="name" name="name">
                        <label style="font-weight:bold;" for="name">Track</label>
                    @endif
                </div>

                <button type="submit" class="btn btn-danger w-100">Submit</button>
            </form>
            <div class="text-center mt-3">
                <p class="mb-0">
                    <a id="youtubeLink" class="btn btn-link text-maroon" target="_blank">Search on YouTube</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        const youtubeLink = document.getElementById('youtubeLink');
        youtubeLink.addEventListener('click', function() {
            const artistInput = document.getElementById('artist').value;
            const songInput = document.getElementById('name').value;
            const youtubeSearchUrl = `https://www.youtube.com/results?search_query=${encodeURIComponent(artistInput)}+${encodeURIComponent(songInput)}`;
            window.open(youtubeSearchUrl, '_blank'); // Opens YouTube in a new tab
        });
    </script>

</x-music_layout>



