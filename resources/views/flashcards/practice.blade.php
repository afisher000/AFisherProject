<style>
.hidden {
    display: none;
}
.flashcardButton {
    background-color: var(--custom-maroon);
    border-color: #6c757d;
    color:var(--custom-off-white);
    height:100px;
    width:300px;
}
.halfFlashcardButton {
    height:100px;
    width:100%;
}

</style>

<x-flashcards_layout>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-4 custom-card-container">
            <h2 class="text-center mb-4">Practice</h2>

            <table style="width:100%; margin-bottom:20px;">
                <tbody>
                    <tr><td>Subject:</td>
                        <td>
                            <select name="subject" id="subjectSelector" style="width:100%;">
                                @foreach($subjects as $subject)
                                    <option value={{$subject}} {{ $subject ===$selectedSubject ? 'selected' : ''}}>{{$subject}}</option>
                                @endforeach

                            </select>
                        </td>
                    </tr>
                    <tr><td>Time Elapsed:</td><td><span id="realTimer" class="hidden">0:00</span><span id="dummyTimer">0:00</span></td></tr>
                    <tr><td>Counter:</td><td><span id="counter">0</span></td></tr>
                </tbody>
            </table>


            <button class='flashcardButton' id='startButton'>Start</button>
            <button class='hidden flashcardButton' id='questionButton' >Question</button>
            <button class='hidden flashcardButton' id='answerButton' >Answer</button>
            <div style="display:flex;  justify-content: space-between;">
                <button class='hidden' id='rightButton' style="background-color:#55ee55; flex-grow:1">Right</button>
                <button class='hidden' id='wrongButton' style="background-color:#ee5555; flex-grow:1">Wrong</button>
                <button class='' id='dummyRightButton' style="background-color:lightgray; flex-grow:1">Right</button>
                <button class='' id='dummyWrongButton' style="background-color:lightgray; flex-grow:1">Wrong</button>
            </div>

        </div>
    </div>
</x-flashcards_layout>


<script>
    var flashcards = <?php echo json_encode($flashcards); ?>;   
    const allFlashcards = flashcards.slice();
    var timerElement = document.getElementById("realTimer");
    var startButton = document.getElementById('startButton')
    var questionButton = document.getElementById('questionButton')
    var answerButton = document.getElementById('answerButton')
    var rightButton = document.getElementById('rightButton')
    var wrongButton = document.getElementById('wrongButton')
    var dummyRightButton = document.getElementById('dummyRightButton')
    var dummyWrongButton = document.getElementById('dummyWrongButton')
    var subjectSelector = document.getElementById('subjectSelector')


    let seconds = 0;
    let rightCounter = 0;
    let allCounter = 0;
    let randomIndex;

    // Setup timer
    function formatTime(seconds) {
            const minutes = Math.floor(seconds / 60);
            const remainingSeconds = seconds % 60;
            return `${minutes}:${remainingSeconds < 10 ? '0' : ''}${remainingSeconds}`;
        }

    // Automatically increase timer every second
    setInterval(function () {
            seconds++;
            timerElement.innerText = formatTime(seconds);
        }, 1000);


    function pickNewFlashcard() {
        console.log(flashcards.length);
        if (flashcards.length<1) {
            timerElement.classList.add('hidden');
            timerText = timerElement.innerText;
            document.getElementById('dummyTimer').classList.remove('hidden');
            document.getElementById('dummyTimer').innerText = timerText;
            questionButton.classList.add('hidden');
            startButton.classList.remove('hidden');
            flashcards = allFlashcards.slice();
        } else {
            // Randomly pick flashcard, update Q/A text
            randomIndex = Math.floor(Math.random() * flashcards.length);
            console.log('Random Index = ' + randomIndex);
            const randomFlashcard = flashcards[randomIndex];
            questionButton.textContent = `Question: ${randomFlashcard['question']}`;
            answerButton.textContent = `Answer: ${randomFlashcard['answer']}`;
        }
    }


    // Selector Filtering callback
    subjectSelector.addEventListener('change', function () {
        const selectedSubject = this.value;
        window.location.href = `/flashcards/practice?subject=${selectedSubject}`;

    })

    // Button callback functions
    startButton.addEventListener('click', function () {
        startButton.classList.add('hidden');
        questionButton.classList.remove('hidden');

        // Start timer
        document.getElementById('dummyTimer').classList.add('hidden');
        document.getElementById('realTimer').classList.remove('hidden');
        seconds = 0;

        // Pick first flashcard
        pickNewFlashcard();
        })

    questionButton.addEventListener('click', function () {
        questionButton.classList.add('hidden');
        dummyRightButton.classList.add('hidden');
        dummyWrongButton.classList.add('hidden');

        answerButton.classList.remove('hidden');
        rightButton.classList.remove('hidden');
        wrongButton.classList.remove('hidden');
    })

    rightButton.addEventListener('click', function () {
        rightButton.classList.add('hidden');
        wrongButton.classList.add('hidden');
        answerButton.classList.add('hidden');

        questionButton.classList.remove('hidden');
        dummyRightButton.classList.remove('hidden');
        dummyWrongButton.classList.remove('hidden');

        rightCounter += 1;
        allCounter += 1;
        document.getElementById('counter').innerText = `${rightCounter}/${allCounter}`;

        // Remove flashcard, pick another
        flashcards.splice(randomIndex, 1);
        pickNewFlashcard();
    })

    wrongButton.addEventListener('click', function () {
        rightButton.classList.add('hidden');
        wrongButton.classList.add('hidden');
        answerButton.classList.add('hidden');

        questionButton.classList.remove('hidden');
        dummyRightButton.classList.remove('hidden');
        dummyWrongButton.classList.remove('hidden');

        allCounter += 1;
        document.getElementById('counter').innerText = `${rightCounter}/${allCounter}`;
        pickNewFlashcard();

    })


</script>