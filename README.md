### Installation / Quick Start

1) copy .env.example to .env
2) [Install Laravel Sail](https://laravel.com/docs/8.x/sail).
3) `sail composer install`
4) `sail artisan migrate:fresh --seed`
5) `sail artisan horizon`
6) `sail artisan fetch:schedule`
7) `sail artisan fetch:games`

### Commands

Fetch games for specified year or all years and save to database:<br />
`sail artisan fetch:schedule {year?}`

Fetch specific data for a game and save to database.<br />
`sail artisan fetch:games {gameid?}`

### Testing

`sail artisan test`

### Static Analysis
`./vendor/bin/phpstan analyse app`: passing level 8