<?php
namespace App\Http\Controllers\auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Login\UserLoginRequest;
use App\Http\Requests\Register\UserRequest;
use App\Models\User;
use App\services\UserServices\LoginService;
use App\services\UserServices\RegisterService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponser;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register' , 'verify']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(UserLoginRequest $request){

        return (new LoginService())->login($request);
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserRequest $request) {
        return (new RegisterService())->register($request);
    }

    public function verify($token)
    {
        $user = User::where('verification_token' , $token)->first();
        if (!$user) {
            return $this->errorResponse("this token is invalid" , 400);
        }
        $user->verification_token = null;
        $user->verified_at = now();
        return $this->successResponse("your account has been verified");
    }
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
