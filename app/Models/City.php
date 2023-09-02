<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar','name_en'
    ];

    public function scopeOfName($query,$value){
        $query->where('name_ar','like','%'.$value.'%')
            ->orWhere('name_en','like','%'.$value.'%');
    }
}
