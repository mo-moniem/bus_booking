<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_num','bus_id','start_station','end_station'
    ];

    protected $casts = [
        'start_station' => 'json',
        'end_station' => 'json',
    ];

    public function bus(){
        return $this->belongsTo(Bus::class,'bus_id');
    }

    public function seats(){
        return $this->hasManyThrough(Seat::class, Bus::class,'id','bus_id');
    }

    public function tickets(){
        return $this->hasMany(Ticket::class,'trip_id');
    }

    public function scopeOfAvailableTrip($query,$request){
        return $query->whereJsonContains('start_station',$request['start_station'])
            ->whereJsonContains('end_station',$request['end_station']);
    }


}
