<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\PaymentLog;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PaymentService
{
    public function processPayment(Booking $booking, array $data): array
    {
        // Create payment log
        $paymentLog = PaymentLog::create([
            'booking_id' => $booking->id,
            'status' => 'processing',
            'payment_gateway' => $data['payment_method'],
            'transaction_id' => $this->generateTransactionId(),
            'amount' => $booking->total_amount,
            'response_data' => [],
        ]);

        try {
            // Process payment based on method
            $result = match($data['payment_method']) {
                'cash' => $this->processCashPayment($booking, $data),
                'transfer' => $this->processBankTransfer($booking, $data),
                'credit_card' => $this->processCreditCard($booking, $data),
                'e_wallet' => $this->processEWallet($booking, $data),
                default => throw new \Exception('Invalid payment method')
            };

            // Update payment log
            $paymentLog->update([
                'status' => $result['success'] ? 'success' : 'failed',
                'response_data' => $result,
            ]);

            // Update booking status if successful
            if ($result['success']) {
                $booking->update(['payment_status' => 'paid']);
            }

            return $result;

        } catch (\Exception $e) {
            $paymentLog->update([
                'status' => 'failed',
                'response_data' => ['error' => $e->getMessage()],
            ]);

            throw $e;
        }
    }

    public function uploadPaymentProof(Booking $booking, UploadedFile $file): array
    {
        $path = $file->store('payment_proofs', 'public');
        
        $proofs = $booking->payment_proof ?? [];
        $proofs[] = $path;
        
        $booking->update(['payment_proof' => $proofs]);

        return [
            'success' => true,
            'message' => 'Payment proof uploaded successfully',
            'path' => $path
        ];
    }

    public function handleWebhook(array $data): array
    {
        // Handle payment gateway webhooks
        // This would be implemented based on the specific payment gateway
        
        return [
            'success' => true,
            'message' => 'Webhook processed successfully'
        ];
    }

    private function processCashPayment(Booking $booking, array $data): array
    {
        // Cash payment logic
        return [
            'success' => true,
            'message' => 'Cash payment recorded',
            'transaction_id' => $this->generateTransactionId()
        ];
    }

    private function processBankTransfer(Booking $booking, array $data): array
    {
        // Bank transfer logic
        return [
            'success' => true,
            'message' => 'Bank transfer initiated',
            'transaction_id' => $this->generateTransactionId()
        ];
    }

    private function processCreditCard(Booking $booking, array $data): array
    {
        // Credit card payment logic
        return [
            'success' => true,
            'message' => 'Credit card payment processed',
            'transaction_id' => $this->generateTransactionId()
        ];
    }

    private function processEWallet(Booking $booking, array $data): array
    {
        // E-wallet payment logic
        return [
            'success' => true,
            'message' => 'E-wallet payment processed',
            'transaction_id' => $this->generateTransactionId()
        ];
    }

    private function generateTransactionId(): string
    {
        return 'TXN_' . strtoupper(uniqid());
    }
}
