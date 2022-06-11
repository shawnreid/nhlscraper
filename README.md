### Installation / Quick Start

1) copy .env.example to .env
2) `composer install --ignore-platform-reqs`
3) `sail up -d`
4) `sail artisan key:generate`
5) `sail composer install`
6) `sail artisan migrate:fresh --seed`
7) `sail artisan horizon`
8) `sail artisan fetch:schedule`
9) `sail artisan fetch:games`

### Commands

Fetch schedule for all seasons:<br />
`sail artisan fetch:schedule`

Fetch schedule for specified season:<br />
`sail artisan fetch:schedule {season}`

Fetch all games:<br />
`sail artisan fetch:games`

Fetch one game:<br />
`sail artisan fetch:games {gameid?}`

Calculate all-time stats skater/goalie/team:<br />
`sail artisan fetch:alltime {skaters|goalies|teams}`
**sail artisan fetch:games must be run first**

Calculate season stats skater/goalie/team:<br />
`sail artisan fetch:season {skaters|goalies|teams}`
**sail artisan fetch:games must be run first**

### Testing

`sail artisan test`

### Static Analysis (PHPStan Level 8)
`./vendor/bin/phpstan analyse app`