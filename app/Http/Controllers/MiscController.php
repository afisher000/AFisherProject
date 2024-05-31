<?php

namespace App\Http\Controllers;

use App\Models\Weight;
use Illuminate\Http\Request;

class MiscController extends Controller
{
    public function store_weight(Request $request) {
        $formFields = $request->validate([
            'weight' => 'required|numeric|between:100,299',
        ]);

        Weight::create($formFields);

        return redirect('misc/weights');

    }

    public function enter_weight(Request $request) {

        $weightData = Weight::select('weight', 'created_at')->orderBy('created_at', 'asc')->get();
        $weights = $weightData->pluck('weight')->toArray();
        $dates = $weightData->pluck('created_at')->toArray();


        return view('misc/weights', ['weights'=>$weights, 'dates'=>$dates]);
    }
}


