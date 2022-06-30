<?php

namespace App\Enums;

enum GameType: int
{
    case PRE_SEASON     = 1;
    case REGULAR_SEASON = 2;
    case PLAYOFFS       = 3;

    /**
     * Return name
     *
     * @return string
    */

    public function name(): string
    {
        return match($this) {
            self::PRE_SEASON     => 'Pre Season',
            self::REGULAR_SEASON => 'Regular Season',
            self::PLAYOFFS       => 'Playoffs'
        };
    }
}