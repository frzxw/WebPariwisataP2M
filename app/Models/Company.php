<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'description',
        'logo',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    // Accessors
    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset('storage/' . $this->logo) : asset('images/default-company-logo.png');
    }
}
