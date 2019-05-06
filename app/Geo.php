<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Geo extends Model
{
	protected $with = [
		'quarters'
	];

    public function quarters(){
    	return $this->hasMany(self::class, 'geo_id');
    }
}
