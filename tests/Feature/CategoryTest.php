<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class CategoryTest extends TestCase
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
     * can get a list of all categories
     *
     * @return void
     */
    public function test_can_get_a_list_of_categories()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        Category::factory()->count(2)->create();
        $this->assertDatabaseCount('categories', 2);

        $response = $this->get('api/category?draw=1&length=15&search=&column=0&dir=asc');
        $categories = Category::all();
        $response->assertOk();
        $response->assertJson([
            "data"=> [
                [
                  "id"=> $categories->first()->id,
                  "name"=> $categories->first()->name,
                  "description"=> $categories->first()->description,
                ],
                [
                  "id"=> $categories->last()->id,
                  "name"=> $categories->last()->name,
                  "description"=> $categories->last()->description,
                ],
              ]
        ]);
    }


    /**
     * can create a new Category
     *
     * @return void
     */
    public function test_can_create_Category()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $response = $this->post('api/category',[
            'name' => 'History',
            'description' => 'Historical lessons',
        ])->assertCreated();

        $this->assertDatabaseCount('categories', 1);

        $this->assertCount(1,Category::all());
        $Category = Category::first();
        $this->assertEquals('History', $Category->name);
        $this->assertEquals('Historical lessons', $Category->description);
        $response->assertJson([
                "data"=> [
                  "id"=> $Category->id
                ]
        ]);
    }

    /**
     * can update an Category
     *
     * @return void
     */
    public function test_can_update_Category()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        Category::factory()->create();
        $this->assertDatabaseCount('categories', 1);

        $Category = Category::first();

        $response = $this->put('api/category/'.$Category->id,[
            'name' => 'Comics',
            'description' => 'Marvel collection'
        ] );

        $this->assertDatabaseCount('categories', 1);

        $Category = $Category->fresh();

        $this->assertEquals($Category->name, 'Comics');
        $this->assertEquals($Category->description, 'Marvel collection');

        $response->assertJson([
            "data"=> [
              "id"=> $Category->id,
              'name'=>$Category->name,
              'description'=>$Category->description
            ]
        ]);
    }

     /**
     * can delete a Category
     *
     * @return void
     */
    public function test_can_delete_Category()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        Category::factory()->count(5)->create();
        $this->assertDatabaseCount('categories', 5);

        $Category = Category::first();

        $response = $this->delete('api/category/'.$Category->id);

        $this->assertDatabaseCount('categories', 4);

        $response->assertOk();
    }

    public function test_category_name_is_required()
    {
        $this->signIn();
        $response = $this->post('api/category',[
            'name' => '',
            'description' => "sample description"
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_category_description_is_required()
    {
        $this->signIn();
        $response = $this->post('api/category',[
            'name' => 'Sample name',
            'description' =>''
        ]);

        $response->assertSessionHasErrors(['description']);
    }
}
