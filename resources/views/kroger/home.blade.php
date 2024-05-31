<x-kroger_layout>


    <div class="container-fluid" style="display:flex">
        <div style="padding:10;">
            <img class="custom-screenshot" src="{{ asset('images/screenshots/krogerPrices.png') }}" alt="Image 1" width="500" height='auto'> 
            <img class="custom-screenshot" src="{{ asset('images/screenshots/krogerProduct.png') }}" alt="Image 1" width="400" height='auto'> 
        </div>

        <div class="p-4 custom-card-container">

            <h1> Kroger Project</h1>
            <h3> Motivation </h3>
                <p>
                    Ever since I discovered Subways never ending $6 footlong promocodes (always something like FL599, 599FTL, FOOTLONG599), I wondered if tracking grocery sales would be beneficial. 
                    As Kroger has a free API for prices, I setup these pages to download the weekly prices and create a personalizes sales tracker. 
                    While I don't expect to save enough money to make up for the time on this project, I might find similar applications in the future. 
                </p>

            <h3>Pages</h3>
                <h6>Prices</h6>
                    <p>This page lists scores (current_price/mean(all_prices)) for all items in my watchlist.</p>
                <h6>Add Products</h6>
                    <p>This page adds next products to the watchlist.

            <h3>Goals</h3>
                <ul>
                    <li> Run scheduled scripts to download prices from Kroger APIs. </li>
                    <li> Make a quick interface to see what the best deals are </li>
                </ul>


            <h3>Implemented</h3>
            <ul>
                <li> Download daily prices for watchlist.</li>
                <li> Add page to update watchlist </li>
            </ul>

            <h3> Future work </h3>
            <ul>
                <li>Add shopping list feature</li>
                <li>Schedule/write script to send custom weekly deals</li>
            </ul>
        </div>
    </div>
</x-kroger_layout>