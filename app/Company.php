<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Geo;

class Company extends Model
{
    use SoftDeletes;

    protected $fillable = [
    	'name', 'logo', 'city_id', 'quarter_id'
    ];

    protected $with = [
    	'city', 'quarter'
    ];

    public function getLogoPathAttribute(){
        return '/images/companies/' . $this->logo;
    }

    public function scopeFilter($query, $name){
    	if($name != '') $query->where('name', 'like', $name . '%');
    }

     public function city(){
        return $this->belongsTo(Geo::class, 'city_id', 'id');
    }

    public function quarter(){
        return $this->belongsTo(Geo::class, 'quarter_id', 'id');
    }
}
