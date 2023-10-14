<?php

if ( ! function_exists('file_url')) {

    function asset_url(string $path): string
    {
        if (str_contains($path, 'http')) {
            return $path;
        }

        $path = ltrim($path, '/');

        return asset('storage/'.$path);
    }
}
