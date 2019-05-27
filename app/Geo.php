<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Enums;

class Geo extends Model
{
	use SoftDeletes;
    use Enums;

    protected $enumTypes = [
        // 'country',
        'city',
        'quarter'
    ];

    public function quarters(){
    	return $this->hasMany(self::class, 'city_id', 'id');
    }

    public function city(){
    	return $this->belongsTo(self::class, 'city_id', 'id')->withTrashed();
    }

    public function scopeFilter($query, $name, $city_id){
    	if($name != '') $query->where('name', 'like', $name . '%');
        if($city_id != '') $query->where('city_id', $city_id);
    }

    public function scopeCities($query){
    	return $query->where('type', 'city');
    }

}
