<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Geo;

class GeosController extends Controller
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
        $types = json_encode(Geo::getEnum('type'));
        $cities = Geo::with('quarters')->cities()->orderBy('name', 'asc')->get();

        return view('admin.geos.index', compact('geos', 'types', 'cities'));
    }
}
