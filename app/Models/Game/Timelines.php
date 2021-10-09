<?php

namespace App\Models\Game;

use Illuminate\Database\Eloquent\Model;

class Timelines extends Model
{
    protected $table = 'game_timelines';
    protected $fillable = [
        'schedule_id',   
        'event',         
        'code',          
        'desc_full',     
        'desc_short',    
        'period',        
        'time',          
        'time_left',     
        'player1_id',    
        'player2_id',    
        'player1_type',  
        'player2_type',  
        'home_score',    
        'away_score',    
        'x_coord',       
        'y_coord',
        'team_id',
    ];
    public $timestamps = false;
}
