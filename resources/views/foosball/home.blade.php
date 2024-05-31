<x-foosball_layout>
    
    <div class="container-fluid custom-homepage-container">



        <div class="p-4 custom-card-container">
            <h1> Foosball ELO Ratings</h1>
            <h3> Motivation </h3>
                <p>
                    Every day at 4 pm, our research lab takes a mental break to play foosball. This tradition has been a part of our lab's culture for over a decade, complete with the infamous 10-0 board. 
                    However, it was only in recent years that I began documenting games and publishing weekly rankings of our ELO ratings, allowing friendly competition between different skill levels.

                    To make sure the rankings could live beyond my graduate yeras, I created a Slack-bot upload game results to a database and computes ratings in real-time. 
                    Game results are also sent to this website, enabling more accessible data analysis.
                <p>

            <h3>Pages </h3>
            <h6>Games</h6>
                <p> 
                    This page lists games in the database with pagination and filtering.
                </p>
            <h6>Players </h6>
                <p> 
                    This page lists the foosball players and links to pages for individual statistics. 
                </p>
            <h6>Ratings</h6>
                <p> 
                    The current ratings (average/offense/defense) with optional sorting.
                </p>

            <h3>Implemented</h3>
                <ul>
                    <li> Develop a robust Foosbot interface (slackbot + database storage) that can be used beyond current generation of grad students</li>
                        <li>Organize database tables so graduated players can be "archived" to avoid name conflicts</li>
                    <li> Handle external POST requests to add information to website database</li>
                    <li> Filter and analyze game information </li>
                </ul>
            </p>


            <h3> Future work </h3>
            <ul>
                <li> Study trends in game data beyond offense/defense. </li>
                    <ul>
                        <li> Create an advanced statistics page </li>
                        <li> Effect of color (side)</li>
                        <li> Dominant matchup pairs </li>
                    </ul>
                <li> Include page where multiple player ratings can be plotted with selectors </li>
            </ul>
        </div>

        <div style="padding:10;">
            <img class="custom-screenshot" src="{{ asset('images/screenshots/foosballPlayerAnalysis.png') }}" alt="Image 1" width="500" height='auto'> 
            <img class="custom-screenshot" src="{{ asset('images/screenshots/foosballGameIndex.png') }}" alt="Image 1" width="500" height='auto'> 

        </div>
        
    </div>
</x-foosball_layout>