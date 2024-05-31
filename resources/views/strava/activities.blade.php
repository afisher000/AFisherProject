<x-strava_layout>
    <!-- <h1> Activity: {{$activity['id']}}</h1>-->
    <?php $attributes = ['id', 'athlete_id', 'elapsed_time', 'name', 'sport_type']; ?>
    <div class="container custom-card-container" style="position:relative;">
        <div class="container custom-card-header">
            <h1>{{$activity->getAthleteName()}}'s {{$activity['sport_type']}} on {{ date('Y-m-d', strtotime($activity['start_date'])) }}</h1>
        </div>
        <div class="custom-card-subheader">
            <h3> {{$activity['name']}} </h3>
        </div>

        <div class="row">
            <div class="col-md-3 p-1">
                <div class="p-4" style="width:100%; height:100%; display:flex; flex-direction: column; justify-content:space-between;">
                    <table style="width:100%;">
                        <tbody>
                            <tr><td>Distance</td><td><?php echo number_format($activity['distance']/1609,1)?> mi </td></tr>
                            <tr>
                                <td>Pace</td>
                                <td>
                                    <?php
                                        $pace = 1/(.03728*$activity['average_speed']);
                                        $minutes = floor($pace);
                                        $seconds = round( ($pace*60) % 60);
                                        $formattedPace = $minutes . ":" . ($seconds < 10 ? "0" : "") . $seconds;
                                        echo $formattedPace
                                    ?> min/mi 
                                </td>
                            <tr>
                            <tr><td>Elapsed Time</td><td><?php echo number_format($activity['elapsed_time']/60, 0) ?> min</td></tr>
                            <tr><td>Elevation Gain</td><td><?php echo number_format($activity['total_elevation_gain']*3.281,0)?> ft </td></tr>

                            <tr><td>ID</td><td>{{$activity['id']}}</td></tr>

                            {{-- <tr>
                                <td colspan="2">  <a class="btn btn-danger" target="_blank" href="https://www.strava.com/activities/{{$activity['id']}}">View with Strava</a></td>
                            </tr>
                            <tr>
                                <td colspan="2"> <a class="btn btn-danger" target="_blank" href="https://connect.garmin.com/modern/activity/{{$activity['id']}}"> View with Garmin</a></td>
                            </tr> --}}
                        </tbody>
                    </table>
                    <table style="width:100%;">
                        <tbody>

                            <tr>
                                <td style="width:50%;">
                                    <form action="/strava/previous_activity/{{$activity['id']}}" method="get" style="display:inline-block; width:100%;">
                                        @csrf
                                        <button class="btn btn-danger" style="width:100%;" type="submit">Previous</button>
                                    </form>
                                </td>
                                <td style="width:50%;">
                                    <form action="/strava/next_activity/{{$activity['id']}}" method="get" style="display:inline-block; width:100%;">
                                        @csrf
                                        <button class="btn btn-danger" style="width:100%;" type="submit">Next</button>
                                    </form>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <form action="/strava/activities" method="get" style="display:inline-block; width:100%;">
                                        @csrf
                                        <button class="btn btn-danger" style="width:100%;" type="submit">All Activities</button>
                                    </form>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-5 p-1">
                <div class="m-3" style="border: 2px solid #000;">
                    <div id="mapID" style="height:300px;"></div>
                </div>
            </div>
            <div class="col-md-4 p-1">
                <div class="p-3">
                    <div id="histID" style="height:300px;"></div>
                </div>
            </div>
        </div>

        <div class="row p-1">

            <div class="col-md-8 p-1" style="height:300px;">
                <div class="p-3">    
                    <label> Y: </label> 
                    <select id="lineSelector" style="height:30px;">
                        <option value="speed">Speed</option>
                        <option value="heartrate">Heart Rate</option>
                        <option value="speedGradeAdj">Speed (Grade Adj.)</option> 
                        <option value="pace">Pace</option>
                        <option value="elevation">Elevation</option>
                    </select>
                    
                    <div id="lineID" style="height:270px;"></div>
                    <!--<div id="lineID"></div>-->
                </div>
            </div>


            <div class="col-md-4 p-1">
                <div class="p-3">
                    <label> X: </label> 
                    <select id="xSelector" style="height:30px;">
                        <option value="grade">Grade</option>
                        <option value="distance">Distance</option>
                    </select>

                    <label> Y: </label> 
                    <select id="ySelector" style="height:30px;">
                        <option value="speed">Speed</option>
                        <option value="heartrate">Heart Rate</option>
                        <option value="pace">Pace</option>
                    </select>

                    <label> Fit: </label> 
                    <input type="checkbox" id="checkbox" style="width:20px; height:20px; vertical-align: -20%;">

                    <div id="scatterID" style="height:270;"></div>
                </div>
            </div>


        </div>

    </div>




   

    <!-- Create splits javascript variable -->
    <script>
        splits = <?php echo json_encode($splits); ?>;
        activity = <?php echo json_encode($activity); ?>;
        matchedActivities = <?php echo json_encode($matched_activities); ?>;
        mapboxgl.accessToken = '{{ env("MAPBOX_PUBLIC_KEY") }}'; 

        console.log(splits);
        console.log(activity);
        // test = '{{env("MAPBOX_PUBLIC_KEY")}}';
        // console.log(test);

        const lineObj = {
            ID: 'lineID',
            selector: 'lineSelector',
        };

        const scatterObj = {
            ID: 'scatterID',
            xSelector: 'xSelector',
            ySelector: 'ySelector',
            checkbox: 'checkbox',
        }

        const mapObj = {
            ID: 'mapID',
        }

        const histObj = {
            ID: 'histID',
        }
        strava_dashboard(splits, activity, lineObj, scatterObj, mapObj, histObj);
    </script>

    </x-strava_layout>