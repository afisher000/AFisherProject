<x-strava_layout>
    <?php $attributes = ['id', 'athlete_id', 'elapsed_time', 'name', 'sport_type']; ?>
    <div class="container custom-card-container" style="position:relative;">
        <div class="container custom-card-header">
            <h1> Strava Analysis </h1>
        </div>

        <div class="container">
            <!-- Form to apply filters -->
            <form action="{{ url()->current() }}" method="get" style="display:inline-block;">
                @csrf
                <label for="athlete">Athlete:</label>
                <select name="athlete" id="athlete">
                    <option value="">All</option>
                    <option value="Andrew" {{$prevFilters['athlete'] === 'Andrew' ? 'selected' : ''}}>Andrew</option>
                    <option value="Travis" {{$prevFilters['athlete'] === 'Travis' ? 'selected' : ''}}>Travis</option>
                    <!-- Add more options as needed -->
                </select>

                <label for="sport_type">Sport Type:</label>
                <select name="sport_type" id="sport_type">
                    <option value="">All</option>
                    <option value="Run" {{ $prevFilters['sport_type'] === 'Run' ? 'selected' : '' }}>Run</option>
                    <option value="AlpineSki" {{ $prevFilters['sport_type']==='AlpineSki' ? 'selected' : ''}}>AlpineSki</option>
                    <option value="Ride" {{ $prevFilters['sport_type']==='Ride' ? 'selected' : ''}}>Ride</option>
                    <!-- Add more options as needed -->
                </select>
                
                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" id="start_date" value="{{ $prevFilters['start_date'] }}">
                <label for="end_date">End Date:</label>
                <input type="date" name="end_date" id="end_date" value="{{ $prevFilters['end_date'] }}">
                <!-- Add more filters here... -->

                <button type="submit">Apply Filters</button>
            </form>

            <!-- Form to clear filters -->
            <form action="/strava/analysis" method="get" style="display:inline-block;">
                @csrf
                <button type="submit">Clear Filters</button>
            </form>
        </div>



        <div class="row">

            <div class="col-md-6 p-1">
                <div class="m-3" style="border: 2px solid #000;">
                    <label> Window: </label> 
                    <select id="window" style="height:30px;">
                        <option value="-1">None</option>
                        <option value="30">Month</option>
                        <option value="90" >3 Months</option>
                        <option value="180">6 Months</option>
                        <option value="356">Year</option>
                    </select>
                    <label> Data: </label> 
                    <select id="histySelector" style="height:30px;">
                        <option value="distance">Distance</option>
                        <option value="time">Time</option>
                    </select>
                    <div id="histID" style="height:370px;"></div>
                </div>
            </div>



            {{-- Historical Stats --}}
            <div class="col-md-4 p-1">
                <div class="p-4">
                    <div style="text-align: center">
                        @if (empty($prevFilters['sport_type']))
                            <h3>Stats for {{ $prevFilters['athlete'] }}</h3>
                        @else
                            <h3>Stats for {{ $prevFilters['athlete'] }}'s {{ $prevFilters['sport_type'] }}s</h3>
                        @endif
                    </div>

                    <table style="width:100%;">
                        <tbody>
                            <tr>
                                <th></th>
                                <th> All Time </th>
                                <th> Past Year </th> 
                                <th> Past Month </th>
                            </tr>
                            <tr>
                                <td>Activities</td> 
                                <td><?php echo $allActivities->count()?></td> 
                                <td><?php echo $yearActivities->count()?></td> 
                                <td><?php echo $monthActivities->count()?></td> 
                            </tr>
                            <tr>
                                <td>Distance (mi)</td> 
                                <td><?php echo number_format($allActivities->sum('distance')/1609,0)?></td>
                                <td><?php echo number_format($yearActivities->sum('distance')/1609,0)?></td>
                                <td><?php echo number_format($monthActivities->sum('distance')/1609,0)?></td>
                            </tr>
                            <tr>
                                <td>Time (hr)</td> 
                                <td><?php echo number_format($allActivities->sum('elapsed_time')/3600,0)?></td>
                                <td><?php echo number_format($yearActivities->sum('elapsed_time')/3600,0)?></td>
                                <td><?php echo number_format($monthActivities->sum('elapsed_time')/3600,1)?></td>
                            </tr>
                            <tr>
                                <td>Elevation (ft)</td> 
                                <td><?php echo number_format($allActivities->sum('total_elevation_gain'),0)?></td>
                                <td><?php echo number_format($yearActivities->sum('total_elevation_gain'),0)?></td>
                                <td><?php echo number_format($monthActivities->sum('total_elevation_gain'),0)?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>



        </div>

        <div class="row p-1">

        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="p-3">
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3">
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3">

                </div>
            </div>

        </div>
        </div>
    </div>




   

    <!-- Create splits javascript variable -->
    <script>
        dailyDistances = <?php echo json_encode($dailyDistances); ?>;

        const heatmapObj = {
            ID: 'histID',
            data: dailyDistances,
        }

        const histObj = {
            ID: 'histID',
            data: dailyDistances,
            window: 'window',
            ySelector: 'histySelector',
        }

        strava_analysis_dashboard(heatmapObj, histObj)



        function saveSelectors() {
            const window = document.getElementById('window');
            const histYSelector = document.getElementById('histYSelector');

            localStorage.setItem('windowValue', window.value);
            localStorage.setItem('histYSelectorValue', histYSelector.value);
        }

        function loadSelectors() {
            const window = document.getElementById("window");
            const histYSelector = document.getElementById("histYSelector");

            window.value = localStorage.getItem("windowValue") || "-1";
            histYSelector.value = localStorage.getItem("histYSelectorValue") || "distance";
        }

        // Event listener for changes in selectors
        document.getElementById("window").addEventListener("change", saveSelectors);
        document.getElementById("histYSelector").addEventListener("change", saveSelectors);

        // Load saved values on page load
        window.addEventListener("load", loadSelectors);
    </script>




    </x-strava_layout>