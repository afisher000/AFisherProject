<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Price;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\TokenService;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\MyFormRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class KrogerController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin')->only(['destroy', 'store', 'update']);
    }

    public function index() {
        // Get subtables for last_price and mean_price
        $lastSubTable = Price::select('product_id', DB::raw('MAX(date) as max_date'))->groupBy('product_id');
        $meanSubTable = Price::select('product_id', DB::raw('avg(price) as mean_price'))->groupBy('product_id');

        // Use joins to get description, and score
        $product_objects = Price::select('prices.product_id', 'price')
            ->joinSub($meanSubTable, 'mean_prices', function ($join) {
                $join->on('prices.product_id', '=', 'mean_prices.product_id');
            })
            ->joinSub($lastSubTable, 'latest_prices', function ($join) {
                $join->on('prices.product_id', '=', 'latest_prices.product_id');
                $join->on('prices.date', '=', 'latest_prices.max_date');
            })
            ->join('products', 'products.id', '=', 'prices.product_id')
            ->select('products.description', DB::raw('prices.price/mean_prices.mean_price as score'), 'prices.product_id', 'prices.price', 'mean_prices.mean_price')
            ->orderBy('score', 'asc')
            ->paginate(10);

        # Pass current products in database to kroger/index.blade.php
        return view('/kroger/index', ['product_objects' => $product_objects]);
    }

    public function show($product_id) {
        // Get subtables for last_price and mean_price
        $lastSubTable = Price::select('product_id', DB::raw('MAX(date) as max_date'))->groupBy('product_id');
        $meanSubTable = Price::select('product_id', DB::raw('avg(price) as mean_price'))->groupBy('product_id');

        // Use joins to get description, and score
        $product = Price::select('prices.product_id', 'price')
            ->joinSub($meanSubTable, 'mean_prices', function ($join) {
                $join->on('prices.product_id', '=', 'mean_prices.product_id');
            })
            ->joinSub($lastSubTable, 'latest_prices', function ($join) {
                $join->on('prices.product_id', '=', 'latest_prices.product_id');
                $join->on('prices.date', '=', 'latest_prices.max_date');
            })
            ->join('products', 'products.id', '=', 'prices.product_id')
            ->select('products.description', DB::raw('prices.price/mean_prices.mean_price as score'), 'prices.product_id', 'prices.price', 'mean_prices.mean_price')
            ->where('products.id', $product_id)
            ->get();

        # Get price history
        $price_entries = Price::where('product_id', $product_id)->orderBy('date', 'desc')->get()->toArray();

        # Get product image_url (should have in database for future)
        $headers = [
            'Authorization' => 'Bearer '.TokenService::getKrogerToken(),
            'Cache-Control' => 'no-cache',
        ];
        $params = [
            'filter.locationId' => '70300044',
            'filter.productId' => str_pad($product_id, 13, '0', STR_PAD_LEFT),
        ];
        $endpoint = 'https://api.kroger.com/v1/products/?';
        $response = Http::withHeaders($headers)->get($endpoint, $params);
        $result = $response->json()['data'][0];
        $image_url = $result['images'][0]['sizes'][1]['url'];



        # Return product data to kroger/product.blade.php
        return view('/kroger/product', [
            'product' => $product[0],
            'price_entries' => $price_entries,
            'image_url' => $image_url,
        ]);
    }



    public function create($uid) {
        # Query product data for specific ralphs location
        $headers = [
            'Authorization' => 'Bearer '.TokenService::getKrogerToken(),
            'Accept' => 'application/json',
        ];
        $endpoint = 'https://api.kroger.com/v1/products/'.$uid.'?filter.locationId=70300044';
        $response = Http::withHeaders($headers)->get($endpoint);

        # Pass product data to kroger/create.blade.php
        return view('/kroger/create', ['product' => $response->json()['data']]);
    }

    public function search_results(Request $request) {
        # Validate search query from kroger/search.blade.php
        $formFields = $request->validate([
            'query'=>'required'
        ]);
        $query = $formFields['query'];

        # Query Kroger API for related products (filter by location)
        $headers = [
            'Authorization' => 'Bearer '.TokenService::getKrogerToken(),
            'Cache-Control' => 'no-cache',
        ];
        $endpoint = 'https://api.kroger.com/v1/products/?filter.term='.$query.'&filter.locationId=70300044';
        $response = Http::withHeaders($headers)->get($endpoint);
        $results = $response->json()['data'];
        // ddd($results);

        # Return items as input to kroger/search.blade.php
        return view('/kroger/search', ['items' => $results, 'prevQuery' => $query]);
    }

    public function store(Request $request) {

        # Validate form fields from kroger/create.blade.php
        $formFields = $request->validate([
            'id'=>'required|numeric|unique:products,id',
            'description'=>'required',
        ]);

        # Create new product
        Product::create($formFields);

        # Redirect to product list
        return redirect('/kroger/search');
    }

    public function destroy($product_id) {
        # Find product with given uid
        $product = Product::where('id', $product_id)->first();

        # Delete product
        $product->delete();

        # Redirect to product list
        return redirect('kroger/products');
    }
}
