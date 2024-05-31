<x-home_layout>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-4">
            <h2 class="text-center mb-4">Restricted Access</h2>
            <p>This page or operation is restricted to users with admin credentials.</p>
            <a href="/users/login" class="btn btn-danger w-100">Login</a>
            <div class="text-center mt-3">
                <p class="mb-0">Not Admin? <button class="btn btn-link text-danger" onclick="goBack()">Go Back</button>  </p>
            </div>
        </div>
    </div>

    
    <script>
    function goBack() {
        window.history.back();
    }
    </script>
</x-home_layout>