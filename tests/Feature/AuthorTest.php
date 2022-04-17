<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class AuthorTest extends TestCase
{

    use RefreshDatabase;


     /**
     * Sign in the given user or create new one if not provided.
     *
     * @param $user \App\User
     *
     * @return \App\User
     */
    protected function signIn($user = null)
    {
        $user = $user ?: User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        return $user;
    }

    /**
     * can get a list of all authors
     *
     * @return void
     */
    public function test_can_get_a_list_of_authors()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        Author::factory()->count(2)->create();
        $this->assertDatabaseCount('authors', 2);

        $response = $this->get('api/author?draw=1&length=15&search=&column=0&dir=asc');
        $authors = Author::all();
        $response->assertOk();
        $response->assertJson([
            "data"=> [
                [
                  "id"=> $authors->first()->id,
                  "name"=> $authors->first()->name,
                ],
                [
                  "id"=> $authors->last()->id,
                  "name"=> $authors->last()->name,
                ],
              ]
        ]);
    }


    /**
     * can create a new author
     *
     * @return void
     */
    public function test_can_create_author()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $response = $this->post('api/author',[
            'name' => 'Mart Twain'
        ]);

        $this->assertDatabaseCount('authors', 1);

        $this->assertCount(1,Author::all());
        $author = Author::first();
        $this->assertEquals('Mart Twain', $author->name);
        $response->assertJson([
                "data"=> [
                  "id"=> $author->id
                ]
        ]);
    }

    /**
     * can update an author
     *
     * @return void
     */
    public function test_can_update_author()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        Author::factory()->create();
        $this->assertDatabaseCount('authors', 1);

        $author = Author::first();

        $response = $this->put('api/author/'.$author->id,[
            'name' => 'william shakespeare'
        ] );

        $this->assertDatabaseCount('authors', 1);

        $author = $author->fresh();

        $this->assertEquals($author->name, 'william shakespeare');

        $response->assertJson([
            "data"=> [
              "id"=> $author->id,
              'name'=>$author->name
            ]
        ]);
    }

    public function test_author_name_is_required()
    {
        $this->signIn();
        $this->assertAuthenticated($guard = null);
        $response = $this->post('api/author',[
            'name' => ''
        ]);

        $response->assertInvalid(['name']);
    }

}
