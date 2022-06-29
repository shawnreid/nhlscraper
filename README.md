# Introduction
Boilerplate Laravel 9x application to scrape API data from https://nhl.com.

This tool is currently able to scrape:
- Game Schedules
- Player Information
- Game Play By Play
- Game Team Stats
- Game Skater / Goalie Stats

Season / All Time stats are summarized based off game information scraped, missing game data will lead to incorrect totals. 

<br />

# Installation / Quick Start

1) copy .env.example to .env
2) `bash setup.sh`
3) `sail up -d`
4) `sail artisan key:generate`
5) `sail composer install`
6) `sail artisan migrate:fresh --seed`
7) `sail artisan horizon`

<br />

# Data Scraping Commands
Commands used to scrape data from NHL API. 

**Note:** 
- Before scraping game data the schedules must be scraped for all seasons or the season you are looking to scrape.
- By default commands will not overwrite previously imported schedules. You may use the `--overwrite` option to override.

<br />

### Game Data

Fetch all games:<br />
`sail artisan nhl:games`

Fetch all games for a season:<br />
`sail artisan nhl:games 20192020`

Fetch all games for a range of seasons:<br />
`sail artisan nhl:games 20192020-20202021`

Fetch one game:<br />
`sail artisan nhl:games 2019020001`

Fetch a range of games:<br />
`sail artisan nhl:games 2019020001-2019020500`

<br />

### Schedule / Game Scores
Fetch schedule for all seasons:<br />
`sail artisan nhl:schedule`

Fetch schedule for specified season:<br />
`sail artisan nhl:schedule 20192020`

Fetch schedule for range of seasons:<br />
`sail artisan nhl:schedule 20192020-20202021`

<br />

# Calculation Commands
Commands use calculate season/alltime stats from fetched game data.<br />

Calculate all-time stats skater/goalie/team:<br />
`sail artisan nhl:alltime {skaters|goalies|teams?}`

Calculate season stats skater/goalie/team:<br />
`sail artisan nhl:season {skaters|goalies|teams?}`

<br />

# Endpoints
1) https://statsapi.web.nhl.com/api/v1/schedule?season={seasonId}
    - Game Schedules
2) https://statsapi.web.nhl.com/api/v1/game/{gameId}/feed/live?site=en_nhl
   - Player information
   - Play By Play
   - Team Stats
   - Skater / Goalie Stats
3) https://statsapi.web.nhl.com/api/v1/people/{playerId}/stats?stats=gameLog&season={seasonId}
    - Backup endpoint used if missing game data from live feed.
    - Player Information

<br />

# Worker Queue
All scraping / calculation tasks are defered to a queue (`games`, `schedule`, `calculate`). 

[More info on Laravel Horizon can be found here](https://laravel.com/docs/9.x/horizon) 

<br />

# Game IDs
Game ID is a unique identifier assigned to each game. 10 characters in length the first 4 characters describe the year. The next 2 characters describe the type of game (pre season = 01, regular season = 02, playoffs = 03), the remaining digits are used to describe the game. 

**Examples:**
- Game 100 of regular season: 2020020100
- Game 15 of playoffs: 2020030015

<br />

# Testing / Static Analysis

PHP Unit

`sail artisan test`

PHP Stan (Level 8)

`./vendor/bin/phpstan analyse app`

<br />

# Road Map
- HTML game logs (?)
- Advanced stats calculations
- Find alternative to Player Info
