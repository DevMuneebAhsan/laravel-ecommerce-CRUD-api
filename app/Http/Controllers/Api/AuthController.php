<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginUserRequest;
use App\Http\Requests\Api\RegisterUserRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponses;
    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());

        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->error('Invalid Credentials', 401);
        }
        $user = User::firstwhere('email', $request->email);
        return $this->ok(
            'Authenticated',
            [
                'token' => $user->createToken('API token for ' . $user->email, ['*'], now()->addMonth())->plainTextToken
            ],
        );
    }
    public function logout(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $current = $user->currentAccessToken();
            if ($current) {
                $user->tokens()->where('id', $current->id)->delete();
            }
        }
        return $this->ok('Logged Out');
    }
    public function register($request)
    {
        return $this->ok('User registered succesfully');
        // $request->validated($request->all());
        // $user = User::findOrFail($request->input('email'));
        // if (!$user) {
        //     $model = [
        //         'name' => $request->input('name'),
        //         'email' => $request->input('email'),
        //         'password' => $request->input('password'),
        //     ];
        //     new UserResource(User::create($model));
        // }
        // return $this->ok('user already exists try to login', 200);
    }
}
