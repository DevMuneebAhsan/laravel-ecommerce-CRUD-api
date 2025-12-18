<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginUserRequest;
use App\Models\User;
use App\Traits\ApiResponses;
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
    public function register()
    {
        return $this->ok('registered end point hit successfully');
    }
}
