<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use App\Transformers\AuthorTransformer;
use Tymon\JWTAuth\JWTAuth;

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

    


    public function index()
    {
        $authors=Author::all();

        $authors = new Collection($authors,$this->authorTransformer); // Create a resource collection transformer
        $authors = $this->fractal->createData($authors); // Transform data

        return $authors->toArray(); // Get transformed array of data
    }

    public function show($id)
    {
        $author=Author::find($id);
        
        $author = new Item($author,$this->authorTransformer); // Create a resource collection transformer
        $author = $this->fractal->createData($author); // Transform data
        return $author->toArray(); // Get transformed array of data
       
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required',
        ]);

        $author = Author::create($request->all());
        $author = new Item($author,$this->authorTransformer);
        $author = $this->fractal->createData($author);
        return $author->toArray(); 

    }

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