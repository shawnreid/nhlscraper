<?php

use Illuminate\Support\Facades\Queue;

if (!function_exists('_s')) {
    function _s(mixed &$value, mixed $return = null): mixed
    {
        return isset($value) ? $value : $return;
    }
}

if (!function_exists('queueSize')) {
    function queueSize(string $queue): mixed
    {
        return number_format(Queue::size($queue));
    }
}