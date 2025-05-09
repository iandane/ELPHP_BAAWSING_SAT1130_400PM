<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::with('reservations')->get();
        \Log::info('Restaurants retrieved', ['restaurants' => $restaurants->toArray()]);
        if ($restaurants->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No restaurants found',
                'data' => []
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Restaurants retrieved',
            'data' => $restaurants
        ], 200);
    }
}