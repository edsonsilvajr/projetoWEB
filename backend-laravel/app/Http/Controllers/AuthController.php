<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\User;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = json_decode($request->getContent(), true);

        if (!$token = JWTAuth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            return response()->json(['errors' => 'Invalid credentials, try again'], 401);
        }

        $user = User::where('email', $credentials['email'])->get();

        $userFavorites = Favorite::select('rid')->where('favorites.uid', $user[0]['uid'])->get();
        $favorites = [];

        foreach ($userFavorites as $value) {
            $favorites[] = $value['rid'];
        }

        $user[0]['favorites'] = $favorites;

        return $this->respondWithToken($token, $user[0]);
    }

    public function register(Request $request)
    {
        $credentials = json_decode($request->getContent(), true);
        $user = User::create(array_merge(
            $credentials,
            ['password' => bcrypt($request['password'])]
        ));

        return response()->json($user);
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }

    protected function respondWithToken($token, $user)
    {
        return response()->json([
            "data" => ["token" => $token, "user" => $user],
            "status" => "success"
        ]);
    }
}
