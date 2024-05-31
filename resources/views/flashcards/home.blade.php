<x-flashcards_layout>
    <div class="container-fluid custom-homepage-container">


        <div class="p-4 custom-card-container">
            <h1> Flashcard Projects</h1>
            <h3> Motivation </h3>
                <p>
                    Simple "flashcard" pages for memorization.
                <p>

            <h3>Goals</h3>
                <ul>
                    <li> Learn the squares</li>
                        <ul>
                            <li>Can use (a+b)(a-b) = a<sup>2</sup> - b<sup>2</sup> to do quite a bit of mental math/accurate estimation.</li>
                            <li>eg 37 &middot; 41 = 39<sup>2</sup> - 2<sup>2</sup>
                        </ul>
                    <li> Learn time/distance conversion
                </ul>
            </p>

            <h3> Structure </h3>
                <h6>Squares</h6>
                    <p> 
                        A simple webpage to practice squares for different ranges. 
                    </p>

            <h3> Future work </h3>
            <ul>
                <li>Add Correct/Incorrect feedback to keep track of what you need more practice on</li>
                    <ul>
                        <li>Save stats to database. Can show progress over time.</li>
                <li>Save min/max values for user so these are not reset to defaults if page reloaded.</li>
            </ul>
        </div>

        <div style="padding:10;">
            <img class="custom-screenshot" src="{{ asset('images/screenshots/stravaActivity.png') }}" alt="Image 1" width="0" height='auto'> 
            <img class="custom-screenshot" src="{{ asset('images/screenshots/stravaAnalysis.png') }}" alt="Image 1" width="0" height='auto'> 
        </div>
    </div>
</x-flashcards_layout>