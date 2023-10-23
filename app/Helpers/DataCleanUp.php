<?php

if ( ! function_exists('cleanUp')) {
    function cleanUp(string|null $string): string|null
    {
        if ( ! $string) {
            return null;
        }

        return htmlspecialchars(strip_tags($string));
    }
}

if ( ! function_exists('cleanUpArray')) {
    function cleanUpArray(array $array = []): array
    {
        return array_map(function ($item) {

            if (is_array($item) || is_countable($item) || is_iterable($item)) {
                return $item;
            }

            return cleanUp($item);
        }, $array);
    }
}
