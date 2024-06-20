<?php

use Database\Seeders\CategoriesSeeder;
use Database\Seeders\PublisherSeeder;
use Database\Seeders\BookSeeder;
use Database\Seeders\LanguageSeeder;
use Database\Seeders\AuthorSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\FavoriteSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PublisherSeeder::class,
            LanguageSeeder::class,
            AuthorSeeder::class,
            CategoriesSeeder::class,
            UserSeeder::class,
            BookSeeder::class,
            FavoriteSeeder::class,
        ]);

        $this->call([
        ]);
    }
}