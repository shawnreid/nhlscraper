<?php

use Illuminate\Support\Facades\Queue;

/**
 * If value doesn't exist set a default value
 *
 * @param mixed &$value
 * @param mixed $return
 * @return mixed
*/

if (!function_exists('_s')) {
    function _s(mixed &$value, mixed $return = null): mixed
    {
        return isset($value) ? $value : $return;
    }
}

/**
 * Return size of queue formatted
 *
 * @param string $queue
 * @return mixed
*/

if (!function_exists('queueSize')) {
    function queueSize(string $queue): mixed
    {
        return number_format(Queue::size($queue));
    }
}