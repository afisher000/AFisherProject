<x-home_layout>

    @php
        $form_entries = ["email"=>"email", "text"=>"password"];
    @endphp

    <div class="container d-flex fustify-content-center align-items-center">
        <div class="bg-light p-5 rounded" style="background-color: rgba(255, 255, 255, 0.8);">
            <form method="POST" action="/users/authenticate">
                @csrf
                <h2> Log in </h2>
                @foreach ($form_entries as $type=>$name)
                    <div class="form-floating mb-3">
                        @php
                            $title = ucwords($name);
                        @endphp
                        @if($errors->has($name))
                            <input type="{{$type}}" name='{{$name}}' value="{{old($name)}}" class="form-control is-invalid" id="{{$name}}">
                            <label for="{{$name}}">{{$title}} - {{ $errors->first($name) }}</label>
                        @else
                            <input type="{{$type}}" name='{{$name}}' value="{{old($name)}}" class="form-control" id="{{$name}}">
                            <label for="{{$name}}">{{$title}}</label>
                        @endif
                    </div>
                @endforeach

                <div>
                    <button class = "btn btn-primary mb-3">Sign In</button>
                </div>
            </form>
        </div>
    </div>

    <div>
        <h4>Don't have an account? <h4>
        <a class = "btn btn-primary mb-3" href="/users/register">Register</a>
    </div>

</x-home_layout>
