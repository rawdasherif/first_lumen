<?php
use Laravel\Lumen\Testing\WithoutMiddleware;

class AuthorTest extends TestCase
{
    use WithoutMiddleware;

    public function testShouldReturnAllAuthors(){
        
        $response=$this->get("api/authors", []);
        $this->assertEquals(200, $this->response->status());

    }

    public function testShouldReturnAuthor(){
        $response=$this->get("api/authors/1", []);
        $this->assertEquals(200, $this->response->status());
           
    }

    public function testShouldCreateAuthor(){
        $author = factory('App\Author')->make();    
        $response=$this->post("api/authors", $author->toArray(), []);
        $this->assertEquals(200, $this->response->status());
        
    }

    public function testShouldUpdateAuthor(){
        $author = factory('App\Author')->make(); 
        $response=$this->put("api/authors/2",$author->toArray(), []);
        $this->assertEquals(200, $this->response->status());
     
    }

    public function testShouldDeleteAuthor(){
        
        $response=$this->delete("api/authors/41", [], []);
         $this->assertEquals(410, $this->response->status());
    }
   



}   