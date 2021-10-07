<?php

if (!function_exists('_s')) {
    function _s(mixed &$value, mixed $return = null): mixed
    {
        return isset($value) ? $value : $return;
    }
}