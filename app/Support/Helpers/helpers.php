<?php

if (! function_exists('array_rm_null_values')) {
    /**
     * Remove null values from array
     *
     * @param array $array
     * @return array
     */
    function array_rm_null_values(array $array): array
    {
        return array_filter($array, function ($value) {
            if (is_array($value)) {
                return count($value);
            }

            return !is_null($value) && strlen($value);
        });
    }
}
