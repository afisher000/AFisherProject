<x-kroger_layout>
    <form method="POST" action="/kroger/products">
        @csrf
        <div>
            @if($errors->has("ID"))
                <input type="text" name='ID' value="{{old('ID')}}" class="form-control is-invalid">
                <label for="ID">Product ID - {{ $errors->first('ID') }}</label>
            @else
                <input type="text" name='ID' value="{{old('ID')}}" class="form-control">
                <label for="ID">Product ID</label>
            @endif
        </div>
        <div>
            <button>
                Add to List?
            </button>
        </div>
    </form>

</x-kroger_layout>