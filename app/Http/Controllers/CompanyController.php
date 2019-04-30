<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use App\Http\Resources\CompanyResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\CompanyRequest;

class CompanyController extends Controller
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

        $companies = Company::withTrashed()->paginate($perpage);

        return CompanyResource::collection($companies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        $company = new Company();

        $company->name = $request->name;
        $company->save();
        
        return response([
            'data' => new CompanyResource($company)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, Company $company)
    {
        $company->name = $request->name;
        $company->save();
        
        return response([
            'data' => new CompanyResource($company->fresh())
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        if($company->trashed()){
            $company->restore();
        }
        else{
            $company->delete();
        }
        
        return response([
            'data' => new CompanyResource($company->fresh())
        ], Response::HTTP_ACCEPTED);
    }
}
