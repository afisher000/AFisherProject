<x-foosball_layout>
    <form method="POST" action="/foosball/players">
        @csrf
        <div>
            <label for="alias"> Player alias</label>
            <input type="text" name="alias"/>
        </div>
        <div>
            <label for="fullname"> Player Name</label>
            <input type="text" name="fullname"/>
        </div>
        <div>
            <button>
                Create Player
            </button>
        </div>
    </form>
</x-foosball_layout>