<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsService
{
    /**
     * Get a setting value with caching
     */
    public static function get($key, $default = null)
    {
        return Cache::remember("setting.{$key}", 3600, function () use ($key, $default) {
            return Setting::get($key, $default);
        });
    }

    /**
     * Set a setting value and clear cache
     */
    public static function set($key, $value, $type = 'string', $group = 'general', $description = null, $isPublic = false)
    {
        Cache::forget("setting.{$key}");
        return Setting::set($key, $value, $type, $group, $description, $isPublic);
    }

    /**
     * Get all settings for a group
     */
    public static function getGroup($group)
    {
        return Cache::remember("settings.group.{$group}", 3600, function () use ($group) {
            return Setting::byGroup($group)->get()->mapWithKeys(function ($setting) {
                return [$setting->key => $setting->getValue()];
            });
        });
    }

    /**
     * Get all public settings
     */
    public static function getPublic()
    {
        return Cache::remember('settings.public', 3600, function () {
            return Setting::public()->get()->mapWithKeys(function ($setting) {
                return [$setting->key => $setting->getValue()];
            });
        });
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache()
    {
        $keys = Setting::all()->pluck('key');
        foreach ($keys as $key) {
            Cache::forget("setting.{$key}");
        }
        
        $groups = Setting::select('group')->distinct()->pluck('group');
        foreach ($groups as $group) {
            Cache::forget("settings.group.{$group}");
        }
        
        Cache::forget('settings.public');
    }

    /**
     * Get application name
     */
    public static function appName()
    {
        return self::get('app_name', config('app.name'));
    }

    /**
     * Get application URL
     */
    public static function appUrl()
    {
        return self::get('app_url', config('app.url'));
    }

    /**
     * Check if maintenance mode is enabled
     */
    public static function isMaintenanceMode()
    {
        return self::get('maintenance_mode', false);
    }

    /**
     * Get email settings
     */
    public static function getEmailSettings()
    {
        return self::getGroup('email');
    }

    /**
     * Get payment settings
     */
    public static function getPaymentSettings()
    {
        return self::getGroup('payment');
    }

    /**
     * Get system settings
     */
    public static function getSystemSettings()
    {
        return self::getGroup('system');
    }
}
