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
        return \App\Support\Facades\CacheService::getSettings($identifier)
            ->where('identifier', '=', $identifier)
            ->first()->value;
    }
}

