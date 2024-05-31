<x-home_layout>


    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-4">
            <h2 class="text-center mb-4">Confirm Logout</h2>
            <form class='inline nav-link' method='POST' action='/users/logout'>
                @csrf

                <button type="submit" class="btn btn-danger w-100">Logout</button>
            </form>
        </div>
    </div>


    <!--
    <form class='inline nav-link' method='POST' action='/users/logout'>
        @csrf
        <h2> Confirm Logout </h2>
        <div>
            <button class = "btn btn-primary mb-3">Logout</button>
        </div>

    </form>-->
</x-home_layout>