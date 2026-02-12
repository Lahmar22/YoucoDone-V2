<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display user's reservations.
     */
    public function index()
    {
        $reservations = Auth::user()->reservations()
            ->with('restaurant')
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();

        return view('client.reservations.index', compact('reservations'));
    }

    /**
     * Store a new reservation.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'number_of_people' => 'required|integer|min:1|max:12',
            'special_request' => 'nullable|string|max:500',
        ]);

        // Additional validation with Carbon
        $reservationDateTime = \Carbon\Carbon::parse($validated['date'] . ' ' . $validated['time']);

        // 1. Check if the reservation is in the past
        if ($reservationDateTime->isPast()) {
            return redirect()->back()
                ->withErrors(['time' => 'Cannot make a reservation in the past.'])
                ->withInput();
        }

        // 2. Check if the reservation is too far in the future (max 3 months)
        if ($reservationDateTime->gt(\Carbon\Carbon::now()->addMonths(3))) {
            return redirect()->back()
                ->withErrors(['date' => 'Reservations can only be made up to 3 months in advance.'])
                ->withInput();
        }

        // 3. Check if the reservation is at least 2 hours in the future
        if ($reservationDateTime->lt(\Carbon\Carbon::now()->addHours(2))) {
            return redirect()->back()
                ->withErrors(['time' => 'Reservations must be made at least 2 hours in advance.'])
                ->withInput();
        }

        // 4. Validate business hours (assuming 10:00 AM - 11:00 PM)
        $hour = $reservationDateTime->hour;
        if ($hour < 10 || $hour >= 23) {
            return redirect()->back()
                ->withErrors(['time' => 'Reservations are only available between 10:00 AM and 11:00 PM.'])
                ->withInput();
        }

        // 5. Check for overlapping reservations (same restaurant, similar time slot)
        // Consider reservations within 2 hours as conflicting
        $startWindow = $reservationDateTime->copy()->subHours(2);
        $endWindow = $reservationDateTime->copy()->addHours(2);

        $hasConflict = Reservation::where('restaurant_id', $validated['restaurant_id'])
            ->where('user_id', Auth::id())
            ->where('date', $validated['date'])
            ->where(function ($query) use ($validated, $startWindow, $endWindow) {
                $query->whereBetween('time', [
                    $startWindow->format('H:i:s'),
                    $endWindow->format('H:i:s')
                ]);
            })
            ->exists();

        if ($hasConflict) {
            return redirect()->back()
                ->withErrors(['time' => 'You already have a reservation at this restaurant within 2 hours of this time. Please choose a different time slot.'])
                ->withInput();
        }

        // 6. Check restaurant capacity (optional - checks total reservations for this time slot)
        $restaurant = \App\Models\Restaurant::find($validated['restaurant_id']);

        $totalGuestsAtTime = Reservation::where('restaurant_id', $validated['restaurant_id'])
            ->where('date', $validated['date'])
            ->where(function ($query) use ($validated, $startWindow, $endWindow) {
                $query->whereBetween('time', [
                    $startWindow->format('H:i:s'),
                    $endWindow->format('H:i:s')
                ]);
            })
            ->sum(\DB::raw('CAST(number_of_people AS INTEGER)'));

        if (($totalGuestsAtTime + $validated['number_of_people']) > $restaurant->capacity) {
            return redirect()->back()
                ->withErrors(['time' => 'Sorry, the restaurant is fully booked for this time slot. Please choose another time.'])
                ->withInput();
        }

        // All validations passed, create the reservation
        Reservation::create([
            'user_id' => Auth::id(),
            'restaurant_id' => $validated['restaurant_id'],
            'date' => $validated['date'],
            'time' => $validated['time'],
            'number_of_people' => $validated['number_of_people'],
        ]);

        return redirect()->route('reservations.index')
            ->with('success', 'Reservation created successfully! We look forward to serving you on ' .
                $reservationDateTime->format('F j, Y \a\t g:i A') . '.');
    }
}
