# Installation / Quick Start

1) copy .env.example to .env
2) `composer install --ignore-platform-reqs`
3) `sail up -d`
4) `sail artisan key:generate`
5) `sail composer install`
6) `sail artisan migrate:fresh --seed`
7) `sail artisan horizon`
8) `sail artisan fetch:schedule`

<br />

# Data Fetching Commands
These commands are used to fetch data from NHL API. Before fetching game data the schedule tables must be populated.<br />

### Schedule / Game Scores
Fetch schedule for all seasons:<br />
`sail artisan fetch:schedule`

Fetch schedule for specified season:<br />
`sail artisan fetch:schedule {season}`

<br />

### Game Data

Fetch all games:<br />
`sail artisan fetch:games`

Fetch all games for a season:<br />
`sail artisan fetch:games 20162017`

Fetch all games for a range of seasons:<br />
`sail artisan fetch:games 20162017-20192020`

Fetch one game:<br />
`sail artisan fetch:games {gameid}`

Fetch a range of games:<br />
`sail artisan fetch:games 2020020001-2020020500`

Overwrite game data:<br />
`sail artisan fetch:games 2020020001 --overwrite`

<br />

### Calculation Commands
These commands use calculate season/alltime stats from fetched game data.<br />

Calculate all-time stats skater/goalie/team:<br />
`sail artisan fetch:alltime {skaters|goalies|teams}`

Calculate season stats skater/goalie/team:<br />
`sail artisan fetch:season {skaters|goalies|teams}`

<br />

# Game IDs
Game IDs are a unique identifier assigned to each game. They are 10 characters in length the first 4 characters describe the year. The next 2 characters describe the type of game (pre season = 01, regular season = 02, playoffs = 03), the remaining digits are used to describe the game. Examples:
- Game 2 of pre season: 2020010002
- Game 100 of regular season: 2020020100
- Game 15 of playoffs: 2020030015

<br />

# Testing

`sail artisan test`

<br />

# Static Analysis (PHPStan Level 8)
`./vendor/bin/phpstan analyse app`

<br />

### TODOS
- user agent spoofing
- proxy/tor
- add additional tests