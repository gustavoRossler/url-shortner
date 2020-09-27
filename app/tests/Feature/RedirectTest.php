<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class RedirectTest extends TestCase
{
    use DatabaseTransactions;

    protected $url;
    protected $urlData;

    public function setUp(): void
    {
        parent::setUp();
        $this->url = 'https://www.reuters.com/article/us-belgium-restaurant-idUSKBN2672RR';
        $this->withoutExceptionHandling();
        $this->artisan('migrate');

        $this->urlData = [
            'original' => $this->url,
            'code' => 123,
            'short' => env('APP_URL') . '/' . 123,
            'clicks' => 0,
        ];
    }

    /**
     * Test if can redirect to the original URL and check stats
     *
     * @return void
     */
    public function test_can_redirect_url()
    {
        $urlShort = \App\Models\UrlShort::create($this->urlData);

        $response = $this->get('/' . $urlShort->code);
        $response->assertStatus(302);

        $newUrlShort = \App\Models\UrlShort::find($urlShort->id);
        $this->assertEquals($newUrlShort->clicks, 1);
    }
}
