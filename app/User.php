<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Role;
use App\Company;

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
        'name', 'email', 'password', 'birthdate', 'address', 'phone', 'role_id', 'company_id'
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
        'role', 'company'
    ];

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function scopeFilter($query, $role_id, $company_id)
    {
        if($role_id > 0) $query->where('role_id', $role_id);
        if($company_id > 0) $query->where('company_id', $company_id);
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
