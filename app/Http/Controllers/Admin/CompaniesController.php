<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Geo;
use App\Category;

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
        $geos = Geo::where('geo_id', 0)->orderBy('name', 'asc')->get();
        $categories = Category::orderBy('name', 'asc')->get();

        return view('admin.companies.index', compact('geos', 'categories'));
    }
}
