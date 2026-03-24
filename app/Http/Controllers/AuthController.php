<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['login']]);
    // }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::attempt($credentials)) { // Nếu thông tin đăng nhập không hợp lệ, trả về lỗi
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $refreshToken = $this->createRefreshToken(); // Tạo refresh token mới
        return $this->respondWithToken($token, $refreshToken); //   Trả về token và refresh token
    }
    public function profile()
    {
        try {
            return response()->json(Auth::user());
        } catch (JWTException $exception) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
    public function refresh()
    {
        //return $this->respondWithToken(Auth::refresh());
        $refreshToken = request()->refresh_token; // Lấy refresh token từ request
        try {
            $decoded = JWTAuth::getJWTProvider()->decode($refreshToken); // Giải mã token để lấy thông tin
            $user = User::find($decoded['user_id']); // Tìm user theo thông tin trong token
            //Xử lý cấp lại token mới
            // Lấy thông tin user
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404); // Trả về lỗi nếu user không tồn tại
            }
            Auth::invalidate(); // Vô hiệu hóa refresh token cũ
            $token = Auth::login($user); // Tạo token mới cho user
            $refreshToken = $this->createRefreshToken(); // Tạo refresh token mới
            return $this->respondWithToken($token, $refreshToken); // Trả về token mới và refresh token mới
        } catch (JWTException $exception) { // Nếu token không hợp lệ hoặc đã hết hạn
            return response()->json(['error' => 'Refresh Token is invalid'], 500); // Trả về lỗi nếu refresh token không hợp lệ
        }
    }

    private function respondWithToken($token, $refreshToken)
    {
        return response()->json([
            'access_token' => $token,
            'refresh_token' => $refreshToken,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }
    private function createRefreshToken()
    {
        $data = [
            'user_id' => Auth::id(),
            'random' => rand() . time(),
            'exp' => time() + config('jwt.refresh_ttl')
        ];
        $refreshToken = JWTAuth::getJWTProvider()->encode($data);
        return $refreshToken;
    }
}
