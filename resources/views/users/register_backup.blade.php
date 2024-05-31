<x-home_layout>
    <form method="POST" action="/users">
        @csrf
        <h2> Create User </h2>
        <div class="form-floating mb-3">
            @if($errors->has('name'))
                <input type="text" name='name' value="{{old('name')}}" class="form-control is-invalid" id="name">
                @error('name')
                    <label for="name">Name - {{$message}}</label>
                @enderror
            @else
                <input type="text" name='name' value="{{old('name')}}" class="form-control" id="name">
                <label for="name">Name</label>
            @endif
        </div>
        <div class="form-floating mb-3">
            @if($errors->has('email'))
                <input type="email" name='email' value="{{old('email')}}" class="form-control is-invalid" id="email">
                @error('email')
                    <label for="email">Email - {{$message}}</label>
                @enderror
            @else
                <input type="email" name='email' value="{{old('email')}}" class="form-control" id="email">
                <label for="email">Email</label>
            @endif
        </div>

        <div class="form-floating mb-3">
            @if($errors->has('password'))
                <input type="text" name='password' class="form-control is-invalid" id="password">
                @error('password')
                    <label for="password">Password - {{$message}}</label>
                @enderror
            @else
                <input type="text" name='password' class="form-control" id="password">
                <label for="password">Password</label>
            @endif
        </div>
        <div class="form-floating mb-3">
            @if($errors->has('password_confirmation'))
                <input type="text" name='password_confirmation' class="form-control is-invalid" id="password_confirmation">
                @error('password_confirmation')
                    <label for="password_confirmation">Confirm Password - {{$message}}</label>
                @enderror
            @else
                <input type="text" name='password_confirmation' class="form-control" id="password_confirmation">
                <label for="password_confirmation">Confirm Password</label>
            @endif
        </div>
        <div>
            <button class = "btn btn-primary mb-3">Sign Up</button>
        </div>
    </form>

    <div>
        <h4>Already have an account? <h4>
        <a class = "btn btn-primary mb-3" href="/users/login">Login</a>
    </div>

</x-home_layout>
