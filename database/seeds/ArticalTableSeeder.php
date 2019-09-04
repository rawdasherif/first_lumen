<?php

use Illuminate\Database\Seeder;

class ArticalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
    factory('App\Artical', 10)->create();
    }
}
