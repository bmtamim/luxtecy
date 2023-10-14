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
