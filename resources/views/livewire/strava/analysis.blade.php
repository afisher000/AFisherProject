<div>

    <div class="container">
        <!-- Form to apply filters -->
        <label for="athlete">Athlete:</label>
        <select wire:model="athlete" wire:change="refresh"  name="athlete" id="athlete">
            <option value="all">All</option>
            <option value="Andrew">Andrew</option>
            <option value="Travis">Travis</option>
        </select>

        <label for="sport_type">Sport Type:</label>
        <select wire:model="sport_type" wire:change="refresh"  name="sport_type" id="sport_type">
            <option value="">All</option>
            <option value="Run" >Run</option>
            <option value="AlpineSki">AlpineSki</option>
            <option value="Ride">Ride</option>
        </select>
        
        <label for="start_date">Start Date:</label>
        <input wire:model="start_date" wire:change="refresh"  type="date" name="start_date" id="start_date" value="">
        <label for="end_date">End Date:</label>
        <input wire:model="end_date" wire:change="refresh"  type="date" name="end_date" id="end_date" value="">
    </div>



    <div class="row">

        <div class="col-md-6 p-1">
            <div class="m-3">
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
                <div id="histID" wire:ignore style="height:370px;"></div>
            </div>
        </div>



        {{-- Historical Stats --}}
        <div class="col-md-4 p-1">
            <div class="p-4">
                <div style="text-align: center">
                    <h3>Stats for {{$athlete}}</h3>
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
                            <td><?php echo number_format($allActivities->count(), 0)?></td> 
                            <td><?php echo number_format($yearActivities->count(), 0)?></td> 
                            <td><?php echo number_format($monthActivities->count(), 0)?></td> 
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
                            <td>Elevation (k ft)</td> 
                            <td><?php echo number_format($allActivities->sum('total_elevation_gain')/1000,0)?></td>
                            <td><?php echo number_format($yearActivities->sum('total_elevation_gain')/1000,0)?></td>
                            <td><?php echo number_format($monthActivities->sum('total_elevation_gain')/1000,1)?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>



    </div>


    <!-- Create splits javascript variable -->
    <script>
        var heatmapObj;
        var histObj;

        Livewire.on('refreshJS', (collections) => {
            createMyFigures(collections[0]);
        })


        function createMyFigures(collection) {
            var dailyDistances = collection['dailyDistances'];
            var dailyTimes = collection['dailyTimes'];

            heatmapObj = {
                ID: 'histID',
                distances: dailyDistances,
                times: dailyTimes,
            };
            histObj = {
                ID: 'histID',
                distances: dailyDistances,
                times: dailyTimes,
                window: 'window',
                ySelector: 'histySelector',
            };
            
            strava_analysis_dashboard(heatmapObj, histObj);
            return
        }


        
    </script>





</div>
