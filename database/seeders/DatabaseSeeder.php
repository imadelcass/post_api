<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'name' => 'user1',
            'email' => 'testu1@example.com',
            "password" => Hash::make("1234"),
        ]);
        \App\Models\User::create([
            'name' => 'user2',
            'email' => 'testu2@example.com',
            "password" => Hash::make("1234"),
        ]);
        \App\Models\User::create([
            'name' => 'admin',
            'email' => 'testa1@example.com',
            'isAdmin' => true,
            "password" => Hash::make("1234"),
        ]);

        \App\Models\Category::create([
            'name' => 'category1',
        ]);
        \App\Models\Category::create([
            'name' => 'category2',
        ]);

        \App\Models\Post::create([
            "title"=> "post 1",
          "body" =>  "body post 1",
          "category_id" =>  "1",
          "user_id" => "1",
        ]);
        \App\Models\Post::create([
            "title"=> "post 2",
          "body" =>  "body post 2",
          "category_id" =>  "2",
          "user_id" => "2",
        ]);
    }
}
