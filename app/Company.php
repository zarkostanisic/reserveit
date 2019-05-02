<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Geo;

class Company extends Model
{
    use SoftDeletes;

    protected $fillable = [
    	'name', 'city_id', 'municipality_id'
    ];

    protected $with = [
    	'city', 'municipality'
    ];

    public function scopeFilter($query, $name){
    	if($name != '') $query->where('name', 'like', $name . '%');
    }

     public function city(){
        return $this->belongsTo(Geo::class, 'city_id', 'id');
    }

    public function municipality(){
        return $this->belongsTo(Geo::class, 'municipality_id', 'id');
    }
}
