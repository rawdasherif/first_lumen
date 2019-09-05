<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;


/**
 * @OA\Schema(@OA\Xml(name="Author"))
 */
class Author extends Model  implements JWTSubject, AuthenticatableContract, AuthorizableContract
{

    /**
     * @OA\Property()
     * @var string
     */
    public $name;
    /**
     * @OA\Property()
     * @var string
     */
    public $email;
       /**
     * @OA\Property()
     * @var string
     */
    public $password;
     /**
     * @OA\Property()
     * @var string
     */
    public $github;
   /**
     * @OA\Property()
     * @var string
     */
    public $twitter;
   /**
     * @OA\Property()
     * @var string
     */
    public $location;
     /**
     * @OA\Property()
     * @var string
     */
    public $latest_article_published;
  
  
  
 
    use Authenticatable, Authorizable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','password', 'github', 'twitter', 'location', 'latest_article_published'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

     /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'password',
        ];
    }
    
    public function articals()
    {
        return $this->hasMany('App\Artical');
    }
}