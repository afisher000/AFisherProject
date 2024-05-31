<x-music_layout>
    <div class="container-fluid custom-homepage-container">


        <div class="p-4 custom-card-container">
            <h1> Music Project</h1>
            <h3> Motivation </h3>
            <p>
                Because I run with an old Iphone, music has to be stored directly on the phone. 
                For this reason, I developed code to easily download new audio from youtube (including lectures and audiobooks).
                These pages are a simple form interface that allow me to browse artist songs with the Itunes API and download audio by specifying a URL.
            </p>

            <h3> Pages </h3>
                <h6>Music Queue</h6>
                    <p> 
                        Lists the entries that will be downloaded overnight. Use hyperlinks to edit/remove entries.
                    </p>
                <h6>Search Music</h6>
                    <p> 
                        Search for songs either by song or artist name (see attribute input). A previous of a song can be played using the playback icon. The hyperlink is used to automatically fill a 
                        form used to add the song to the queue. Use the "Search on Youtube" link to open youtube results for that artist/song. 
                    </p>
                <h6>Add Manually</h6>
                    <p> 
                        Opens the same form for adding to the queue. This can be used for audio not found on the Itunes API.
                    </p> 



            <h3>Implemented</h3>
                <ul>
                    <li> 
                        Make downloading youtube audio faster
                        <ul>
                            <li>Have control over mp3 property tags</li>
                        </ul>
                    </li>

                    <li> Schedule scripts to download music queue directly to Itunes library</li>
                </ul>
    
                <h3> Future work </h3>
                <ul>
                    <li> Implement more search tools using the Itunes API that help discover new/related music</li>
                    <li> Add scripts that automatically create/add to playlists based on music properties like bpm, genre. </li>
                </ul>
        </div>


        <div style="padding:10;">
            <img class="custom-screenshot" src="{{ asset('images/screenshots/musicSearch.png') }}" alt="Image 1" width="400" height='auto'> 
            <img class="custom-screenshot" src="{{ asset('images/screenshots/musicDownload.png') }}" alt="Image 1" width="250" height='auto'> 
        </div>
    </div>
</x-music_layout>