<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Geo;

class CompaniesController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'roles:administrator']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $geos = Geo::where('geo_id', 0)->get();

        return view('admin.companies.index', compact('geos'));
    }
}
