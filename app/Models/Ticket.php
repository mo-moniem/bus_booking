<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_num','user_id','trip_id','seat_id','start_station_id','end_station_id'
    ];

    public function seat(){
        return $this->belongsTo(Seat::class,'seat_id');
    }

    public function startStation(){
        return $this->belongsTo(City::class,'start_station_id');
    }

    public function endStation(){
        return $this->belongsTo(City::class,'end_station_id');
    }
}
