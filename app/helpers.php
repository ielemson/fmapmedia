<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (! function_exists('setting')) {
    /**
     * Retrieve a general platform setting.
     */
    function setting(
        ?string $key = null,
        mixed $default = null
    ): mixed {
        $settings = Cache::rememberForever(
            'general_settings',
            function (): array {
                return Setting::query()
                    ->first()
                    ?->toArray() ?? [];
            }
        );

        if ($key === null) {
            return $settings;
        }

        return data_get($settings, $key, $default);
    }
}

if (! function_exists('setting_asset')) {
    /**
     * Retrieve a public URL for a stored settings file.
     */
    function setting_asset(
        ?string $path,
        ?string $default = null
    ): ?string {
        if ($path) {
            return asset('storage/' . ltrim($path, '/'));
        }

        return $default
            ? asset(ltrim($default, '/'))
            : null;
    }
}