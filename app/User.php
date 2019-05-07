<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Role;
use App\Company;
use App\Geo;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'photo', 'email', 'password', 'birthdate', 'address', 'phone', 'role_id', 'company_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = [
        'role', 'company', 'city'
    ];

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function city(){
        return $this->belongsTo(Geo::class, 'city_id', 'id');
    }

    public function scopeFilter($query, $role_id, $company_id, $email)
    {
        if($role_id > 0) $query->where('role_id', $role_id);
        if($company_id > 0) $query->where('company_id', $company_id);
        if($email != '') $query->where('users.email', 'like', $email . '%');
    }

    public function isAdmin(){
        return $this->role->name == 'administrator';
    }

    public function isManager(){
        return $this->role->name == 'manager';
    }

    public function isHostess(){
        return $this->role->name == 'hostess';
    }
}
