<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timelines extends Model
{
    protected $table = 'timelines';
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
