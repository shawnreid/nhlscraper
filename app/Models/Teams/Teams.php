<?php

namespace App\Models\Teams;

use Illuminate\Database\Eloquent\Model;

class Teams extends Model
{
    protected $table = 'teams';
    protected $fillable = ['id', 'name'];
    public $timestamps = false;
}
