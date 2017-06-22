<?php

use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

\Illuminate\Database\Eloquent\Model::unguard();
        \App\http\Model\Article::truncate();

        factory(\App\Http\Model\Article::class,150)->create();
    }
}
