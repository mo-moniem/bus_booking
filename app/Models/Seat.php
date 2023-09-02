<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = [
        'seat_num','bus_id'
    ];

    public function tickets(){
        return $this->hasMany(Ticket::class,'seat_id');
    }

    public function scopeOfAvailableSeats($query,$request){
        if(!$request->has('start_station') || !$request->has('end_station'))
            return $query;
        return $query->doesntHave('tickets')
            ->orWhereHas('tickets',function ($q)use ($request){
                return $q->where('start_station_id','!=',$request['start_station'])
                    ->where('end_station_id','!=',$request['end_station']);
            });
    }
}
