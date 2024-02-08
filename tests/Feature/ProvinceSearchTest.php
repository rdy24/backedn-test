<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class ProvinceSearchTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testUnauthenticatedUserCannotSearchProvince()
    {
        $response = $this->get('/api/search/provinces?id=1');

        $response->assertStatus(401);
    }

    public function testAuthenticatedUserCanSearchProvince()
    {
        $user = User::where('email', 'user@gmail.com')->first();
        $login = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $login['access_token'],
        ])->get('/api/search/provinces?id=1');

        $response->assertStatus(200);
    }

    public function testAuthenticatedUserSearchProvinceWithoutId()
    {
        $user = User::where('email', 'user@gmail.com')->first();
        $login = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $login['access_token'],
        ])->get('/api/search/provinces?id=');

        $response->assertStatus(400);
    }

    public function testSearchProvinceFromDatabaseDataFound()
    {
        Config::set('app.search_provider', 'database');
        
        $user = User::where('email', 'user@gmail.com')->first();
        $login = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $login['access_token'],
        ])->get('/api/search/provinces?id=1');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Data found',
            ]);
    }

    public function testSearchProvinceFromDatabaseDataNotFound()
    {
        Config::set('app.search_provider', 'database');
        
        $user = User::where('email', 'user@gmail.com')->first();
        $login = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $login['access_token'],
        ])->get('/api/search/provinces?id=asdahdsa');

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Data not found'
            ]);
    }

    public function testSearchProvinceFromRajaOngkirDataFound()
    {
        Config::set('app.search_provider', 'rajaongkir');
        
        $user = User::where('email', 'user@gmail.com')->first();
        $login = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $login['access_token'],
        ])->get('/api/search/provinces?id=1');

        $response->assertStatus(200);
    }

    public function testSearchProvinceFromRajaOngkirDataNotFound()
    {
        Config::set('app.search_provider', 'rajaongkir');
        
        $user = User::where('email', 'user@gmail.com')->first();
        $login = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $login['access_token'],
        ])->get('/api/search/provinces?id=asddsadsad');

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Data not found'
            ]);
    }
}
