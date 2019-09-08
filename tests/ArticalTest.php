<?php

 use Illuminate\Http\UploadedFile;
 use Laravel\Lumen\Testing\WithoutMiddleware;
 use Laravel\Lumen\Testing\DatabaseMigrations;

class ArticalTest extends TestCase
{
    use WithoutMiddleware,DatabaseMigrations;
    
    public function testShouldReturnAllArticals(){
        factory('App\Author', 5)->create();
        factory('App\Artical', 5)->create();
        $response=$this->get("api/articals", []);
        $this->assertEquals(200, $this->response->status());

    }

    public function testShouldReturnArtical(){
        factory('App\Author')->create();
        $article = factory('App\Artical')->create();
        $response=$this->get("api/articals/{$article->id}", []);
        $this->assertEquals(200, $this->response->status());
    }

    public function testShouldCreateArtical(){
        factory('App\Author')->create();
        $artical = factory('App\Artical')->make()->toArray();
        $artical['image'] = UploadedFile::fake()->image('avatar.jpg');
        $response=$this->post("api/articals",$artical);
        $this->assertEquals(200, $this->response->status());
        
    }

    public function testShouldUpdateArtical(){
        factory('App\Author')->create();
        $artical = factory('App\Artical')->create()->toArray();
        $artical['image'] = UploadedFile::fake()->image('avatar.jpg');
        $response=$this->put("api/articals/{$artical['id']}",$artical);
        $this->assertEquals(200, $this->response->status());
     
    }

    public function testShouldDeleteArtical(){
        factory('App\Author')->create();
        $article = factory('App\Artical')->create();
        $this->delete("api/articals/{$article->id}", [], []);
        $this->assertEquals(410, $this->response->status());
    }
   



    // create with structure check
    
        //     Storage::fake('local');
    //     $file = UploadedFile::fake()->image('avatar.jpg');
    //     $parameters = [
    //                 'main_title'=> 'mssssss',
    //                 'secondary_title'=>'mohamedaaaa',
    //                 'content'=>'bassss',
    //                 'image'=>$file,
    //                 'author_id'=>1,

    //     ];
    //     $this->post("api/articals", $parameters, []);
    //     $this->seeStatusCode(200);
    //     $this->seeJsonStructure([
    //         'data' => [
    //             'main_title',
    //             'secondary_title',
    //             'content',
    //             'author'=>['data' => 
    //                 [
    //                 'name',
    //                 'email',
    //                 'location',
    //                 'github',
    //                 'twitter',
    //                 'latest_article_published',
    //                 'created_at',
    //                 'updated_at',
    //                 ]
    //         ]
    //     ]    
     
    // ]);
}   

