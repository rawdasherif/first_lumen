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
    //----------------------------------------------- 
    /**
     * @OA\Get(
     *   path="api/articals",
     *   tags={"Article"},
     *   summary="list articles",
     *   parameters={},
     *   @OA\Response(
     *     response=200,
     *     description="A list with articals"
     *   ),
     *   @OA\Response(response="default",description="an ""unexpected"" error")
     * )
     */

    public function index()
    {
        $articals=Artical::all();
        $articals = new Collection($articals,$this->articalTransformer); 
        $this->fractal->parseIncludes('author');
        // dd($articals);
        $articals = $this->fractal->createData($articals); 
        return $articals->toArray(); 
    }
    //----------------------------------------------- 
    /**
     * @OA\Get(
     *   path="api/articals/{articleID}",
     *   tags={"Article"},
     *   summary="Find aericle by ID",
     *   @OA\Parameter(
     *     name="articleId",
     *     in="path",
     *     description="ID of article that needs to be fetched",
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
     *   @OA\Response(response=404, description="Article not found")
     * )
     */

    public function show($id)
    {
        $artical=Artical::find($id);
        $artical = new Item($artical,$this->articalTransformer); 
        $this->fractal->parseIncludes('author'); 
        $artical = $this->fractal->createData($artical); // Transform data
        return $artical->toArray(); // Get transformed array of data
       
    }
      //-------------------------------------------------
     /**
     * @OA\Post(
     *   path="api/articals",
     *   tags={"Article"},
     *   summary="add new article",
     *   operationId="addArticle",
     *   @OA\RequestBody(
     *       required=true,
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Article added successfuly"
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

       //-----------------------------------------------
    /**
     * @OA\Put(
     *   path="api/articals/{articleID}",
     *   tags={"Article"},
     *   summary="Update data for rticle",
     *   operationId="updateArticle",
     *   @OA\Parameter(
     *     name="articleId",
     *     in="path",
     *     description="ID of article that needs to be update",
     *     required=true,
     *     @OA\Schema(
     *         type="integer",
     *         format="int64",
     *     )
     *   ),
     *   @OA\RequestBody(
     *       required=true,

     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Article added successsfuly"
     *   ),
     *    @OA\Response(response="default",description="an ""unexpected"" error")
     * )
     */

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
     //-------------------------------------------
    /**
     * @OA\Delete(
     *   path="api/articals/{articleID}",
     *   tags={"Article"},
     *   summary="Delete an article",
     *   operationId="DeleteArticle",
     *   @OA\Parameter(
     *     name="authorId",
     *     in="path",
     *     description="ID of article that needs to be update",
     *     required=true,
     *     @OA\Schema(
     *         type="integer",
     *         format="int64",
     *     )
     *   ),
     *   @OA\Response(response=400, description="Invalid "),
     *   @OA\Response(response=404, description="Article not found")
     * )
     */

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