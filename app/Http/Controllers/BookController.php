<?php
namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;

/**
 * Class BookControllerController
 * @package  App\Http\Controllers
 */
class BookController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.auth');        
    }

    /**
     * @OA\Get(
     *  path="/books",
     *  operationId="indexBook",
     *  security={{ "bearerAuth": {} }},
     *  tags={"Books"},
     *  summary="Get list of Book",
     *  description="Returns list of Book",
     *  @OA\Response(response=200, description="Successful operation",
     *    @OA\JsonContent(ref="#/components/schemas/Books"),
     *  ),
     * )
     *
     * Display a listing of Book.
     * @return JsonResponse
     */
    public function index()
    {
        $books = Book::all();
        return response()->json(['data' => $books]);
    }
    
    /**
     * @OA\Post(
     *  operationId="storeBook",
     *  summary="Insert a new Book",
     *  description="Insert a new Book",
     *  security={{ "bearerAuth": {} }},
     *  tags={"Books"},
     *  path="/books",
     *  @OA\RequestBody(
     *    description="Book to create",
     *    required=true,
     *    @OA\MediaType(
     *      mediaType="application/json",
     *      @OA\Schema(
     *      @OA\Property(
     *      title="data",
     *      property="data",
     *      type="object",
     *      ref="#/components/schemas/Book")
     *     )
     *    )
     *  ),
     *  @OA\Response(response="201",description="Book created",
     *     @OA\JsonContent(
     *      @OA\Property(
     *       title="data",
     *       property="data",
     *       type="object",
     *       ref="#/components/schemas/Book"
     *      ),
     *    ),
     *  ),
     *  @OA\Response(response=422,description="Validation exception"),
     * )
     *
     * @param BookRequest $request
     * @return JsonResponse
     */
    public function store(StoreBookRequest $request)
    {
        $data = Book::create($request->validated('data'));
        return response()->json(['data' => $data], RESPONSE::HTTP_CREATED);
    }
  
    /**
     * @OA\Get(
     *   path="/books/{book_id}",
     *   summary="Show a Book from his Id",
     *   description="Show a Book from his Id",
     *   operationId="showBook",
     *  security={{ "bearerAuth": {} }},
     *   tags={"Books"},
     *      @OA\Parameter(
     *          name="book_id",
     *          description="Book id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *   @OA\Response(
     *     response=200,
     *     description="Successful operation",
     *       @OA\JsonContent(
     *       @OA\Property(
     *       title="data",
     *       property="data",
     *       type="object",
     *       ref="#/components/schemas/Book"
     *       ),
     *     ),
     *   ),
     *   @OA\Response(response="404",description="Book not found"),
     * )
     *
     * @param Book $Book
     * @return JsonResponse
     */
    public function show($book_id)
    {
        if(!Book::find($book_id)){
            return response()->json([
                $success=false,
                $message= "No such book",
                $data=[],
                $code=404
            ]   );
        }
        $book = Book::find($book_id);
        return response()->json(['data' => $book]);
        //return response()->json(['data' => $book]);
    }
   
    /**
     * @OA\Patch(
     *   operationId="updateBook",
     *   summary="Update an existing Book",
     *   description="Update an existing Book",
     *  security={{ "bearerAuth": {} }},
     *   tags={"Books"},
     *   path="/books/{book_id}",
     *      @OA\Parameter(
     *          name="book_id",
     *          description="Book id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *   @OA\Response(response="204",description="No content"),
     *   @OA\RequestBody(
     *     description="Book to update",
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *        @OA\Property(
     *        title="data",
     *        property="data",
     *        type="object",
     *        ref="#/components/schemas/Book")
     *      )
     *     )
     *   )
     * )
     *
     * @param Request $request
     * @param Book $Book
     * @return Response|JsonResponse
     */
    public function update(UpdateBookRequest $request,$book_id)
    {
        
        if(!Book::find($book_id)){
            return response()->json([
                $success=false,
                $message= "Book not found",
                $data=[],
                $code=404
            ]   );
        }
        $book = Book::find($book_id);
        $book->update($request->validated('data'));
        
        
        //$book->update($request->all());

        return response()->json(['data' => $book->refresh()]);
    }

    /**
     * @OA\Delete(
     *  path="/books/{book_id}",
     *  summary="Delete a Book",
     *  description="Delete a Book",
     *  operationId="destroyBook",
     *  security={{ "bearerAuth": {} }},
     *  tags={"Books"},
     *  @OA\Parameter(ref="#/components/parameters/Book--id"),
     *  @OA\Response(response=204,description="No content"),
     *  @OA\Response(response=404,description="Book not found"),
     * )
     *
     * @param Book $Book
     * @return Response|JsonResponse
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->noContent();
    }
}
