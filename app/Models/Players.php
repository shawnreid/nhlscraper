<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Players extends Model
{
    protected $table = 'players';
    protected $fillable = [
        'id',
        'team_id',
        'first_name',
        'last_name',
        'primary_number',
        'date_of_birth',
        'birth_city',
        'birth_state_province',
        'birth_country',
        'nationality',
        'age',
        'height',
        'weight',
        'shoots_catches',
        'primary_position',
        'alternate_captain',
        'captain',
        'rookie',
        'roster_status',
        'active'
    ];
    public $timestamps = false;
}
