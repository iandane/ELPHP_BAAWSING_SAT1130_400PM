<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'reservation_date' => 'required|date',
            'reservation_time' => 'required',
            'party_size' => 'required|integer|min:1',
        ]);

        $reservation = auth()->user()->reservations()->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Reservation created successfully',
            'data' => $reservation->load('restaurant'),
        ], 201);
    }

    public function index()
    {
        $reservations = auth()->user()->reservations()->with('restaurant')->get();

        \Log::info('Reservations retrieved', ['reservations' => $reservations]);

        if ($reservations->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No reservations found',
                'data' => []
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Reservations retrieved',
            'data' => $reservations
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        if ($reservation->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to update this reservation',
            ], 403);
        }

        $validated = $request->validate([
            'reservation_date' => 'required|date',
            'reservation_time' => 'required',
            'party_size' => 'required|integer|min:1',
        ]);

        $reservation->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Reservation updated successfully',
            'data' => $reservation->load('restaurant')
        ], 200);
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        if ($reservation->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to delete this reservation',
            ], 403);
        }

        $reservation->delete();

        return response()->json([
            'success' => true,
            'message' => 'Reservation deleted successfully'
        ], 200);
    }
}