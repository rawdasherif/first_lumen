<?php

namespace App\Http\Controllers;

use App\Artical;
use Illuminate\Http\Request;
use League\Fractal;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
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

    public function show()
    {
        $articals=Artical::all();

        $articals = new Collection($articals,$this->articalTransformer); // Create a resource collection transformer
        $this->fractal->parseIncludes('author'); 
        $articals = $this->fractal->createData($articals); // Transform data

        return $articals->toArray(); // Get transformed array of data
    }

    public function showOne($id)
    {
        return response()->json(Artical::find($id));
    }

    public function create(Request $request)
    {

        if($request['image']){
            $iName = time().'_'.$request['image']->getClientOriginalName();
            $request['image']->move(('images'), $iName);
            return Artical::create($request->except('image') + ['image' => $iName]);
        } else{
            return Artical::create($request->all());
        }

        return response()->json($artical, 201);
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

        return response()->json($artical, 201);

    }

    public function delete($id)
    {
        Artical::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}