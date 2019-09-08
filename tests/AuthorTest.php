<?php

use Laravel\Lumen\Testing\WithoutMiddleware;
use Laravel\Lumen\Testing\DatabaseMigrations;

class AuthorTest extends TestCase
{

     use WithoutMiddleware,DatabaseMigrations;

    public function testShouldReturnAllAuthors(){
        factory('App\Author',10)->create();   
        $response=$this->get("api/authors", []);
        $this->assertEquals(200, $this->response->status());

    }

    public function testShouldReturnAuthor(){
        $author = factory('App\Author')->create(); 
        $response=$this->get("api/authors/{$author->id}", []);
        $this->assertEquals(200, $this->response->status());
           
    }

    public function testShouldCreateAuthor(){
        $author = factory('App\Author')->make()->toArray();    
        $response=$this->post("authors", $author, []);
        $this->assertEquals(200, $this->response->status());
        
    }

    public function testShouldUpdateAuthor(){
        $author = factory('App\Author')->create()->toArray();
        $response=$this->put("api/authors/{$author['id']}",$author, []);
        $this->assertEquals(200, $this->response->status());
     
    }

    public function testShouldDeleteAuthor(){
        $author = factory('App\Author')->create();
        $response=$this->delete("api/authors/{$author->id}", [], []);
         $this->assertEquals(410, $this->response->status());
    }
   



}   