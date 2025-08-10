<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payment_method' => 'required|in:cash,transfer,credit_card,e_wallet',
            'payment_data' => 'nullable|array',
            'payment_data.card_number' => 'required_if:payment_method,credit_card|string',
            'payment_data.card_holder' => 'required_if:payment_method,credit_card|string',
            'payment_data.expiry_month' => 'required_if:payment_method,credit_card|integer|min:1|max:12',
            'payment_data.expiry_year' => 'required_if:payment_method,credit_card|integer|min:' . date('Y'),
            'payment_data.cvv' => 'required_if:payment_method,credit_card|string|size:3',
            'payment_data.bank_code' => 'required_if:payment_method,transfer|string',
            'payment_data.account_number' => 'required_if:payment_method,transfer|string',
            'payment_data.wallet_type' => 'required_if:payment_method,e_wallet|in:gopay,ovo,dana,linkaja',
            'payment_data.phone_number' => 'required_if:payment_method,e_wallet|string',
        ];
    }

    public function messages(): array
    {
        return [
            'payment_method.required' => 'Payment method is required',
            'payment_method.in' => 'Invalid payment method selected',
            'payment_data.card_number.required_if' => 'Card number is required for credit card payment',
            'payment_data.card_holder.required_if' => 'Card holder name is required',
            'payment_data.expiry_month.required_if' => 'Expiry month is required',
            'payment_data.expiry_year.required_if' => 'Expiry year is required',
            'payment_data.cvv.required_if' => 'CVV is required',
            'payment_data.cvv.size' => 'CVV must be 3 digits',
            'payment_data.bank_code.required_if' => 'Bank code is required for bank transfer',
            'payment_data.account_number.required_if' => 'Account number is required',
            'payment_data.wallet_type.required_if' => 'Wallet type is required for e-wallet payment',
            'payment_data.phone_number.required_if' => 'Phone number is required for e-wallet payment',
        ];
    }
}
