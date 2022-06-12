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

<br />

### Data Fetching Commands
These commands are used to fetch data from NHL API<br />

Fetch schedule for all seasons:<br />
`sail artisan fetch:schedule`

Fetch schedule for specified season:<br />
`sail artisan fetch:schedule {season}`

Fetch all games:<br />
`sail artisan fetch:games`

Fetch one game:<br />
`sail artisan fetch:games {gameid?}`

<br />

### Calculation Commands
These commands use calculate season/alltime stats from fetched game data.<br />

Calculate all-time stats skater/goalie/team:<br />
`sail artisan fetch:alltime {skaters|goalies|teams}`

Calculate season stats skater/goalie/team:<br />
`sail artisan fetch:season {skaters|goalies|teams}`

<br />

### Testing

`sail artisan test`

<br />

### Static Analysis (PHPStan Level 8)
`./vendor/bin/phpstan analyse app`

<br />

### TODOS
- user agent spoofing
- proxy/tor
- add additional tests
- rename Timeslines to PlayByPlay
- all time teams doesnt work