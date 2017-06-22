<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(\App\Http\Model\Article::class, function (Faker\Generator $faker) {
    return [
        'art_title'=>$faker->sentence(),
        'art_tag'=>implode(',',$faker->words(3,false)),
        'art_description'=>$faker->paragraph(2),
        'art_thumb'=>'uploads/20170611150639712.jpg',
        'art_content'=>$faker->realText(2000,3),
        'art_addtime'=>time(),
        'art_editor'=>$faker->name,
        'art_view'=>mt_rand(1,990),
        'cate_id'=>\App\Http\Model\Category::orderBy(\DB::raw('RAND()'))
            ->take(1)
            ->select('cate_id')
            ->first(),
    ];
});
