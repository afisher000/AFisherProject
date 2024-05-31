<style>
    /* Adjust the height of the button and input field */
    .container form button,
    .container form input {
        height: 40px;
        vertical-align: middle;
    }
</style>


<x-kroger_layout>
    <div class="container card p-4 custom-card-container" >
        <div class="container custom-card-header">
            <h1>Search Products</h1>
        </div>


        <div class="container">
            <form action="/kroger/search_results" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Search</button>
                <input type="text" id="search" name="query" placeholder="milk" value="{{ $prevQuery ?? '' }}">
            </form>
        </div>


        @isset($items)
        <div class="container custom-card-header">
            <h1>Results</h1>
        </div>

        <div class="container">
        
            @foreach ($items as $item)
                <div class="card-body d-flex mb-5", style="height:100px;">
                    <img src="{{$item['images'][0]['sizes'][0]['url']}}" width="100px" height="100px" style="margin: 0px 10px 0px 0px;">
                    <div style="height:100px;">
                        <h5 class="card-title">{{$item['brand']}}</h5>
                        <p class="card-text">{{$item['description']}}</p>
                        <form action="/kroger/products" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{(int)$item['upc']}}">
                            <input type="hidden" name="description" value="{{$item['description']}}">
                            <button type="submit" class="btn btn-success">Add</button>
                        </form>
                    </div>
                </div>
            @endforeach
            
        </div>
        @endisset
    </div>

</x-kroger_layout>