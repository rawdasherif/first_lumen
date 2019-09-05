<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use App\Transformers\AuthorTransformer;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Support\Facades\Hash;

class AuthorController extends Controller
{
    /**
     * @var Manager
     */
    private $fractal;

    /**
     * @var AuthorTransformer
     */
    private $authorTransformer;

     /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $jwt;

    function __construct(Manager $fractal, AuthorTransformer  $authorTransformer,JWTAuth $jwt)
    {
        $this->fractal = $fractal;
        $this->authorTransformer = $authorTransformer;
        $this->jwt = $jwt;
    }
    //---------------------------------------------------------
    /**
     * @OA\Get(
     * path="/login",
     *   tags={"Author Login"},
     *   summary="Logs author into the system",
     *   description="",
     *   operationId="loginAuthor",
     *   @OA\Parameter(
     *     name="email",
     *     required=true,
     *     in="query",
     *     description="The user email for login",
     *     required=true,
     *     @OA\Schema(
     *         type="string"
     *     )
     *   ),
     *   @OA\Parameter(
     *     name="password",
     *     in="query",
     *     @OA\Schema(
     *         type="string",
     *     ),
     *     description="The user password for login", 
     *     required=true,
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="successful operation",
     *   ),
     *   @OA\Response(response=400, description="Invalid email/password supplied")
     * )
     */


    public function login(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email|max:255',
            'password' => 'required',
        ]);

        try {

            if (! $token = $this->jwt->attempt($request->only('email','password'))) {
                return response()->json(['author_not_found'], 404);
            }

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], 500);

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], 500);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent' => $e->getMessage()], 500);

        }

        return response()->json(compact('token'));
     }
    //----------------------------------------------- 
    /**
     * @OA\Get(
     *   path="api/authors",
     *   tags={"Author"},
     *   summary="list authors",
     *   parameters={},
     *   @OA\Response(
     *     response=200,
     *     description="A list with authors"
     *   ),
     *   @OA\Response(response="default",description="an ""unexpected"" error")
     * )
     */
        
    public function index()
    {
        $authors=Author::all();

        $authors = new Collection($authors,$this->authorTransformer); // Create a resource collection transformer
        $authors = $this->fractal->createData($authors); // Transform data

        return $authors->toArray(); // Get transformed array of data
    }
    //----------------------------------------------- 
    /**
     * @OA\Get(
     *   path="api/authors/{authorID}",
     *   tags={"Author"},
     *   summary="Find author by ID",
     *   @OA\Parameter(
     *     name="authorId",
     *     in="path",
     *     description="ID of author that needs to be fetched",
     *     required=true,
     *     @OA\Schema(
     *         type="integer",
     *         format="int64",
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="successful operation"
     *   ),
     *   @OA\Response(response=500,description="Internal server error"),
     *   @OA\Response(response=400, description="Invalid ID supplied"),
     *   @OA\Response(response=404, description="Author not found")
     * )
     */
       
    public function show($id)
    {
        $author=Author::find($id);
        
        $author = new Item($author,$this->authorTransformer); // Create a resource collection transformer
        $author = $this->fractal->createData($author); // Transform data
        return $author->toArray(); // Get transformed array of data
       
    }
    //-------------------------------------------------
     /**
     * @OA\Post(
     *   path="/authors",
     *   tags={"Author"},
     *   summary="add new author",
     *   operationId="addAuthor",
     *   @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(ref="#/components/schemas/Author")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Author added successfuly"
     *   ),
     *   @OA\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required',
            'password' => 'required|min:6',
        ]);
        
        $author = Author::create($request->except('password') + ['password' => Hash::make($request->password)]);
        $author = new Item($author,$this->authorTransformer);
        $author = $this->fractal->createData($author);
        return $author->toArray(); 

    }
    //-----------------------------------------------
    /**
     * @OA\Put(
     *   path="api/authors/{authorID}",
     *   tags={"Author"},
     *   summary="Update data for author",
     *   operationId="updateAuthor",
     *   @OA\Parameter(
     *     name="authorId",
     *     in="path",
     *     description="ID of author that needs to be update",
     *     required=true,
     *     @OA\Schema(
     *         type="integer",
     *         format="int64",
     *     )
     *   ),
     *   @OA\RequestBody(
     *       required=true,
     *       @OA\JsonContent(ref="#/components/schemas/Author")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Author added successsfuly"
     *   ),
     *    @OA\Response(response="default",description="an ""unexpected"" error")
     * )
     */


    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'max:25',
        ]);

        $author = Author::findOrFail($id);
        $author->update($request->all());
        $author = new Item($author,$this->authorTransformer);
        $author = $this->fractal->createData($author);
        return $author->toArray(); 
    }
    //-------------------------------------------
    /**
     * @OA\Delete(
     *   path="api/authors/{authorID}",
     *   tags={"Author"},
     *   summary="Delete an author",
     *   operationId="DeleteAuthor",
     *   @OA\Parameter(
     *     name="authorId",
     *     in="path",
     *     description="ID of author that needs to be update",
     *     required=true,
     *     @OA\Schema(
     *         type="integer",
     *         format="int64",
     *     )
     *   ),
     *   @OA\Response(response=400, description="Invalid "),
     *   @OA\Response(response=404, description="Author not found")
     * )
     */


    public function delete($id)
    {
        if(Author::find($id)->delete()){
            return $this->customResponse('Author deleted successfully!', 410);
        }
    }

    public function customResponse($message = 'success', $status = 200)
    {
        return response(['status' =>  $status, 'message' => $message], $status);
    }
}