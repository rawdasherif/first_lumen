<?php
// app/Transformers/AuthorTransformer.php

namespace App\Transformers;

use App\Author;
use League\Fractal\TransformerAbstract;

class AuthorTransformer extends TransformerAbstract
{
    public function transform(Author $author)
    {
        return [
            'name' => $author->name,
            'email' => $author->email,
            'location'=>$author->location,
            'github'=>$author->github,
            'twitter'=>$author->twitter,
            'latest_article_published'=>$author->latest_article_published,
            'created_at'=>$author->created_at,
            'updated_at'=>$author->updated_at
        ];
    }
}