<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use App\Transformers\AuthorTransformer;

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

    function __construct(Manager $fractal, AuthorTransformer  $authorTransformer)
    {
        $this->fractal = $fractal;
        $this->authorTransformer = $authorTransformer;
    }


    public function showAllAuthors()
    {
        $authors=Author::all();

        $authors = new Collection($authors,$this->authorTransformer); // Create a resource collection transformer
        $authors = $this->fractal->createData($authors); // Transform data

        return $authors->toArray(); // Get transformed array of data
    }

    public function showOneAuthor($id)
    {
        $author=Author::find($id);
        
        $author = new Item($author,$this->authorTransformer); // Create a resource collection transformer
        $author = $this->fractal->createData($author); // Transform data
        return $author->toArray(); // Get transformed array of data
       
    }

    public function create(Request $request)
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