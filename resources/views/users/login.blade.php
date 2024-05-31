<x-home_layout>

    @php
        $form_entries = ["email"=>"email", "text"=>"password"];
    @endphp

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-4 custom-card-container">
            <h2 class="text-center mb-4">Login</h2>
            <form method="POST" action="/users/authenticate">
                @csrf

                <div class="form-floating mb-3">
                    @if($errors->has('email'))
                        <input type="text" name='email' value="{{old('email')}}" class="form-control is-invalid" id="email">
                        @error('email')
                            <label for="email" style="font-weight:bold;">Email - {{$message}}</label>
                        @enderror
                    @else
                        <input type="text" name='email' value="{{old('email')}}" class="form-control" id="email">
                        <label style="font-weight:bold;" for="email">Email</label>
                    @endif
                </div>

                <div class="form-floating mb-3">
                    @if($errors->has('password'))
                        <input type="text" name='password' value="{{old('password')}}" class="form-control is-invalid" id="password">
                        @error('password')
                            <label style="font-weight:bold;" for="password">Password - {{$message}}</label>
                        @enderror
                    @else
                        <input type="text" name='password' value="{{old('password')}}" class="form-control" id="password">
                        <label style="font-weight:bold;" for="password">Password</label>
                    @endif
                </div>

                <button type="submit" class="btn btn-danger w-100">Login</button>
            </form>
            <div class="text-center mt-3">
                <p class="mb-0">No account? <a href="/users/register" class="btn btn-link text-danger">Register</a></p>
            </div>
        </div>
    </div>



</x-home_layout>
