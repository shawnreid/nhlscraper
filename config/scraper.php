<?php

return [
    'endpoints' => [
        'schedule'  => "https://statsapi.web.nhl.com/api/v1/schedule?season={season}",
        'game'      => "https://statsapi.web.nhl.com/api/v1/game/{gameid}/feed/live?site=en_nhl"
    ]
];