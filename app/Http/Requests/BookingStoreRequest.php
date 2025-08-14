<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookingStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^([0-9\+\-\(\)])+$/', 'min:10', 'max:20'],
            'participants' => ['required', 'integer', 'min:1', 'max:50'],
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'camping_plot_id' => ['required', 'exists:camping_plots,id'],
            'equipment_rentals' => ['nullable', 'array'],
            'equipment_rentals.*.id' => ['required_with:equipment_rentals', 'exists:equipment_rentals,id'],
            'equipment_rentals.*.quantity' => ['required_with:equipment_rentals', 'integer', 'min:1', 'max:10'],
            'special_requests' => ['nullable', 'string', 'max:1000'],
            'payment_method' => ['required', 'in:cash,qris,bank_bni,shopeepay'],
        ];
    }

    /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'phone.required' => 'Nomor telepon harus diisi.',
            'phone.regex' => 'Format nomor telepon tidak valid.',
            'participants.required' => 'Jumlah peserta harus diisi.',
            'participants.min' => 'Jumlah peserta minimal 1 orang.',
            'participants.max' => 'Jumlah peserta maksimal 50 orang.',
            'check_in.required' => 'Tanggal check-in harus diisi.',
            'check_in.after_or_equal' => 'Tanggal check-in tidak boleh sebelum hari ini.',
            'check_out.required' => 'Tanggal check-out harus diisi.',
            'check_out.after' => 'Tanggal check-out harus setelah tanggal check-in.',
            'camping_plot_id.required' => 'Kavling harus dipilih.',
            'camping_plot_id.exists' => 'Kavling yang dipilih tidak valid.',
            'payment_method.required' => 'Metode pembayaran harus dipilih.',
            'payment_method.in' => 'Metode pembayaran tidak valid.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Clean and format phone number
        if ($this->has('phone')) {
            $phone = preg_replace('/[^0-9+]/', '', $this->phone);
            $this->merge(['phone' => $phone]);
        }

        // Parse equipment rentals if they come as individual form fields
        if (!$this->has('equipment_rentals') || !is_array($this->equipment_rentals)) {
            $equipmentRentals = [];
            
            foreach ($this->all() as $key => $value) {
                if (str_starts_with($key, 'equipment_') && $value > 0) {
                    $equipmentId = str_replace('equipment_', '', $key);
                    if (is_numeric($equipmentId)) {
                        $equipmentRentals[] = [
                            'id' => (int) $equipmentId,
                            'quantity' => (int) $value
                        ];
                    }
                }
            }
            
            $this->merge(['equipment_rentals' => $equipmentRentals]);
        }
    }
}
