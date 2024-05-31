<x-kroger_layout>
    <div class="container card p-4 custom-card-container">
        <div class="custom-card-header">
            <h1>Prices</h1>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Score</th>
                    <th>Item Description</th>
                </tr>
            </thead>
            <tbody>



                @foreach ($product_objects as $product_object)
                    <tr>
                        <td> <a class="color_by_score"> <span class="scoreValue">{{number_format($product_object['score'],2)}}</span> </a></td>
                        <td><a class = "text-danger" href="products/{{$product_object['product_id']}}">{{$product_object['description']}}</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="container", style="padding:20px;">
            <div>
                {{ $product_objects->appends(app('request')->query())->links('pagination::bootstrap-4')}}
            </div>
        </div>  
    </div>



    <!-- Javascript to color text by score -->
    <script>
        function calculateColor(score) {
            const red = Math.round(255 * (2*score-1));
            const green = Math.round(200*(1-(2*score-1)));
            return `rgb(${red}, ${green}, 0)`;
        }

        function updateScoreColors() {
            const scoreElements = document.querySelectorAll('.color_by_score');
            scoreElements.forEach(scoreElement => {
                const scoreValue = scoreElement.querySelector('.scoreValue');
                const score = parseFloat(scoreValue.textContent);
                const color = calculateColor(score);
                console.log(score);
                console.log(color);
                scoreElement.style.color = color;
            });
        }

        updateScoreColors();
    </script>
</x-kroger_layout>