<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {

    $image = $faker->randomElement([
        'https://img10.360buyimg.com/n7/jfs/t1/75455/1/11015/205414/5d8885b4E1b12bbc5/9a8875d2b25ab08c.jpg',
        'https://img14.360buyimg.com/n7/jfs/t1/22718/1/12601/168068/5caedd41E05e879b0/865565d919219154.jpg',
        'https://img10.360buyimg.com/n7/jfs/t1/64468/1/5252/214483/5d36a5b7E1b13e7dc/67711c7137af161b.jpg',
        'https://img13.360buyimg.com/n7/jfs/t1/51361/4/10900/119379/5d7f674aE2ca134a4/b594766ae20f7f47.jpg',
        'https://img12.360buyimg.com/n7/jfs/t1/59022/28/10293/141808/5d78088fEf6e7862d/68836f52ffaaad96.jpg',
        'https://img13.360buyimg.com/n7/jfs/t1/35493/30/14545/210121/5d280052E1187c175/e9ad9735fc3f0686.jpg',
        'https://img10.360buyimg.com/n7/jfs/t1/31430/26/163/186564/5c38509aE4275399f/fe0bef073c1c8f13.jpg',
        'https://img11.360buyimg.com/n7/jfs/t1/50594/16/10341/180900/5d780a28Ec57f9f86/d459ecb9664c7a18.jpg',
        'https://img11.360buyimg.com/n7/jfs/t1/62311/4/7682/113156/5d5b4f9eE034d002d/185d4f32f7b6fcf4.jpg',
        'https://img11.360buyimg.com/n7/jfs/t1/15754/23/5665/358122/5c41229aE112fdfdb/aa9e8675d4a214a6.jpg',
        'https://img12.360buyimg.com/n7/jfs/t1/43961/17/9910/200594/5d36d94dE1ccec7c3/2119602452efce60.jpg',
        'https://img10.360buyimg.com/n7/jfs/t1/3405/18/3537/69901/5b997c0aE5dc8ed9f/a2c208410ae84d1f.jpg',
        'https://img14.360buyimg.com/n7/jfs/t1/65190/25/8601/255415/5d67adc8E33752a61/c3cad27a1b132e84.jpg',
        'https://img14.360buyimg.com/n7/jfs/t1/40810/16/12524/254867/5d5e47a5E030ba9fd/9947efb5297ae4d1.jpg',
        'https://img12.360buyimg.com/n7/jfs/t11467/256/2884845812/267100/493ed21c/5cdd1018N977740e5.jpg',
        'https://img10.360buyimg.com/n7/jfs/t1/35032/13/9593/102096/5cf0c2ccE77dc890e/abde5c9a60044485.jpg',
        'https://img11.360buyimg.com/n7/jfs/t1/51832/12/10355/211488/5d7807c8Ec31d23ab/c49de383d29808a3.jpg',
        'https://img14.360buyimg.com/n7/jfs/t1/19261/13/12605/324178/5c98c7bcE63f668de/ca2762256ec6f931.jpg',
        'https://img14.360buyimg.com/n7/jfs/t1/51038/21/11091/74703/5d820098E102656de/3bf99d994cce2c32.jpg',
        'https://img13.360buyimg.com/n7/jfs/t1/27653/36/12572/346766/5c99ef63E81a8de14/5a38e39b2975e837.jpg'
    ]);

    // 从数据库中随机取一个类目
    $category = \App\Models\Category::query()->where('is_directory', false)->inRandomOrder()->first();

    return [
        'title' => $faker->word,
        'long_title'   => $faker->sentence,
        'description' => $faker->sentence,
        'image' => $image,
        'on_sale' => true,
        'rating' => $faker->numberBetween(0, 5),
        'sold_count' => 0,
        'review_count' => 0,
        'price' => 0,
        'category_id'  => $category ? $category->id : null,
    ];
});
