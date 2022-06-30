<?php

/**
 * If value doesn't exist set a default value
 *
 * @param  mixed  &$value
 * @param  mixed  $return
 * @return mixed
 */
if (! function_exists('_s')) { // @codeCoverageIgnore
    function _s(mixed &$value, mixed $return = null): mixed
    {
        return isset($value) ? $value : $return;
    }
}
