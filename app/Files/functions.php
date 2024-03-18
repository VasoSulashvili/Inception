<?php

declare(strict_types=1);

if (! function_exists('setting')) {
    /**
     * Create a new setting function.
     *
     * @param  string  $identifier
     * @return mixed
     */
    function setting(string $identifier): mixed
    {
        return \Illuminate\Support\Facades\Cache::rememberForever(
            'settings-' . $identifier,
            function () use ($identifier) {
            return \App\Models\Setting::where('identifier', '=', $identifier)->first()?->value;
        });
    }
}

if (! function_exists('group')) {
    /**
     * Create a new setting function.
     *
     * @param  string  $key
     * @return mixed
     */
    function group(string $key): array
    {
        return \Illuminate\Support\Facades\Cache::rememberForever(
            'groups-' . $key,
            function () use ($key) {
                return [
                    'total_number' => null
                ];
            });
    }
}
