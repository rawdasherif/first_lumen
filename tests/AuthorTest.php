<?php
class AuthorTest extends TestCase
{
    public function testShouldReturnAllAuthors(){
        $this->get("api/authors", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => ['*' =>
                [
                    'name',
                    'email',
                    'location',
                    'github',
                    'twitter',
                    'latest_article_published',
                    'created_at',
                    'updated_at',
                ]
            ]    
        ]);

    }

    public function testShouldReturnAuthor(){
        $this->get("api/authors/1", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => ['*' =>
                [
                    'name',
                    'email',
                    'location',
                    'github',
                    'twitter',
                    'latest_article_published',
                    'created_at',
                    'updated_at',
                ]
            ]    
        ]);
           
    }

    public function testShouldCreateAuthor(){
        $parameters = [
                    'name'=> 'mohamed',
                    'email'=>'mohamed@gmail.com',
                    'location'=>'bolkly',
                    'github'=>'mohamedadel',
                    'twitter'=>'mohamedadeltwitter',
                    'latest_article_published'=>'ddsfadf',

        ];
        $this->post("api/authors", $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'name',
                    'email',
                    'location',
                    'github',
                    'twitter',
                    'latest_article_published',
                    'created_at',
                    'updated_at',
                ]
            ]    
        );
        
    }

    public function testShouldUpdateAuthor(){
        $parameters = [
            'name' => 'samar',
            'email'=>'samar@gmail.com',
            'location'=>'bolkly',
            'github'=>'samaradel',
            'twitter'=>'samaradeltwitter',
            'latest_article_published'=>'ddsfassdf',
        ];
        $this->put("api/authors/2", $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'name',
                    'email',
                    'location',
                    'github',
                    'twitter',
                    'latest_article_published',
                    'created_at',
                    'updated_at',
                ]
            ]    
        );
    }

    public function testShouldDeleteAuthor(){
        
        $this->delete("api/authors/4", [], []);
        $this->seeStatusCode(410);
        $this->seeJsonStructure([
                'status',
                'message'
        ]);
    }
   



}   