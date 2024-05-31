<div>
    <div class="p-3">
        <div>
            <h3> Filter Results </h3>

            
            <label>Color</label>
            <select wire:model="color" wire:change="refresh">
                <option value="all">All</option>
                <option value="red">Red</option>
                <option value="blue">Blue</option>
            </select>

            <label>Side</label>
            <select wire:model="side" wire:change="refresh">
                <option value="all">All</option>
                <option value="offense">Offense</option>
                <option value="defense">Defense</option>
            </select>

            <label>Outcome</label>
            <select wire:model="outcome" wire:change="refresh">
                <option value="all">All</option>
                <option value="win">Win</option>
                <option value="loss">Loss</option>
            </select>
        </div>

        <div class="row">
            <div class="col-md-4 p-3" style="height:350px;">
                <div id="scatter-plot" wire:ignore style="height:100%;"></div>
            </div>

            <div class="col-md-4 p-3" style="height:350px;">
                <div id="histogram" wire:ignore  style="height:100%;"></div>
            </div>

            <div class="col-md-4 p-3" style="height:350px;">
                <div id="teammatechart" wire:ignore style="height:100%;"></div>
            </div>
        </div>
    </div>
    

    <script>

        // Call from livewire
        Livewire.on('refreshJS', (collections) => {
            createFigures(collections[0]);
        })

        function createFigures(collections) {
            var results = collections['results'];
            var filteredResults = collections['filteredResults'];
            var teammateResults = collections['teammateResults'];

            var teammates = teammateResults.map(item => item.teammate);
            var teammateRatingChange = teammateResults.map(item=>item.mean_rating_change)
            var teammateRatingChangeStd = teammateResults.map(item=>item.std_rating_change)

            var dates = results.map(item => item.date);
            var ratingChanges= results.map(item => item.rating_change);

            var filteredDates = filteredResults.map(item => item.date);
            var filteredRatingChanges= filteredResults.map(item => item.rating_change);
            var filteredMean = calcAverage(filteredRatingChanges);
            var filteredStd = calcStd(filteredRatingChanges);

            // Create Teammate plot
            var data = [
                {
                    x: teammates,
                    y: teammateRatingChange,
                    type: 'scatter',
                    error_y: {
                        type: 'data',
                        array: teammateRatingChangeStd,
                        visible: true,
                    }
                },
            ]

            var layout = {
                plot_bgcolor: 'transparent',
                paper_bgcolor: 'transparent',
                title: 'Teammate Results',
                yaxis: { title: 'Avg. Rating Change' },
                margin: {
                    l: 50, // Left margin
                    r: 10, // Right margin
                    t: 50, // Top margin
                    b: 40  // Bottom margin
                },
            };

            var config = {
                displayModeBar: false,
            }

            Plotly.newPlot('teammatechart', data, layout, config);

            // Create scatter plot
            var data = [
                {
                    x: dates,
                    y: ratingChanges,
                    name: 'all',
                    type: 'scatter',
                    mode: 'markers',
                    hoverinfo: 'none',
                    showlegend: false,
                    marker: { size: 8, color: '#6c757d' }
                }, 
                {
                    x: filteredDates,
                    y: filteredRatingChanges,
                    name: 'filtered',
                    type: 'scatter',
                    mode: 'markers',
                    hoverinfo: 'none',
                    showlegend: false,
                    marker: { size: 8, color: '#9a2629' }
                }, 
            ];

            var layout = {
                plot_bgcolor: 'transparent',
                paper_bgcolor: 'transparent',
                title: 'Rating Change History',
                yaxis: { title: 'Rating Change' },
                margin: {
                    l: 50, // Left margin
                    r: 10, // Right margin
                    t: 50, // Top margin
                    b: 40  // Bottom margin
                },
            };


            var config = {
                displayModeBar: false,
            }

            Plotly.newPlot('scatter-plot', data, layout, config);

            // Create histogram
            var data = [
                {
                    x: ratingChanges,
                    xbins: {start:-40, end:40, size:1},
                    name: 'all',
                    type: 'histogram', 
                    hoverinfo: 'none',
                    showlegend: false,
                    marker: {color: '#6c757d' }
                },
                {
                    x: filteredRatingChanges,
                    xbins: {start:-40, end:40, size:1},

                    name: 'filtered',
                    type: 'histogram', 
                    hoverinfo: 'none',
                    showlegend: false,
                    marker: {color: '#9a2629' }
                },
            ]

            var layout = {
                plot_bgcolor: 'transparent',
                paper_bgcolor: 'transparent',
                barmode: "overlay",
                title: `Mean=${filteredMean.toFixed(1)}, Std=${filteredStd.toFixed(1)}`,
                yaxis: { title: 'Counts' },
                xaxis: { title: 'Rating Change'},
                margin: {
                    l: 50, // Left margin
                    r: 10, // Right margin
                    t: 50, // Top margin
                    b: 40  // Bottom margin
                },
            };
            var config = {
                displayModeBar: false,
            }
            Plotly.newPlot('histogram', data, layout, config);
        }
    </script>
</div>


