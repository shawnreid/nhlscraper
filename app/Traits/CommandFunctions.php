<?php

namespace App\Traits;

use Illuminate\Support\Facades\Queue;

trait CommandFunctions
{
    /**
     * Return size of queue formatted
     *
     * @param  string  $queue
     * @return mixed
     */
    public function queueSize(string $queue): mixed
    {
        return number_format(Queue::size($queue));
    }

    /**
     * Split string range into array
     *
     * @param  string  $range
     * @return mixed
     */
    public function splitRange(string $range): mixed
    {
        return str_replace(' ', '', explode('-', $range));
    }

    /**
     * Trim double spaces and leading/trailing whitespace
     *
     * @param  string  $text
     * @return mixed
     */
    public function trimWhiteSpace(string $text): mixed
    {
        return preg_replace('/\s+/', ' ', trim($text));
    }
}
