### `Installation / Quick Start`

- [Install Laravel Sail](https://laravel.com/docs/8.x/sail).
- sail composer install
- sail artisan migrate:fresh --seed
- sail artisan horizon


### `Commands`

Fetch games for specified year or all years:
sail artisan fetch:schedule {year?}

Fetch specific data for a game:
sail artisan fetch:game {gameid}

### `Testing`

sail artisan test