<?php

namespace App\Enums;

enum PlayerPosition: string
{
    case CENTER = 'C';
    case LEFT_WING = 'LW';
    case RIGHT_WING = 'RW';
    case LEFT_DEFENSE = 'LD';
    case RIGHT_DEFENSE = 'RD';
    case GOALIE = 'G';

    /**
     * Return name
     *
     * @return string
     */
    public function name(): string
    {
        return match ($this) {
            self::CENTER        => 'Center',
            self::LEFT_WING     => 'Left Wing',
            self::RIGHT_WING    => 'Right Wing',
            self::LEFT_DEFENSE  => 'Left Defense',
            self::RIGHT_DEFENSE => 'Right Defense',
            self::GOALIE        => 'Goalie'
        };
    }
}
