<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Customer;
use App\Models\Car;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RentalTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_home_page_loads_with_correct_ui(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('ALFA');
        $response->assertSee('PRIMA');
        $response->assertSee('RENT CAR');
    }

    public function test_login_successful(): void
    {
        $response = $this->postJson('/api/login', [
            'username' => 'alfaprima',
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'user' => [
                'username' => 'alfaprima',
                'role' => 'admin',
            ]
        ]);
    }

    public function test_load_data_returns_database_entities(): void
    {
        $user = User::where('username', 'alfaprima')->first();
        $response = $this->actingAs($user)->getJson('/api/load-data');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'user',
            'db' => [
                'customers',
                'cars',
                'drivers',
                'partners',
                'bookings',
                'payments',
                'expenses',
                'partnerPayments',
                'journals',
            ]
        ]);
    }

    public function test_customer_creation(): void
    {
        $user = User::where('username', 'alfaprima')->first();
        $response = $this->actingAs($user)->postJson('/api/customers', [
            'nama' => 'Joko Widodo',
            'alamat' => 'Solo',
            'wa' => '0811223344',
            'nik' => '3374000000000002',
            'sim' => 'SIMA-0001',
            'status' => 'Aktif',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('customers', [
            'nama' => 'Joko Widodo',
            'status' => 'Aktif',
        ]);
    }
}

