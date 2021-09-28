<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', [
            'except' => ['login', 'register']
        ]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'validate' => 'required',
            'password' => 'required|string|min:8'
        ]);

        $login_type = filter_var($request->input('validate'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $request->merge([
            $login_type => $request->input('validate')
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
//            return response()->json(['massage' => $validator->errors()], 422);
        }

        if (!$token = JWTAuth::attempt($request->only($login_type, 'password'))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|between:3,64|unique:users',
            'password' => 'required|confirmed|min:8',
            'name' => 'required|string',
            'email' => 'required|string|email|max:100|unique:users',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = new User;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->file('profile')) {
            $file = $request->file('profile');
            $filename = $file->getClientOriginalName();
            $filename = time() . '-' . str_replace(' ', '', $filename);
            $file->storeAs("public/profile", $filename);
            $path = "/storage/profile/{$filename}";
            $user->profile = $path;
        }

        $user->email_verified_at = now();
        $user->remember_token = Str::random(10);
        $user->save();

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        $user = JWTAuth::user();
        $user->load(['adopt' => function ($query) {
            $query->orderBy('created_at', "desc");
        }, 'notification' => function ($query) {
            $query->orderBy('created_at', "desc");
        }]);
        return response()->json($user);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(Request $request)
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60,
            'user' => auth()->user()
        ]);
    }
}
