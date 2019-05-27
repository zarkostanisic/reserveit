<?php

namespace App\Http\Controllers;

use App\Geo;
use Illuminate\Http\Request;
use App\Http\Resources\GeoResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\GeoRequest;

class GeosController extends Controller
{
    public function __construct(){
        $this->middleware(['auth:api', 'roles:administrator,api']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perpage = request()->query('perpage') ?? 10;
        $name = request()->query('name') ?? '';
        $city_id = request()->query('city_id') ?? '';
        $orderBy = request()->query('orderBy') ?? 'id';
        $order = request()->query('order') ?? 'asc';

        $geos = Geo::with('city')->withTrashed()
            ->filter($name, $city_id)
            ->orderBy($orderBy, $order)
            ->paginate($perpage);

        return GeoResource::collection($geos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GeoRequest $request)
    {
        $geo = new Geo();

        $geo->name = $request->name;
        $geo->type = $request->type;
        $geo->city_id = $request->type == 'quarter' ? $request->city_id : 0;
        
        $geo->save();
        
        return response([
            'data' => new GeoResource($geo)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Geo  $geo
     * @return \Illuminate\Http\Response
     */
    public function show(Geo $geo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Geo  $geo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Geo $geo)
    {
        $geo->name = $request->name;
        $geo->type = $request->type;
         $geo->city_id = $request->type == 'quarter' ? $request->city_id : 0;
        
        $geo->save();
        
        return response([
            'data' => new GeoResource($geo)
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Geo  $geo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Geo $geo)
    {
        if($geo->trashed()){
            $geo->restore();
        }
        else{
            $geo->delete();
        }
        
        return response([
            'data' => new GeoResource($geo->fresh())
        ], Response::HTTP_ACCEPTED);
    }
}
