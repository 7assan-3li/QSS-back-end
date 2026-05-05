<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    /**
     * Cache key for all settings
     */
    const CACHE_KEY = 'system_settings_all';

    protected static function booted()
    {
        // Clear cache whenever a setting is changed
        static::updated(fn () => static::clearCache());
        static::created(fn () => static::clearCache());
        static::deleted(fn () => static::clearCache());
    }

    /**
     * Get a setting value with caching
     */
    public static function getValue($key, $default = null)
    {
        $settings = \Illuminate\Support\Facades\Cache::rememberForever(self::CACHE_KEY, function () {
            return self::pluck('value', 'key')->toArray();
        });

        return $settings[$key] ?? $default;
    }

    /**
     * Clear the settings cache
     */
    public static function clearCache()
    {
        \Illuminate\Support\Facades\Cache::forget(self::CACHE_KEY);
    }
}
