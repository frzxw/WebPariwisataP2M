<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class CreatePlotBookingRequest extends FormRequest
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
            'camping_plot_id' => 'required|exists:camping_plots,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'check_in_name' => 'required|string|max:255',
            'check_out_name' => 'required|string|max:255',
            'guests_count' => 'required|integer|min:1',
            'special_requests' => 'nullable|string|max:1000',
            'equipment_rentals' => 'nullable|array',
            'equipment_rentals.*.equipment_id' => 'required_with:equipment_rentals|exists:equipment_rentals,id',
            'equipment_rentals.*.quantity' => 'required_with:equipment_rentals|integer|min:1',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'camping_plot_id.required' => 'Plot camping harus dipilih',
            'camping_plot_id.exists' => 'Plot camping tidak valid',
            'check_in_date.required' => 'Tanggal check-in harus diisi',
            'check_in_date.after_or_equal' => 'Tanggal check-in minimal hari ini',
            'check_out_date.required' => 'Tanggal check-out harus diisi',
            'check_out_date.after' => 'Tanggal check-out harus setelah check-in',
            'check_in_name.required' => 'Nama check-in harus diisi',
            'check_out_name.required' => 'Nama check-out harus diisi',
            'guests_count.required' => 'Jumlah tamu harus diisi',
            'guests_count.min' => 'Minimal 1 tamu',
            'equipment_rentals.*.equipment_id.exists' => 'Equipment tidak valid',
            'equipment_rentals.*.quantity.min' => 'Jumlah equipment minimal 1',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Format dates if needed
        if ($this->check_in_date) {
            $this->merge([
                'check_in_date' => Carbon::parse($this->check_in_date)->format('Y-m-d'),
            ]);
        }

        if ($this->check_out_date) {
            $this->merge([
                'check_out_date' => Carbon::parse($this->check_out_date)->format('Y-m-d'),
            ]);
        }
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Custom validation for minimum stay
            $checkIn = Carbon::parse($this->check_in_date);
            $checkOut = Carbon::parse($this->check_out_date);
            $nights = $checkIn->diffInDays($checkOut);

            if ($nights < 1) {
                $validator->errors()->add('check_out_date', 'Minimal booking adalah 1 malam');
            }

            // Custom validation for maximum advance booking
            $maxAdvanceDays = 365; // Allow booking up to 1 year in advance
            if ($checkIn->diffInDays(now()) > $maxAdvanceDays) {
                $validator->errors()->add('check_in_date', "Booking maksimal {$maxAdvanceDays} hari ke depan");
            }
        });
    }
}
