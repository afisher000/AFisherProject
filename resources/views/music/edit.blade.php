<x-music_layout>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-4" style="background-color:#fff0f0">

        <h1>Track Information</h1>
        <form action="/music/tracks/{{$track['id']}}" method="POST">
            @csrf
            @method('PUT')
            <label for="url">URL:</label>
            <input type="text" id="url" name="url" value="{{$track['url']}}" required><br>

            <label for="artist">Artist Name:</label>
            <input type="text" id="artist_name" name="artist" value="{{$track['artist']}}" required><br>

            <label for="name">Track Name:</label>
            <input type="text" id="track_name" name="name" value="{{$track['name']}}" required><br>

            <!-- Submit button for updating -->
            <button type="submit" name="action" value="update">Update Entry</button>

            <!-- Submit button for deleting -->
            <button type="submit" name="action" value="delete">Delete Entry</button>
        </form>

        </div>
    </div>
</x-music_layout>