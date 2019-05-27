<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use App\Company;
use App\User;
use  App\Geo;

class UsersController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'roles:administrator|manager']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = [];
        $companies = Company::orderBy('name', 'asc')->get();
        $cities = Geo::cities()->orderBy('name', 'asc')->get();

        $role = auth()->user()->role->name;

        if(in_array($role, ['administrator', 'manager'])){
           $roles = Role::all();
           
           if($role == 'manager'){
                unset($roles[0]);
           } 
        }

        return view('admin.users.index', compact('roles', 'companies', 'cities'));
    }
}
