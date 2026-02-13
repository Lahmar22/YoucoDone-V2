<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Payment;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

use Illuminate\Http\Request;

class PaypalController extends Controller
{
    public function createPayment(Reservation $reservation)
    {
    // Prevent double payment
    if ($reservation->payment && $reservation->payment->status === 'completed') {
        return redirect()->back()->with('success', 'This reservation is already paid.');
    }

    $provider = new PayPalClient;
    $provider->setApiCredentials(config('paypal'));
    $provider->getAccessToken();

    
    $amount = $reservation->price ?? 50.00; 

    $response = $provider->createOrder([
        "intent" => "CAPTURE",
        "purchase_units" => [
            [
                "reference_id" => $reservation->id,
                "amount" => [
                    "currency_code" => "USD",
                    "value" => number_format($amount, 2, '.', '')
                ]
            ]
        ],
        "application_context" => [
            "return_url" => route('payment.success', $reservation->id),
            "cancel_url" => route('payment.cancel', $reservation->id),
        ]
    ]);

    if (isset($response['id']) && isset($response['links'])) {

        // Save payment as pending
        Payment::create([
            'reservation_id' => $reservation->id,
            'user_id' => auth()->id(),
            'transaction_id' => $response['id'],
            'payment_method' => 'paypal',
            'amount' => $amount,
            'currency' => 'MAD',
            'status' => 'pending',
            'payment_details' => $response,
        ]);

        foreach ($response['links'] as $link) {
            if ($link['rel'] == 'approve') {
                return redirect()->away($link['href']);
            }
        }
    }

    return redirect()->back()->with('error', 'Something went wrong.');
    }

    public function success(Request $request, Reservation $reservation)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->token);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {

            $reservation->payment->update([
                'status' => 'completed',
                'payment_details' => $response
            ]);

            return redirect()->route('reservations.index', $reservation->id)
                ->with('success', 'Payment completed successfully.');
        }

        return redirect()->route('reservations.index', $reservation->id)
            ->with('error', 'Payment failed.');
    }

    public function cancel(Reservation $reservation)
    {
        return redirect()->route('reservations.index', $reservation->id)
            ->with('error', 'Payment was cancelled.');
    }
}
