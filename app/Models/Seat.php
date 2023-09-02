<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = [
        'seat_num','bus_id','available_stations'
    ];

    protected $casts = [
        'available_stations' => 'json',
    ];

    /**
     * @return HasMany
     */
    public function tickets():HasMany{
        return $this->hasMany(Ticket::class,'seat_id');
    }

    /**
     * @param $query
     * @param $request
     * @return mixed
     */
    public function scopeOfAvailableSeats($query, $request):mixed{
        if(empty($request['start_station']) || empty($request['end_station']))
            return $query;
        return $query
            ->doesntHave('tickets')
            ->orWhereHas('tickets',function ($q)use ($request){
                return $q->where('start_station_id','!=',$request['start_station'])
                    ->where('end_station_id','!=',$request['end_station']);
            })
            ->whereJsonContains('available_stations',[$request['start_station'],$request['end_station']]);
    }
}
