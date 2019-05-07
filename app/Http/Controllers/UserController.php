<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserEditRequest;
use Carbon\Carbon;
use App\UploadTrait;

class UserController extends Controller
{

    use UploadTrait;

    public function __construct(){
        $this->middleware(['auth:api', 'roles:administrator|manager,api']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $perpage = request()->query('perpage') ?? 10;
        $email = request()->query('email') ?? '';
        $role_id = request()->query('role_id') ?? 0;
        $company_id = request()->query('company_id') ?? 0;
        $orderBy = request()->query('orderBy') ?? 'id';
        $order = request()->query('order') ?? 'asc';

        $users = User::withTrashed()
            ->filter($role_id, $company_id, $email)
            ->select('users.*')
            ->join('geos', 'geos.id', '=', 'users.city_id')
            ->leftjoin('companies', 'companies.id', '=', 'users.company_id')
            ->join('roles', 'roles.id', '=', 'users.role_id')
            ->orderBy($orderBy, $order)
            ->paginate($perpage);

        return UserResource::collection($users);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->birthdate = Carbon::createFromFormat('d-m-Y', $request->birthdate)->toDateString();
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->city_id = $request->city_id;
        $user->role_id = $request->role_id;
        $user->company_id = $user->role_id == 1 ? 0 : $request->company_id;

        $path = config('site.upload.images.users.storage');

        if($fileName = $this->uploadImage('photo', $path)){
            $user->photo = $fileName;
        }

        $user->save();
        
        return response([
            'data' => new UserResource($user)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserEditRequest $request, User $user)
    {
        if (auth()->user()->can('update', $user)) {

            $user->name = $request->name;
            $user->email = $request->email;
            $user->birthdate = Carbon::createFromFormat('d-m-Y', $request->birthdate)->toDateString();
            $user->address = $request->address;
            $user->phone = $request->phone;

            if(!empty($request->password)){
                $user->password = bcrypt($request->password);
            }

            $user->city_id = $request->city_id;
            $user->role_id = $request->role_id;
            $user->company_id = $user->role_id == 1 ? 0 : $request->company_id;

            $path = config('site.upload.images.users.storage');
            $photoName = $user->photo;

            if($fileName = $this->uploadImage('photo', $path)){
                $user->photo = $fileName;

                $this->removeImages($path, $photoName);
            }

            $user->save();
            
            return response([
                'data' => new UserResource($user->fresh())
            ], Response::HTTP_ACCEPTED);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (auth()->user()->can('delete', $user)) {
            if($user->trashed()){
                $user->restore();
            }
            else{
                $user->delete();
            }
        }
        
        return response([
            'data' => new UserResource($user->fresh())
        ], Response::HTTP_ACCEPTED);
    }
}
