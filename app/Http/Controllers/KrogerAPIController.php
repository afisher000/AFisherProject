<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Price;
use App\Models\Pricecheck;
use App\Services\TokenService;
use Illuminate\Validation\Rule;
use App\Http\Requests\MyFormRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;


class KrogerAPIController extends Controller
{

    public function index(){
        # Return all products in list
        $products = Product::select('id', 'uid', 'description')->get();

        # Return as json
        return response()->json($products);
    }

    public function show($uid){
        # Find product with given uid
        $product = Product::where('uid', $uid)->first();

        # Get prices/saleprices with dates for given uid
        $data = Price::join('pricechecks', 'prices.id_pricecheck', '=', 'pricechecks.id')
            ->select('prices.price', 'pricechecks.date')
            ->where('prices.id_product', $product['id'])
            ->get();

        # Return as json
        return response()->json($data);
    }

}
