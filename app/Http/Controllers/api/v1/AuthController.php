<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\AuthRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Traits\HttpResponses;

class AuthController extends Controller
{
    use HttpResponses;
    
    public function login(AuthRequest $request) {
        $user = User::where('username', $request->username)->firstOrFail();

        if ( !$user || !Hash::check($request->password, $user->password) ) {
            return $this->error('The provided credentials are incorrect.', 401);
        }
        
        $token = $user->createToken('api token')->plainTextToken;
 
        return $this->success(['token' => $token], 'Login Successfully', 200);
    }

    public function logout(Request $request) {
        return $request->user()->tokens()->delete();
    }
}