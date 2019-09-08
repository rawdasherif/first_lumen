<?php
namespace App\Transformers;

use App\Artical;
use League\Fractal\TransformerAbstract;
use App\Transformers\AuthorTransformer;

class ArticalTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'author'
    ];

    public function transform(Artical $artical)
    {
       
        return [
            
            'main_title' => $artical->main_title,
            'secondary_title' => $artical->secondary_title,
            'content' => $artical->content,
     
        ];
    }


    public function includeAuthor(Artical $artical)
    {
        

        return $this->item($artical->author, new AuthorTransformer);
    }
}