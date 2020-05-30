<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Category::class, 5)->create();

        factory(App\Models\Author::class,10)->create();

        factory(App\Models\Book::class,50)->create();

        $books = App\Models\Book::all();

        App\Models\Author::all()->each(function ($author) use ($books) { 
            $author->books()->attach(
                $books->random(rand(1, 3))->pluck('id')->toArray()
            ); 
        });
    }
}
