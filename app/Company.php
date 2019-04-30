<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    public function scopeFilter($query, $name){
    	if($name != '') $query->where('name', 'like', '%' . $name . '%');
    }
}
