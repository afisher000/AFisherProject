<x-misc_layout>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-4  custom-card-container">
            <h2 class="text-center mb-4">Enter Measurement (lbs)</h2>
            <form action="/misc/weights" method="POST">
                @csrf

                <div class="form-floating mb-3">
                    @if($errors->has('weight'))
                        <input type="text" name='weight' value="{{old('weight')}}" class="form-control is-invalid" id="weight">
                        @error('weight')
                            <label style="font-weight:bold;" for="weight">{{$message}}</label>
                        @enderror
                    @else
                        <input class="form-control" type="text" value="{{old('weight')}}" id="weight" name="weight">
                        <label style="font-weight:bold;" for="weight">Weight</label>
                    @endif
                </div>

                <button type="submit" class="btn btn-danger w-100">Submit</button>
            </form>

        </div>


    </div>

    <div class="p-3" style="height:350px;">
        <div id="weight_plot" style="height:100%;"></div>
    </div>

    <script>
        var weights = <?php echo json_encode($weights); ?>;
        var dates = <?php echo json_encode($dates); ?>;

        data = [
            {
                x: dates,
                y: weights,
                type: 'scatter',
                mode: 'markers',
                hoverinfo: 'none',
                showlegend: false,
                line: {size: 1, color: '#6c757d'}
            },
        ];

        // Define layout input
        var layout = {
            hovermode: 'closest',
            margin: {
                l: 50, // Left margin
                r: 0, // Right margin
                t: 20, // Top margin
                b: 30  // Bottom margin
            },
            yaxis: {
                title: 'Weight (lbs)'  // Add your y-axis label here
            },
        };

        var config = {
            displayModeBar: false,
        }
        Plotly.newPlot('weight_plot', data, layout, config);
    </script>
    
</x-misc_layout>