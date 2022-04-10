<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
     use RefreshDatabase;

    /**
     * Can get all books
     *
     * @return void
     */
    public function test_a_list_of_books_can_be_retrieved()
    {
        $this->withoutExceptionHandling();

        $books = Book::factory()
            ->count(3)
            ->for(Author::factory()->state([
                'name' => 'Jessica Archer',
            ]))
            ->for(Category::factory()->state([
                'name' => 'Action',
                'description' => 'Super heroe stuff'
            ]))
            ->create();

        $this->assertDatabaseCount('books', 3);

        $this->assertCount(3,Book::all());

        $response = $this->get('/api/books');

        $response
            ->assertStatus(200)
            ->assertJsonCount(3, $key = null);
    }

     /**
     * Can add a book
     *
     * @return void
     */
    public function test_a_book_can_be_created()
    {
        $this->withoutExceptionHandling();

        $author = $this->post('/api/author',[
            'name' => 'Mark Twain',
        ]);
        $author->assertJsonFragment(['id' => 1]);

        $category_id = $this->post('/api/category',[
            'name' => 'Adventure',
            'description' => 'Some texts'
        ]);

        $response = $this->post('/api/books',[
            'name' => 'Tom Sawyer',
            'author' => 1,
            'category' => 1,
            'publication_date' => '2020-04-15'
        ]);

        $this->assertDatabaseCount('books', 1);

    }
}
