<x-kroger_layout>
    <div class="container card p-4 custom-card-container">
        <div class="custom-card-header">
            <h1>Sale Prices</h1>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Price %</th>
                    <th>Time %</th>
                    <th>Sale %</th>
                    <th>Item Description</th>
                </tr>
            </thead>
            <tbody>



                @foreach ($product_objects as $product_object)
                    @if ($product_object['price_score']>20)
                        <tr>
                            <td> <a class="color_by_score"> <span class="scoreValue">{{$product_object['price_score']}}</span>% </a></td>
                            <td> <a class="color_by_score"> <span class="scoreValue">{{$product_object['time_score']}}</span>%</td>
                            <td> <a class="color_by_score"> <span class="scoreValue">{{$product_object['sale_score']}}</span>%</td>
                            <td><a class = "text-danger" href="products/{{$product_object['product']['id']}}">{{$product_object['product']['description']}}</a></td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

    </div>



    <!-- Javascript to color text by score -->
    <script>
        function calculateColor(score) {
            const red = Math.round(255 * (1-score/100));
            const green = Math.round(200*score/100);
            return `rgb(${red}, ${green}, 0)`;
        }

        function updateScoreColors() {
            const scoreElements = document.querySelectorAll('.color_by_score');
            scoreElements.forEach(scoreElement => {
                const scoreValue = scoreElement.querySelector('.scoreValue');
                const score = parseInt(scoreValue.textContent);
                const color = calculateColor(score);
                console.log(color);
                scoreElement.style.color = color;
            });
        }

        updateScoreColors();
    </script>
</x-kroger_layout>