<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->insert([
            'name' => " The Adventures of Tom Sawyer",
            'author_id' => 1,
            'category_id' => 1,
            'publication_date' => '1876-01-01'
        ]);
        DB::table('books')->insert([
            'name' => "Adventures of Huckleberry Finn",
            'author_id' => 1,
            'category_id' => 1,
            'publication_date' => '1885-04-15'
        ]);
        DB::table('books')->insert([
            'name' => "Harry Potter and the Philosopher's Stone",
            'author_id' => 2,
            'category_id' => 2,
            'publication_date' => '1997-06-26'
        ]);
        DB::table('books')->insert([
            'name' => "Fantastic Beasts: The Secrets of Dumbledore",
            'author_id' => 2,
            'category_id' => 2,
            'publication_date' => '2022-04-15'
        ]);
    }
}
