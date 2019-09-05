<?php

 use Illuminate\Http\UploadedFile;


class ArticalTest extends TestCase
{
    public function testShouldReturnAllArticals(){
        $response=$this->get("api/articals", []);
        $this->assertEquals(200, $this->response->status());

    }

    public function testShouldReturnArtical(){
        $response=$this->get("api/articals/4", []);
        $this->assertEquals(200, $this->response->status());
    }

    public function testShouldCreateArtical(){
        
        $artical = factory('App\Artical')->make()->toArray();
        $artical['image'] = UploadedFile::fake()->image('avatar.jpg');
        $response=$this->post("api/articals",$artical);
        $this->assertEquals(200, $this->response->status());
        
    }

    public function testShouldUpdateArtical(){
        $artical = factory('App\Artical')->make()->toArray();
        $artical['image'] = UploadedFile::fake()->image('avatar.jpg');
        $response=$this->put("api/articals/3",$artical);
        $this->assertEquals(200, $this->response->status());
     
    }

    public function testShouldDeleteArtical(){
        
        $this->delete("api/articals/4", [], []);
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

