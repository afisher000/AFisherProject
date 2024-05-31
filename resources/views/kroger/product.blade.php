<x-kroger_layout>

    <div class="container custom-card-container p-4">
        <div class="container" style="padding:20px;">
            <h1>{{$product['description']}}</h1>
        </div>

        <div class="row">
            <div class="col-md-2" >
                <img src="{{$image_url}}" class="img-fluid" style="height:200px; width:200px; border:2px solid black;">
            </div>
            <div class="col-md-2">
                
                <p> Average Price: ${{number_format($product['mean_price'], 2)}}</p>
                <p> Current Price: ${{number_format($product['price'], 2)}}</p>
                <p> Sale Score: {{number_format($product['score'], 2)}}</p>


                <form action="{{$product['id']}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="product_id" value={{$product['id']}}>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>


            <div class="col-md-4 p-3" style="height:350px;">
                <div id="price-plot" style="height:100%;, width:100%"></div>
            </div>

            <div class="col-md-4 p-3" style="height:350px;">
                <div id="hist-plot" style="height:100%; width:100%" ></div>
            </div>
    
        </div>
    </div>



    <script>
        prices_objects = <?php echo json_encode($price_entries); ?>;
        var dates = prices_objects.map(prices_object => prices_object['date']);
        var prices = prices_objects.map(prices_object => prices_object['price']);

        //Historical Plot
        var data = [{
            x: dates,
            y: prices,
            type: 'line',
            showlegend: false,
        }];

        var layout = {
            plot_bgcolor: 'transparent',
            paper_bgcolor: 'transparent',
            xaxis: { title: 'Date'},
            yaxis: { title: 'Price', range:[0, 1.2*calcMax(prices)]},
            title: 'Historical Price',
            margin: {
                l: 50, // Left margin
                r: 0, // Right margin
                t: 50, // Top margin
                b: 50  // Bottom margin
            },
        };
        var config = {
            displayModeBar: false,
        }
        Plotly.newPlot('price-plot', data, layout, config);



        // Histogram
        var data = [
            {
                x: prices,
                type: 'histogram', 
                hoverinfo: 'none',
                showlegend: false,
                marker: {color: '#9a2629' }
            },
        ]

        var layout = {
            plot_bgcolor: 'transparent',
            paper_bgcolor: 'transparent',
            title: 'Price Distribution',
            yaxis: { title: 'Weeks' },
            xaxis: { title: 'Price'},
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
        Plotly.newPlot('hist-plot', data, layout, config);
    </script>

</x-kroger_layout>