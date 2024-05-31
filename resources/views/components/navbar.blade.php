<!-- This files creates the template for the navigation bar at the top of all webpages -->

<nav class="navbar navbar-expand-sm custom-navbar-color">

    <!-- Container-fluid fills entire width for all screen sizes. -->
    <div class="container-fluid align-items-center" style="display:flex">

        <!-- START Left aligned container -->
        <div class="justify-content-start align-items-center">

            <!-- aFisherProject logo -->
            <div>
                <a href="/home" class="navbar-brand">
                    <img src="{{ asset('images/afisherprojectFinal.png') }}" width="150" height="40" class="m-0">
                </a>
            </div>

            {{-- <!-- Dropdown menu for research -->
            <div class="dropdown">
                <button class="btn btn-outline-danger dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Research
                </button>
                <ul class="dropdown-menu" style="left: auto; right: 0;">
                        <li><a class="dropdown-item" href="/research/overview">Overview</a></li>
                        <li><a class="dropdown-item" href="/research/publications">Publications/Resume</a></li>     
                </ul>
            </div> --}}


        </div>
        <!-- END Left aligned container -->


        <!-- START Right aligned container -->
        <div class="align-items-center justify-content-end" style="display:flex">

            <!-- Machine Learning -->
            <div class="dropdown">
                <a class="btn btn-outline-danger" href="/machine-learning/home">Machine Learning</a>
            </div>
            

            <!-- Dropdown menu for data projects -->
            <div class="dropdown">

                <button class="btn btn-outline-danger dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Data Projects
                </button>
                @if (auth()->check())
                <ul class="dropdown-menu" style="left: auto; right: 0;">
                    <li><a class="dropdown-item" href="/strava/home">Strava</a></li>
                    <li><a class="dropdown-item" href="/foosball/home">Foosball</a></li>
                    <li><a class="dropdown-item" href="/music/home">Music</a></li>
                    <li><a class="dropdown-item" href="/kroger/home">Kroger</a></li>
                    <li><a class="dropdown-item" href="/flashcards/home">Flashcards</a></li>
                    <li><a class="dropdown-item" href="/misc/weights">Misc</a></li>
                </ul>
                @else
                    {{-- User is not authenticated --}}
                    <ul class="dropdown-menu" style="left: auto; right: 0;">
                        <li><a class="dropdown-item" href="/strava/home">Strava</a></li>
                        <li><a class="dropdown-item" href="/foosball/home">Foosball</a></li>
                        <li><a class="dropdown-item" href="/music/home">Music</a></li>
                        <li><a class="dropdown-item" href="/kroger/home">Kroger</a></li>
                    </ul>
                @endif


            </div>
        
            <!-- Dynamic dropdown menu for current project -->
            <div class="dropdown">
                <button class="btn btn-outline-danger dropdown-toggle" type="button" data-bs-toggle="dropdown">
                {{$title}}
                </button>
                <ul class="dropdown-menu" style="left: auto; right: 0;">
                    {{$slot}}
                </ul>
            </div>
      
        </div>
      <!-- END Right aligned container -->

    </div>

</nav>
