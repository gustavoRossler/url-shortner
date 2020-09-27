<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class UrlShortnerTest extends TestCase
{
    use DatabaseTransactions;

    protected $url;
    protected $urlUpdated;
    protected $urlData;

    public function setUp(): void
    {
        parent::setUp();
        $this->url = 'https://www.reuters.com/article/us-belgium-restaurant-idUSKBN2672RR';
        $this->urlUpdated = 'https://www.reuters.com/article/health-coronavirus-johnson-johnson-vacci/johnson-johnson-covid-19-vaccine-produces-strong-immune-response-in-early-trial-idUSKCN26G2YC';
        $this->withoutExceptionHandling();
        $this->artisan('migrate');

        $this->urlData = [
            'original' => $this->url,
            'code' => 123,
            'short' => env('APP_URL') . '/' . 123,
            'clicks' => 0,
            'user_id' => 1,
        ];

        $this->userData = [
            'name' => 'User Test',
            'email' => 'user.test@server.com'
        ];
    }

    /**
     * Test if can create a new shortened url register
     *
     * @return void
     */
    public function test_can_create()
    {
        $user = \App\Models\User::create($this->userData);

        $response = $this->post('/api/url-shortner', [
            'url' => $this->url,
            'user_id' => $user->id,
        ]);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'success',
            'url' => [
                'original',
                'code',
                'short',
                'clicks',
                'updated_at',
                'created_at',
                'id',
            ]
        ]);
        $response->assertSeeText(addcslashes($this->url, '/'));
    }

    /**
     * Test if can fetch a created shortened url
     *
     * @return void
     */
    public function test_can_fetch()
    {
        $urlShort = $this->createData();

        $response = $this->get('/api/url-shortner/' . $urlShort->code);
        $response->assertStatus(200);
        $response->assertSeeText(addcslashes($urlShort->short, '/'));
        $response->assertSeeText(addcslashes($urlShort->original, '/'));
    }

    /**
     * Test if can fetch a list by user
     *
     * @return void
     */
    public function test_can_fetch_by_user()
    {
        $urlShort = $this->createData();

        $response = $this->get('/api/url-shortner/by-user/' . $urlShort->user_id);
        $response->assertStatus(200);
        $response->assertSeeText(addcslashes($urlShort->short, '/'));
        $response->assertSeeText(addcslashes($urlShort->original, '/'));
    }

    /**
     * Test if can update a shortened url
     *
     * @return void
     */
    public function test_can_update()
    {
        $urlShort = $this->createData();

        $response = $this->put('/api/url-shortner/' . $urlShort->code, [
            'url' => $this->urlUpdated,
        ]);
        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'updated' => 1
        ]);
    }

    /**
     * Test if can update a shortened url
     *
     * @return void
     */
    public function test_can_delete()
    {
        $urlShort = $this->createData();

        $response = $this->delete('/api/url-shortner/' . $urlShort->code);
        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'deleted' => 1
        ]);
    }

    public function createData()
    {
        \App\Models\User::create($this->userData);
        $urlShort = \App\Models\UrlShort::create($this->urlData);
        return $urlShort;
    }
}
