@if(session()->has('message'))
    <div x-data="{show: true}" x-init="setTimeout( () => show = false, 3000)" x-show="show" 
        style="position:fixed; top: 20px; left: 50%;transform: translateX(-50%);z-index: 1000; color: #198754; padding: 10px 20px; ">
        <p>
            {{session('message')}}
        </p>
    </div>
@endif