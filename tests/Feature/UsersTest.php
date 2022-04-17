<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

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
        $this->signIn();
        User::factory()->count(2)->create();//test data

        $this->assertDatabaseCount('users', 3);

        $response = $this->get('api/users/');

        $response->assertOk();
        $users = User::all();
        $response->assertJson([
            "data"=> [
                [
                  "id"=> $users[0]->id,
                  "name"=> $users[0]->name,
                ],
                [
                  "id"=> $users[1]->id,
                  "name"=> $users[1]->name,
                ],
                [
                  "id"=> $users[2]->id,
                  "name"=> $users[2]->name,
                ],
              ]
        ]);
    }

    public function test_can_create_a_user()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $this->post('register',[
             'name' => 'John Smith',
            'email'=>'test@test.com',
            'password' => 'test11111',
            'password_confirmation' => 'test11111'
        ]);

         $this->assertDatabaseCount('users', 2);

        $this->assertCount(2,User::all());

        $users = User::all();
        $response = $this->get('api/users');

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
}
