<x-foosball_layout>
    <div class="container custom-card-container">
        <div class="container custom-card-header">
            <h1> Player Analysis: {{str_replace("_", " ", $player->fullname)}} </h1>
        </div>



        @php
            $record = $player->computeWinPct();
            $red_record = $player->computeWinPct(['red']);
            $blue_record = $player->computeWinPct(['blue']);
            $tenzero_record = $player->computeWinPct(['tenzero']);
            $offense_record = $player->computeWinPct(['offense']);
            $defense_record = $player->computeWinPct(['defense']);
        @endphp

        @php
            $margincounts = $player->marginOfVictory();
        @endphp

        <div class="row">
            <div class="col-md-2 p-2" style="height:350px;">
                <table style="width:100%;">
                    <tbody>
                        <tr><th></th><th style="text-align:center;">Record</th><th style="text-align:right;">Win. Pct.</th></tr>
                        <tr><td>Overall</td> <td style="text-align:center;">{{$record['wins']}} - {{$record['losses']}}</td> <td style="text-align:right;">{{$record['winpct']}}%</td></tr>
                        <tr><td>Offense</td><td style="text-align:center;">{{$offense_record['wins']}} - {{$offense_record['losses']}}</td><td style="text-align:right;">{{$offense_record['winpct']}}%</td></tr>
                        <tr><td>Defense</td><td style="text-align:center;">{{$defense_record['wins']}} - {{$defense_record['losses']}}</td><td style="text-align:right;">{{$defense_record['winpct']}}%</td></tr>

                        <tr><td>Red</td><td style="text-align:center;">{{$red_record['wins']}} - {{$red_record['losses']}}</td><td style="text-align:right;">{{$red_record['winpct']}}%</td></tr>
                        <tr><td>Blue</td><td style="text-align:center;">{{$blue_record['wins']}} - {{$blue_record['losses']}}</td><td style="text-align:right;">{{$blue_record['winpct']}}%</td></tr>
                        
                        <tr><td>10-0s</td><td style="text-align:center;">{{$tenzero_record['wins']}} - {{$tenzero_record['losses']}}</td><td style="text-align:right;">{{$tenzero_record['winpct']}}%</td></tr>
                    </tbody>
                </table>


            </div>

            <div class="col-md-5 p-3" style="height:350px;">
                <div id="offense" style="height:100%;"></div>
            </div>

            <div class="col-md-5 p-3" style="height:350px;">
                <div id="defense" style="height:100%;"></div>
            </div>

        </div>


        @livewire('foosball.player-rating-changes', ['player'=> $player->alias])
    </div>


    <script>
        var ratings = <?php echo json_encode($ratings); ?>;
        var allRatings = <?php echo json_encode($allRatings); ?>;
        var allDates = allRatings.map(item => item.date);
        var allOffenseRatings = allRatings.map(item => item.offense);
        var allDefenseRatings = allRatings.map(item => item.defense);
        var dates = ratings.map(item => item.date);
        var offenseRatings = ratings.map(item => item.offense);
        var defenseRatings = ratings.map(item => item.defense);

        data = [
            {
                x: allDates,
                y: allOffenseRatings,
                type: 'scatter',
                mode: 'markers',
                hoverinfo: 'none',
                showlegend: false,
                line: {size: 1, color: '#6c757d'}
            },
            {
                x: dates,
                y: offenseRatings,
                type: 'line',
                mode: 'line',
                hoverinfo: 'none',
                showlegend: false,
                line: {width: 6, color: '#9a2629' }
            }
        ];

        // Define layout input
        var layout = {
            plot_bgcolor: 'transparent',
            paper_bgcolor: 'transparent',
            title: {
                text: 'Offense Rating History',
                x: 0.5,  // Center the title horizontally
                y: 0.95,  // Adjust the vertical position of the title (0.9 is closer to the axes)
            },
            hovermode: 'closest',
            margin: {
                l: 50, // Left margin
                r: 0, // Right margin
                t: 20, // Top margin
                b: 30  // Bottom margin
            },
        };

        var config = {
            displayModeBar: false,
        }
        Plotly.newPlot('offense', data, layout, config);


        data = [
            {
                x: allDates,
                y: allDefenseRatings,
                type: 'scatter',
                mode: 'markers',
                hoverinfo: 'none',
                showlegend: false,
                line: {size: 1, color: '#6c757d'}
            },
            {
                x: dates,
                y: defenseRatings,
                type: 'line',
                mode: 'line',
                hoverinfo: 'none',
                showlegend: false,
                line: {width: 6, color: '#9a2629' }
            }
        ];

        // Define layout input
        var layout = {
            plot_bgcolor: 'transparent',
            paper_bgcolor: 'transparent',
            title: {
                text: 'Defense Rating History',
                x: 0.5,  // Center the title horizontally
                y: 0.95,  // Adjust the vertical position of the title (0.9 is closer to the axes)
            },
            hovermode: 'closest',
            margin: {
                l: 50, // Left margin
                r: 0, // Right margin
                t: 20, // Top margin
                b: 30  // Bottom margin
            },
        };

        var config = {
            displayModeBar: false,
        }
        Plotly.newPlot('defense', data, layout, config);

    </script>

</x-foosball_layout>