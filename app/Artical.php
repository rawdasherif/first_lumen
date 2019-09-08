<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artical extends Model
{

//     /**
//      * @OA\Property()
//      * @var string
//      */
//     public $main_title;
//     /**
//      * @OA\Property()
//      * @var string
//      */
//     public $secondary_title;
//        /**
//      * @OA\Property()
//      * @var string
//      */
//     public $content;
//      /**
//      * @OA\Property()
//      * @var string
//      */
//     public $image;
//    /**
//      * @OA\Property(format="int64")
//      * @var int
//      */
//     public $author_id;

    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'main_title', 'secondary_title', 'content', 'image', 'author_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}