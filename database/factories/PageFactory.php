<?php
/*
|--------------------------------------------------------------------------
| User Factories
|--------------------------------------------------------------------------
|
*/

$factory->define(App\Models\Page::class, function (Faker\Generator $faker) {

    $title = $faker->sentence(5);
    
    return [
        'title' => $title,
        'slug' => Illuminate\Support\Str::slug($title),
        'content' => $faker->text
    ];
});
