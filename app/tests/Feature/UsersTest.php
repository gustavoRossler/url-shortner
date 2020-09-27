<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class UsersTest extends TestCase
{
    use DatabaseTransactions;

    protected $userData;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->artisan('migrate');

        $this->userData = [
            'name' => 'User Test',
            'email' => 'user.test@server.com'
        ];
    }

    /**
     * Test if can create a new user
     *
     * @return void
     */
    public function test_can_create()
    {
        $response = $this->post('/api/users', $this->userData);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'success',
            'user' => [
                'name',
                'email',
                'updated_at',
                'created_at',
                'id',
            ]
        ]);
    }

    /**
     * Test if can fetch a user
     *
     * @return void
     */
    public function test_can_fetch()
    {
        $user = \App\Models\User::create($this->userData);

        $response = $this->get('/api/users/' . $user->id);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'user' => [
                'name',
                'email',
                'updated_at',
                'created_at',
                'id',
            ]
        ]);
    }

    /**
     * Test if can fetch a user
     *
     * @return void
     */
    public function test_can_fetch_all()
    {
        $user = \App\Models\User::create($this->userData);

        $response = $this->get('/api/users/list');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'users' => [
                '*' => [
                    'name',
                    'email',
                    'updated_at',
                    'created_at',
                    'id',
                ]
            ]
        ]);
    }

    /**
     * Test if can update a user
     *
     * @return void
     */
    public function test_can_update()
    {
        $user = \App\Models\User::create($this->userData);

        $response = $this->put('/api/users/' . $user->id, [
            'name' => 'User Test Updated',
            'email' => 'user.test@server.com'
        ]);
        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'updated' => 1
        ]);
    }

    /**
     * Test if can update a user
     *
     * @return void
     */
    public function test_can_delete()
    {
        $user = \App\Models\User::create($this->userData);

        $response = $this->delete('/api/users/' . $user->id);
        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'deleted' => 1
        ]);
    }
}
