<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\IndexResource;
use App\Http\Resources\User\ShowResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $users = User::get();
        return IndexResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): ShowResource
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $roles = $data['roles'];
        unset($data['roles']);
        $user = User::create($data);
        $user->role()->attach($roles);

        return new ShowResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): ShowResource
    {
        return new ShowResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): ShowResource
    {
        $data = $request->validated();
        if ($data['password']) {
            $data['password'] = Hash::make($data['password']);
        }
        $roles = $data['roles'];
        unset($data['roles']);
        $user->update($data);
        $user->role()->sync($roles);

        return new ShowResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): Response
    {
        $user->role()->detach();
        $user->delete();
        return response()->noContent();
    }
}
