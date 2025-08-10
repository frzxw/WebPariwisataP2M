<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class SettingService
{
    private array $defaultSettings = [
        'site_name' => 'Tourism Booking System',
        'site_description' => 'Book your perfect vacation',
        'contact_email' => 'info@tourism.com',
        'contact_phone' => '+62-123-456-7890',
        'currency' => 'IDR',
        'tax_rate' => 0.10,
        'booking_confirmation_required' => true,
        'auto_approve_reviews' => false,
        'max_booking_days_advance' => 365,
        'cancellation_hours_before' => 24,
    ];

    public function getAllSettings(): array
    {
        return Cache::remember('app_settings', 3600, function () {
            // In a real app, this would come from a settings table
            return $this->defaultSettings;
        });
    }

    public function updateSettings(array $settings): void
    {
        // In a real app, this would update the settings table
        Cache::forget('app_settings');
        Cache::put('app_settings', array_merge($this->defaultSettings, $settings), 3600);
    }

    public function getPublicSettings(): array
    {
        $allSettings = $this->getAllSettings();
        
        // Return only public settings
        return [
            'site_name' => $allSettings['site_name'],
            'site_description' => $allSettings['site_description'],
            'contact_email' => $allSettings['contact_email'],
            'contact_phone' => $allSettings['contact_phone'],
            'currency' => $allSettings['currency'],
        ];
    }

    public function getSetting(string $key, $default = null)
    {
        $settings = $this->getAllSettings();
        return $settings[$key] ?? $default;
    }
}
