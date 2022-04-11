<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Http\Resources\BookResource;
use App\Http\Resources\BooksCollention;
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
            ->count(2)
            ->for(Author::factory()->state([
                'name' => 'Jessica Archer',
            ]))
            ->for(Category::factory()->state([
                'name' => 'Action',
                'description' => 'Super heroe stuff'
            ]))
            ->create();

        $this->assertDatabaseCount('books', 2);

        $this->assertCount(2,Book::all());
        $books = Book::all();

        $response = $this->get('/api/books');

            $response->assertJson([
                "data"=> [
                    [
                      "id"=> $books->first()->id,
                      "name"=> $books->first()->name,
                    ],
                    [
                      "id"=> $books->last()->id,
                      "name"=> $books->last()->name,
                    ],
                  ]
            ]);
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
            'author_id' => 1,
            'category_id' => 1,
            'publication_date' => '2020-04-15'
        ]);

        $this->assertDatabaseCount('books', 1);

    }

     /**
     * Can edit a book
     *
     * @return void
     */
    public function test_a_book_can_be_edited()
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
        $category_id->assertJsonFragment(['id' => 1]);

        $this->post('/api/books',[
            'name' => 'Tom Sawyer',
            'author_id' => 1,
            'category_id' => 1,
            'publication_date' => '2020-04-15'
        ]);

        $this->assertDatabaseCount('books', 1);

        $book = Book::first();

        $response = $this->put('/api/books/'.$book->id,[
            'name' => 'Huck Finn',
            'author_id' => $book->author->id,
            'category_id' => $book->category->id,
            'publication_date' => $book->publication_date,
            'user_id' => $book->user ? $book->user->id : null
        ]);

        $this->assertDatabaseCount('books', 1);

        $book = $book->fresh();

        $this->assertEquals($book->name, 'Huck Finn');
        $this->assertEquals($book->author->id, 1);
        $this->assertEquals($book->category->id, 1);
        $this->assertEquals($book->publication_date, '2020-04-15');

        $response->assertJson([
            "data"=> [
              "id"=> 1,
              'name'=>'Huck Finn',
              'author_id' => 1,
              'category_id' => 1,
              'publication_date' => '2020-04-15',
              'user_id' =>  null
            ]
        ]);
    }

      /**
     * can delete a book
     *
     * @return void
     */
    public function test_can_delete_book()
    {
        $this->withoutExceptionHandling();

        Book::factory()
            ->count(2)
            ->for(Author::factory()->state([
                'name' => 'Jessica Archer',
            ]))
            ->for(Category::factory()->state([
                'name' => 'Action',
                'description' => 'Super heroe stuff'
            ]))
            ->create();

        $this->assertDatabaseCount('books', 2);

        $book = Book::first();

        $response = $this->delete('api/books/'.$book->id);

        $this->assertDatabaseCount('books', 1);

        $response->assertOk();
    }

    public function test_book_fields_are_required()
    {
        $response =   $this->post('/api/books',[
            'name' => '',
            'author_id' => '',
            'category_id' => '',
            'publication_date' => ''
        ]);


        $response->assertSessionHasErrors(['name','author_id','category_id','publication_date']);
    }
}
