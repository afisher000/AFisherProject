<x-home_layout>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-4 custom-card-container">
            <h2 class="text-center mb-4">Register</h2>
            <form method="POST" action="/users">
                @csrf

                <div class="form-floating mb-3">
                    @if($errors->has('name'))
                        <input type="text" name='name' value="{{old('name')}}" class="form-control is-invalid" id="name">
                        @error('name')
                            <label style="font-weight:bold;" for="name">Name - {{$message}}</label>
                        @enderror
                    @else
                        <input type="text" name='name' value="{{old('name')}}" class="form-control" id="name">
                        <label style="font-weight:bold;" for="name">Name</label>
                    @endif
                </div>
                <div class="form-floating mb-3">
                    @if($errors->has('email'))
                        <input type="email" name='email' value="{{old('email')}}" class="form-control is-invalid" id="email">
                        @error('email')
                            <label style="font-weight:bold;" for="email">Email - {{$message}}</label>
                        @enderror
                    @else
                        <input type="email" name='email' value="{{old('email')}}" class="form-control" id="email">
                        <label style="font-weight:bold;" for="email">Email</label>
                    @endif
                </div>
        
                <div class="form-floating mb-3">
                    @if($errors->has('password'))
                        <input type="text" name='password' class="form-control is-invalid" id="password">
                        @error('password')
                            <label style="font-weight:bold;" for="password">Password - {{$message}}</label>
                        @enderror
                    @else
                        <input type="text" name='password' class="form-control" id="password">
                        <label style="font-weight:bold;" for="password">Password</label>
                    @endif
                </div>
                <div class="form-floating mb-3">
                    @if($errors->has('password_confirmation'))
                        <input type="text" name='password_confirmation' class="form-control is-invalid" id="password_confirmation">
                        @error('password_confirmation')
                            <label style="font-weight:bold;" for="password_confirmation">Confirm Password - {{$message}}</label>
                        @enderror
                    @else
                        <input type="text" name='password_confirmation' class="form-control" id="password_confirmation">
                        <label style="font-weight:bold;" for="password_confirmation">Confirm Password</label>
                    @endif
                </div>

                <button type="submit" class="btn btn-danger w-100">Register</button>
            </form>
            <div class="text-center mt-3">
                <p class="mb-0">Already have an account? <a href="/users/login" class="btn btn-link text-danger">Login</a></p>
            </div>
        </div>
    </div>

</x-home_layout>