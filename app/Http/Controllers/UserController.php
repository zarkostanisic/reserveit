<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\UserCreateRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perpage = request()->query('perpage') ?? 10;
        $role_id = request()->query('role_id') ?? 0;
        $company_id = request()->query('company_id') && $role_id > 1 ? request()->query('company_id') : 0;

        $users = User::withTrashed()->filter($role_id, $company_id)->paginate($perpage);

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
        $user->password = bcrypt($request->password);
        $user->role_id = $request->role_id;
        $user->company_id = $user->role_id == 1 ? 0 : $request->company_id;
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;

        if(!empty($request->password)){
            $user->password = bcrypt($request->password);
        }

        $user->role_id = $request->role_id;
        $user->company_id = $user->role_id == 1 ? 0 : $request->company_id;
        $user->save();
        
        return response([
            'data' => new UserResource($user->fresh())
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user->trashed()){
            $user->restore();
        }
        else{
            $user->delete();
        }
        
        return response([
            'data' => new UserResource($user->fresh())
        ], Response::HTTP_CREATED);
    }
}
