<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\StoreUserRequest;
use App\Http\Requests\Api\V1\UpdateUserRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;

class UsersController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->include('products')) {
            return UserResource::collection(User::with('products')->Paginate());
        }
        return UserResource::collection(User::Paginate());
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if (request()->include('products')) {
            return new UserResource($user->load('products'));
        }
        return new UserResource($user);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
