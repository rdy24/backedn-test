<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class CitySearchTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testUnauthenticatedUserCannotSearchCity()
    {
        $response = $this->get('/api/search/cities?id=1');

        $response->assertStatus(401);
    }

    public function testAuthenticatedUserCanSearchCity()
    {
        $user = User::where('email', 'user@gmail.com')->first();
        $login = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $login['access_token'],
        ])->get('/api/search/cities?id=1');

        $response->assertStatus(200);
    }

    public function testAuthenticatedUserSearchCityWithoutId()
    {
        $user = User::where('email', 'user@gmail.com')->first();
        $login = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $login['access_token'],
        ])->get('/api/search/cities?id=');

        $response->assertStatus(400);
    }

    public function testSearchCityFromDatabaseDataFound()
    {
        Config::set('app.search_provider', 'database');
        
        $user = User::where('email', 'user@gmail.com')->first();
        $login = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $login['access_token'],
        ])->get('/api/search/cities?id=1');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Data found',
            ]);
    }

    public function testSearchCityFromDatabaseDataNotFound()
    {
        Config::set('app.search_provider', 'database');
        
        $user = User::where('email', 'user@gmail.com')->first();
        $login = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $login['access_token'],
        ])->get('/api/search/cities?id=abcde');

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Data not found'
            ]);
    }

    public function testSearchCityFromRajaOngkirDataFound()
    {
        Config::set('app.search_provider', 'rajaongkir');
        
        $user = User::where('email', 'user@gmail.com')->first();
        $login = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $login['access_token'],
        ])->get('/api/search/cities?id=1');

        $response->assertStatus(200);
    }

    public function testSearchCityFromRajaOngkirDataNotFound()
    {
        Config::set('app.search_provider', 'rajaongkir');
        
        $user = User::where('email', 'user@gmail.com')->first();
        $login = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $login['access_token'],
        ])->get('/api/search/cities?id=abcd');

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Data not found'
            ]);
    }


}
