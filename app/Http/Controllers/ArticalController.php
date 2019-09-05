<?php

namespace App\Http\Controllers;

use App\Artical;
use Illuminate\Http\Request;
use League\Fractal;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use App\Transformers\ArticalTransformer;

class ArticalController extends Controller
{

     /**
     * @var Manager
     */
    private $fractal;

    private $articalTransformer;

    function __construct(Manager $fractal, ArticalTransformer  $articalTransformer)
    {
        $this->fractal = $fractal;
        $this->articalTransformer = $articalTransformer;
    }

    public function index()
    {
        $articals=Artical::all();

        $articals = new Collection($articals,$this->articalTransformer); // Create a resource collection transformer
        $this->fractal->parseIncludes('author'); 
        $articals = $this->fractal->createData($articals); // Transform data

        return $articals->toArray(); // Get transformed array of data
    }

    public function show($id)
    {
        $artical=Artical::find($id);
        $artical = new Item($artical,$this->articalTransformer); 
        $this->fractal->parseIncludes('author'); 
        $artical = $this->fractal->createData($artical); // Transform data
        return $artical->toArray(); // Get transformed array of data
       
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'main_title' => 'required|max:255',
            'secondary_title' => 'required|max:255',
        ]);

        if($request['image']){
            $iName = time().'_'.$request['image']->getClientOriginalName();
            $request['image']->move(('images'), $iName);
            $artical =Artical::create($request->except('image') + ['image' => $iName]);
            
        } else{
            $artical =Artical::create($request->all());
        }

        $artical = new Item($artical,$this->articalTransformer);
        $this->fractal->parseIncludes('author'); 
        $artical = $this->fractal->createData($artical);
        return $artical->toArray(); 
    }

    public function update($id, Request $request)
    {
        $artical = Artical::findOrFail($id);
        // $artical->update($request->all());
        if($request['image']){
            $iName = time().'_'.$request['image']->getClientOriginalName();
            $request['image']->move(('images'), $iName);
            $artical->update($request->except('image') + ['image' => $iName]);
        } else{
            $artical->update($request->all());
        }

        $artical = new Item($artical,$this->articalTransformer);
        $artical = $this->fractal->createData($artical);
        return $artical->toArray(); 

    }

    public function delete($id)
    {
        if(Artical::find($id)->delete()){
            return $this->customResponse('Artical deleted successfully!', 410);
        }
    }

    public function customResponse($message = 'success', $status = 200)
    {
        return response(['status' =>  $status, 'message' => $message], $status);
    }
}