<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Geo extends Model
{
	protected $with = [
		'municipalities'
	];

    public function municipalities(){
    	return $this->hasMany(self::class, 'geo_id');
    }
}
