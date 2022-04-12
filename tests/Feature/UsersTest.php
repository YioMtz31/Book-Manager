<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersTest extends TestCase
{

    use RefreshDatabase;
    /**
     * Get all users
     *
     * @return void
     */
    public function test_can_get_all_users()
    {
        $this->withoutExceptionHandling();

        User::factory()->count(3)->create();//test data

        $this->assertDatabaseCount('users', 3);

        $this->assertCount(3,User::all());
    }

    public function test_can_get_a_list_of_users_in_json()
    {
        $this->withoutExceptionHandling();

        User::factory()->count(2)->create();//test data

        $this->assertDatabaseCount('users', 2);

        $response = $this->get('api/users/');

        $response->assertOk();
        $users = User::all();
        $response->assertJson([
            "data"=> [
                [
                  "id"=> $users->first()->id,
                  "name"=> $users->first()->name,
                ],
                [
                  "id"=> $users->last()->id,
                  "name"=> $users->last()->name,
                ],
              ]
        ]);
    }

    public function test_can_create_a_user()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('api/users',[
            'name' => 'John Smith'
        ]);

        $this->assertDatabaseCount('users', 1);

        $this->assertCount(1,User::all());

        $user = User::first();

        $this->assertEquals('John Smith', $user->name);

        $response->assertJson([
                "data"=> [
                  "id"=> $user->id,
                  "name"=> $user->name
                ]
        ]);
    }
}
