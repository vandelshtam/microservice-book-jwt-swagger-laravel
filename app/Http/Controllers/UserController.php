<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Http;
use App\Http\Response\GeneralResponse;
use App\Http\Requests\UpdateUserRequest;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

      /**
     * Create a new UserController instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('jwt.auth');        
    // }

     /**
     * @OA\Get(
     *  operationId="index",
     *  summary="User index",
     *  description="User index",
     *  security={{ "bearerAuth": {} }},
     *  tags={"Users"},
     *      path="/users",
     *      summary="Get list User",
     *      description="Returns User data",
    
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function index()
    {
        //$this->middleware('jwt.auth');        
        return (new GeneralResponse)->default_json(
            $success=true,
            $message = "Success",
            $data= response()->json(User::all())->original,
            $code= Response::HTTP_ACCEPTED
        );
    }

  
     /**
     * @OA\Post(
     *  operationId="store",
     *  summary="User store",
     *  description="User store",
     *  security={{ "bearerAuth": {} }},
     *  tags={"Users"},
     *      path="/users/store",
      *      summary="Create User",
     *      description="Returns User data",
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
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
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *  @OA\Parameter(
     *          name="password2",
     *          description="Password",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),

     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *       ),
     *  *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function store(Request $request)
    {
        $request_input = $request->all();
        if(User::where("email", $request_input['email'])->count()){
            return (new GeneralResponse)->default_json(
                $success=false,
                $message= "Email is exist",
                $data=[],
                $code=Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
        $user = User::create($request_input);
        return (new GeneralResponse)->default_json(
            $success=true,
            $message= "Succes",
            //$data= new UserResource($user),
            $data= $user,
            $code= Response::HTTP_ACCEPTED
        );
    }

    /**
     * @OA\Get(
     *  operationId="show",
     *  summary="User show",
     *  description="User show",
     *  security={{ "bearerAuth": {} }},
     *  tags={"Users"},
     *      path="/users/{id}",
      *      summary="Get detail User",
     *      description="Returns User data",
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *       ),
     *  *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // if(!User::find($id)){
        //     return response()->json([
        //         $success=false,
        //         $message= "User not found",
        //         $data=[],
        //         $code=404
        //     ]   );
        // }
        //$user = User::find($id);
        //return response()->json(['data' => $id]);
        return (new GeneralResponse)->default_json(
            $success=true,
            $message= "Succes",
            $data= response()->json(User::find($id))->original,
            //$code= Response::HTTP_ACCEPTED
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
     
    }

     /**
     * @OA\Put(
     *  operationId="update",
     *  summary="User update",
     *  description="User update",
     *  security={{ "bearerAuth": {} }},
     *  tags={"Users"},
     *      path="/users/{id}",
     *      summary="Update existing User",
     *      description="Returns updated User data",
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *  @OA\RequestBody(
     *      description="Book to create",
     *      required=true,
     *        @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *            @OA\Property(
     *            title="data",
     *            property="data",
     *            type="object",
     *            ref="#/components/schemas/User")
     *     )
     *    )
     *  ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);
        $user->update($request->validated('data'));
        //return response()->json(['data' => $user->refresh()]);
        
        //$user->update($request->all());

        return (new GeneralResponse)->default_json(
            $success=true,
            $message= "Success",
            $data= response()->json($user)->original,
            $code= Response::HTTP_ACCEPTED
        );
    }

  
    /**
     * @OA\Delete(
     *  operationId="delete",
     *  summary="User delete",
     *  description="User delete",
     *  security={{ "bearerAuth": {} }},
     *  tags={"Users"},
     *      path="/users/{id}",
     *      summary="Delete existing User",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent({})
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function destroy(User $user, $id)
    {
        //$user->delete();
        //return response()->noContent();
        //$user = User::all()->where('id', 2);
        if(!User::find($id)){
            return (new GeneralResponse)->default_json(
                $success=false,
                $message= "user not found",
                $data=[],
                $code=Response::HTTP_NO_CONTENT
            );
        }
        $user = User::find($id);
        $user->delete();
        //return response()->json(['data' => $user]);
        return (new GeneralResponse)->default_json(
            $success=true,
            $message= "Success",
            $data=[],
            $code= Response::HTTP_NO_CONTENT
        );
    }
    /**
     * @OA\Get(
     *  operationId="Identity show",
     *  summary="Identity User show",
     *  description="User show",
     *  security={{ "bearerAuth": {} }},
     *  tags={"Users"},
     *      path="/users/identity/{id}",
      *      summary="Get detail User Identity",
     *      description="Returns User data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Identity User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *       ),
     *  *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     * Using Http
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_identity_id($id)
    {
        // if(!User::find($id)){
        //     return response()->json([
        //         $success=false,
        //         $message= "User not found",
        //         $data=[],
        //         $code=404
        //     ]   );
        // }
        $user = User::find($id);
        //return response()->json(['data' => $id]);
        $user_identity = Http::get("http://127.0.0.1:8001/api/users/{$id}");
        $responseBody = json_decode($user_identity->getBody(),true);
        $user_email = $responseBody['data']['email'];
        //dd($user_email);
        return (new GeneralResponse)->default_json(
            $success=true,
            $message= "Succes",
            $data= response()->json($user_email)->original,
            $code= Response::HTTP_ACCEPTED
        );
        //return $user_email;
    }

    /**
     * @OA\Get(
     *  operationId="Me show",
     *  summary="User me show",
     *  description="User me show",
     *  security={{ "bearerAuth": {} }},
     *  tags={"Users"},
     *      path="/users/me",
      *      summary="Get detail User",
     *      description="Returns User data",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *       ),
     *  *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     * @return \Illuminate\Http\Response
     */
    public function me()
    {
        if (!auth()->user()) {
            return response()->json(['error' => 'Unauthorized user'], 401);
        }
        //$this->middleware('jwt.auth');   
        $payload = auth()->payload();

        try {
            $user = auth()->userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['error' => 'user not found'], 401);
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
}