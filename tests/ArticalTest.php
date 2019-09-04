<?php
class ArticalTest extends TestCase
{
    public function testShouldReturnAllArticals(){
        $this->get("api/articals", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => [
              
                'main_title',
                'secondary_title',
                'content',
                'author'=>['data' => 
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
        ]    
     
    ]);

    }

    public function testShouldReturnArtical(){
        $this->get("api/articals/4", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => [
              
                    'main_title',
                    'secondary_title',
                    'content',
                    'author'=>['data' => 
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
            ]    
         
        ]);
           
    }

    public function testShouldCreateArtical(){
        $parameters = [
                    'main_title'=> 'mssssss',
                    'secondary_title'=>'mohamedaaaa',
                    'content'=>'bassss',
                    'image'=>'12344557_asadadadaddada.jpg',
                    'author_id'=>1,

        ];
        $this->post("api/articals", $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => [
                'main_title',
                'secondary_title',
                'content',
                'author'=>['data' => 
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
        ]    
     
    ]);
        
    }

    // public function testShouldUpdateArtical(){
    //     $parameters = [
    //         'name' => 'samar',
    //         'email'=>'samar@gmail.com',
    //         'location'=>'bolkly',
    //         'github'=>'samaradel',
    //         'twitter'=>'samaradeltwitter',
    //         'latest_article_published'=>'ddsfassdf',
    //     ];
    //     $this->put("api/articals/2", $parameters, []);
    //     $this->seeStatusCode(200);
    //     $this->seeJsonStructure(
    //         ['data' =>
    //             [
    //                 'name',
    //                 'email',
    //                 'location',
    //                 'github',
    //                 'twitter',
    //                 'latest_article_published',
    //                 'created_at',
    //                 'updated_at',
    //             ]
    //         ]    
    //     );
    // }

    public function testShouldDeleteArtical(){
        
        $this->delete("api/articals/5", [], []);
        $this->seeStatusCode(410);
        $this->seeJsonStructure([
                'status',
                'message'
        ]);
    }
   



}   