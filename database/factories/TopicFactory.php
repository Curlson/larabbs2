<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Topic::class, function (Faker $faker) {
    
    $userIds = \App\Models\User::all()->pluck('id')->toArray();
    
    $categoryIds = \App\Models\Category::all()->pluck('id')->toArray();
    
    // 随机去一个月以内的一个时间
    $updated_at = $faker->dateTimeThisMonth;
    
    // 传参为生成最大时间不超出, 因为创建时间永远比更改时间要早
    $created_at = $faker->dateTimeThisMonth($updated_at);
    
    return [
        'title' => $faker->name,
        'body' => $faker->text,
        'excerpt' => $faker->sentence,
        'user_id' => $faker->randomElement($userIds),
        'category_id' => $faker->randomElement($categoryIds),
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    ];
});
