<?php

use Faker\Generator as Faker;

$factory->define(\App\Blog\Post::class, function (Faker $faker) {
    return [
        'title' => ['en' => $faker->sentence, 'zh' => '永門義会可際'],
        'intro' => ['en' => $faker->paragraph, 'zh' => '永門義会可際査別件村約候証民'],
        'description' => ['en' => $faker->paragraph, 'zh' => '永門義会可際査別件村約候証民。昌原集前全者波有索男討家王合考作染美最。催優際田度読賞督密出将育別容']
    ];
});
