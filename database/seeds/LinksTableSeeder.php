<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data=[
            'link_name'=>str_random(5),
            'link_title'=>str_random(10),
            'link_url'=>'http://www.'.str_random(4).'.com',
            'link_order'=>mt_rand(1,10),
        ];

        DB::table('links')->insert($data);


    }
}
