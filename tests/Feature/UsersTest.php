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
}
