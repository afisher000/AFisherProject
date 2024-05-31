<x-strava_layout>


    <div class="container-fluid custom-homepage-container">


        <div class="p-4 custom-card-container">
            <h1> Strava Project</h1>
            <h3> Motivation </h3>
            <div>
                <p>
                    Strava is a popular social fitness platform used by athletes to track and analyze activities. I bought a GPS watch several years ago to track my running times where activities
                    are uploaded to the Strava server which can be access through API calls. In order to create custom dashboards for my data analysis, I developed these pages along with automated scripts that download new activities
                    nightly.
                </p>
            </div>

            <h3> Pages </h3>
                <h6>Sync</h6>
                    <p> 
                        This page is necessary for downloading activities in the same day. It redirects the user to Strava's website for OAuth2 authentification. Currently it is restricted to those with admin privileges. 
                    </p>
                <h6>Activities </h6>
                    <p> 
                        This page lists all activities with filtering capability. The hyperlinks open pages for analysis of each specific activity. 
                    </p>
                <h6>Analysis </h6>
                    <p> 
                        This page is for historical analysis and accumulative analysis of many activities. 
                    </p>
            <h3>Implemented</h3>
                <ul>
                    <li> <h6>API Interface</h6> </li>
                        <ul> 
                            <li>User initiated: OAuth2 redirect authentification</li>
                            <li>Nightly download: Automate OAuth2 login with headless Python/Selenium webform filling.</li>
                        </ul>
                    <li><h6>Database Design</h6></li>
                    <ul> 
                        <li>Reduce storage size by computing 100 meter splits from activity streams.</li>
                        <li>Create helper tables for faster analysis (for example, aggregating data for similar activity routes)</li>
                    </ul>
                    <li> <h6>Data Visualization</h6> </li>
                        <ul> 
                            <li> Mapbox API for latitude/longitude maps </li>
                            <li> Plotly.js library for plots and charts </li>
                            <li> Javascript for interactivity </li>
                            
                        </ul>
                    </li>
                </ul>
            </p>

            <h3> Future work </h3>
            <ul>
                <li> Add analysis for matched (similar) activities </li>
                <li> Allow user to name/save specific routes </li>
            </ul>
        </div>


        <div style="padding:10;">
            <img class="custom-screenshot" src="{{ asset('images/screenshots/stravaActivity.png') }}" alt="Image 1" width="500" height='auto'> 
            <img class="custom-screenshot" src="{{ asset('images/screenshots/stravaAnalysis.png') }}" alt="Image 1" width="500" height='auto'> 
        </div>
    </div>
</x-strava_layout>