<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    
    protected $fillable = [
        'barangay_name',
        'logo_path',
        'theme',
        'contact_address',
        'contact_number',
        'contact_email',
    ];

    public static function get($key, $default = null)
    {
        $setting = self::first();
        
        if (!$setting) {
            return $default;
        }

        return match ($key) {
            'logo', 'system_logo' => $setting->logo_path ?? 'template/img/brgy 249 Logo png.png',
            'name', 'system_name' => $setting->barangay_name ?? 'brgy249',
            'theme', 'sidebar_theme' => $setting->theme ?? '#0061f7',
            'contact_address' => $setting->contact_address ?? 'Barangay 249 Zone 23, Tondo, Manila',
            'contact_number' => $setting->contact_number ?? '0999-123-4567',
            'contact_email' => $setting->contact_email ?? 'brgy249@email.com',
            default => $default,
        };
    }
}
