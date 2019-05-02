<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use App\Http\Resources\CompanyResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\CompanyRequest;
use App\UploadTrait;

class CompanyController extends Controller
{
    use UploadTrait;

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

        $companies = Company::withTrashed()->filter($name)->paginate($perpage);

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
        $company->city_id = $request->city_id;
        $company->quarter_id = $request->quarter_id;
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
        $company->city_id = $request->city_id;
        $company->quarter_id = $request->quarter_id;

        
        $path = 'images/companies/';
        $remove_path = public_path($path) . $company->logo;
        if($fileName = $this->doUpload('logo', $path)){
            $company->logo = $fileName;
        }

        $company->save();

        $this->removeOldFile($remove_path);
           
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
