<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Http;
use App\Http\Response\GeneralResponse;
use App\Http\Controllers\UserController;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register','me']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * @OA\Post(
     *    operationId="User login",
     *    summary="User login",
     *    description="User login",
     *    tags={"Identity"},   
    *     path="/login",
    *     @OA\Parameter(
     *          name="email",
     *          description="Email Field",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="password",
     *          description="Password",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
    *     @OA\Response(response="200", description="Display a credential User."),
    *     @OA\Response(response="201", description="Successful operation"),
    *     @OA\Response(response="400", description="Bad Request"),
    *     @OA\Response(response="401", description="Unauthenticated"),
    *     @OA\Response(response="403", description="Forbidden")
    * )
    */
    public function login()
    {
        $credentials = request(['email', 'password']);
    

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        try {
            $user = auth()->userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['error' => 'user not found'], 401);
        }

        return $this->respondWithToken($token);
        // return response()->json([
        //     'token' => $this->respondWithToken($token)
        //     'user' => $user
        // ], 401);
    }

    // /**
    //  * Get the authenticated User.
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    /**
    * @OA\Get(
    *    operationId="User me",
    *    summary="User me",
    *    description="User me",
    *    security={{ "bearerAuth": {} }},
    *    tags={"Identity"},   
    *     path="/me",
    *     @OA\Response(response="200", description="Display a credential User."),
    *     @OA\Response(response="201", description="Successful operation"),
    *     @OA\Response(response="400", description="Bad Request"),
    *     @OA\Response(response="401", description="Unauthenticated"),
    *     @OA\Response(response="403", description="Forbidden")
    * )
    */
    public function me(Request $request)
    {

        $data = $request->header('authorization');
        
        // $credentials = request(['id']);
        // if (!$token = auth()->attempt($credentials)) {
        //     return response()->json(['error' => 'Unauthorized user in sevice'], 401);
        // }
        // if (!$user = auth()->userOrFail()) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }
        // if (!auth()->user()) {
        //     return response()->json(['error' => 'Unauthorized user in sevice'], 401);
        // }
        //$this->middleware('jwt.auth');   
        $payload = auth()->payload();
        

        try {
            $user = auth()->userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            $id = $payload->get('sub');
            $user_identity = Http::withToken($data)->get("http://127.0.0.1:8000/api/users/{$id}");
            // $user_identity = Http::get("http://127.0.0.1:8000/api/users/{$id}");
            $responseBody = json_decode($user_identity->getBody(),true);
            $user_email = $responseBody['data']['email'];
            $new_user = ['id'=> $id, 'email'=> $user_email];
            $user = User::create($new_user);
            //return response()->json(['error' => 'This user not found, get identity', 'id' => $id, 'email' => $user_email, 'data' =>$data]);
        }
        // then you can access the claims directly e.g.
        // $payload->get('sub'); // = 123
        // $payload['jti']; // = 'asfe4fq434asdf'
        // $payload('exp'); // = 123456
        // $payload->toArray(); // = ['sub' => 123, 'exp' => 123456, 'jti' => 'asfe4fq434asdf'] etc
        return response()->json([
            'auth_user' => $user,
            'token_info' => $payload->toArray(),
            ]);
    
        //return response()->json($payload->toArray());
    }

    /**
    * @OA\Post(
    *    operationId="User logged out",
    *    summary="User logged out",
    *    description="User logged out",
    *    tags={"Identity"}, 
    *    security={{ "bearerAuth": {} }},  
    *     path="/logout",
    *     @OA\Response(response="200", description="Display a credential User."),
    *     @OA\Response(response="201", description="Successful operation"),
    *     @OA\Response(response="400", description="Bad Request"),
    *     @OA\Response(response="401", description="Unauthenticated"),
    *     @OA\Response(response="403", description="Forbidden")
    * )
    */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
    * @OA\Post(
    *    operationId="Token refresh",
    *    summary="Token refresh",
    *    description="Token refresh",
    *    tags={"Identity"}, 
    *    security={{ "bearerAuth": {} }},  
    *     path="/refresh",
    *   @OA\Parameter(
    *       in="header",
    *       name="Authotization",
     *      description="Token",
     *      required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
    *    ),
    *     @OA\Response(response="200", description="Display a credential User."),
    *     @OA\Response(response="201", description="Successful operation"),
    *     @OA\Response(response="400", description="Bad Request"),
    *     @OA\Response(response="401", description="Unauthenticated"),
    *     @OA\Response(response="403", description="Forbidden")
    * )
    */
    public function refresh()
    {
        //$newToken = auth()->refresh();

        // Pass true as the first param to force the token to be blacklisted "forever".
        // The second parameter will reset the claims for the new token
        //$newToken = auth()->refresh(true, true);
        return $this->respondWithToken(auth()->refresh());
    }


      /**
    * @OA\Post(
    *    operationId="User registred",
    *    summary="User registred",
    *    description="User registred",
    *    tags={"Identity"},   
    *     path="/register",
    *     @OA\Parameter(
     *          name="email",
     *          description="Email Field",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *      @OA\Parameter(
     *          name="username",
     *          description="Username Field",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *      @OA\Parameter(
     *          name="firstname",
     *          description="First Name",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *      @OA\Parameter(
     *          name="lastname",
     *          description="Last Name",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="password",
     *          description="Password",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *  @OA\Parameter(
     *          name="password2",
     *          description="Password",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),

     *    @OA\Response(response="200", description="Create User credentials",
     *     @OA\JsonContent(ref="#/components/schemas/User")),
    *     @OA\Response(response="201", description="Successful operation",@OA\JsonContent(ref="#/components/schemas/User")),
    *     @OA\Response(response="400", description="Bad Request"),
    *     @OA\Response(response="401", description="Unauthenticated"),
    *     @OA\Response(response="403", description="Forbidden")
  
    * )
    */
    public function register(Request $request)
    {
        $request_input = $request->input();
        if(array_key_exists('password',  $request_input) && array_key_exists('password2',  $request_input)){
            if ($request_input['password'] != $request_input['password2']){
                return (new GeneralResponse)->default_json(
                    $success=false,
                    $message = "Success",
                    $data= response()->json(User::all())->original,
                    //$code= Response::HTTP_ACCEPTED
                );
            }
        }
        
        $userController = new UserController;
        return $userController->store($request);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access' => $token,
            'refresh' => auth()->refresh(),
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}