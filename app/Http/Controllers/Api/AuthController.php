<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
            $user->profile = $this->uploadFile($request->file('profile'), "profile");
        }
        $user->email_verified_at = now();
        $user->remember_token = Str::random(10);
        $user->save();

        return response()->json([
            'message' => 'User registered successfully',
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
     * Update User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = JWTAuth::user();
        if ($request->name !== null) {
            $user->name = $request->name;
        }
        if ($request->description !== null) {
            $user->description = $request->description;
        }
        if ($request->file('profile')) {
            if ($user->profile !== "/storage/default/profile.jpg") {
                $arr_path = explode('/storage/', $user->profile);
                Storage::disk('public')->delete($arr_path[1]);
            }
            $user->profile = $this->uploadFile($request->file('profile'), "profile");
        }

        if ($request->file('cover')) {
            if ($user->cover !== "/storage/default/cover.jpg") {
                $arr_path = explode('/storage/', $user->cover);
                Storage::disk('public')->delete($arr_path[1]);
            }
            $user->cover = $this->uploadFile($request->file('cover'), "cover");
        }
        $user->save();
        return response()->json([
            'message' => 'updated successfully',
            'user' => $user
        ]);
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
    protected function respondWithToken($token): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60,
            'user' => auth()->user()
        ]);
    }

    protected function uploadFile($file, $dir): string
    {
        $filename = $file->getClientOriginalName();
        $filename = time() . '-' . str_replace(' ', '', $filename);
        $file->storeAs("public/{$dir}", $filename);
        return "/storage/{$dir}/{$filename}";
    }
}
