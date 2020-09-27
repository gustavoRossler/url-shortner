<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UrlShortnerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test if can create a new shortened url register
     *
     * @return void
     */
    public function test_can_create()
    {
        $response = $this->post('/api/url-shortner', [
            'url' => 'https://www.reuters.com/article/us-belgium-restaurant-idUSKBN2672RR'
        ]);
        $response->dump();
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'success',
            'url' => [
                'original',
                'short'
            ]
        ]);
    }
}
