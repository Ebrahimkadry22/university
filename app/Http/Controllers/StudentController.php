<?php
namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:student', ['except' => ['login', 'register']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->guard('student')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|min:3|between:2,100',
            'last_name' => 'required|string|min:3|between:2,100',
            'phone' => 'required|string|min:11|between:2,100',
            'photo' => 'required|image|mimes:png,jpg,jpeg',
            'college' => 'required|string|min:11|between:2,100',
            'level' => 'required|string|min:3|between:2,100',
            'department_id' => 'required|exists:departments,id',
            'location' => 'required|string|min:3|between:2,100',
            'email' => 'required|string|email|max:100|unique:students',
            'password' => 'required|string|min:6',
        ]);
        if($validator->fails()){
            return response()->json([
                'error' => $validator->errors()
            ]
            , 400);
        }
        $student = Student::create(array_merge(
                    $validator->validated(),
                    [
                        'photo' => $request->file('photo')->store('students'),
                        'password' => bcrypt($request->password)
                        ]
                ));
        return response()->json([
            'message' => 'Student successfully registered',
            // 'student' => $student
        ], 201);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->guard('student')->logout();
        return response()->json(['message' => 'student successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->guard('student')->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->guard('student')->user());
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
            'user' => auth()->guard('student')->user()
        ]);
    }
}
