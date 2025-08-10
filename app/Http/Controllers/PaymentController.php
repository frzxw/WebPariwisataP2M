<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Booking;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(private PaymentService $paymentService) {}

    public function processPayment(PaymentRequest $request, Booking $booking)
    {
        $this->authorize('pay', $booking);

        try {
            $result = $this->paymentService->processPayment($booking, $request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Payment processed successfully',
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function uploadProof(Request $request, Booking $booking)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $this->authorize('uploadProof', $booking);

        try {
            $result = $this->paymentService->uploadPaymentProof($booking, $request->file('payment_proof'));
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function webhook(Request $request)
    {
        try {
            $result = $this->paymentService->handleWebhook($request->all());
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
