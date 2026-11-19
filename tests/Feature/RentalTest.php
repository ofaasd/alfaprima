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

    public function test_pwa_configuration_and_assets(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('rel="manifest"', false);
        $response->assertSee('/manifest.json');
        $response->assertSee('theme-color');

        $this->assertFileExists(public_path('manifest.json'));
        $this->assertFileExists(public_path('sw.js'));
        $this->assertFileExists(public_path('icons/icon-192.png'));
        $this->assertFileExists(public_path('icons/icon-512.png'));
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

    public function test_load_data_returns_null_db_when_unauthenticated(): void
    {
        $response = $this->getJson('/api/load-data');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'user' => null,
            'db' => null,
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
                'accounts',
                'driverPayments',
                'otherCharges',
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

    public function test_driver_payment_creation(): void
    {
        $user = User::where('username', 'alfaprima')->first();
        $response = $this->actingAs($user)->postJson('/api/driver-payments', [
            'assignment_key' => 'BKG-0001::0',
            'booking_id' => 'BKG-0001',
            'unit_index' => 0,
            'driver_id' => 'DRV-0001',
            'driver_name' => 'Slamet Riyadi',
            'date' => '2026-11-13',
            'amount' => 300000,
            'note' => 'Uang jalan tahap 1',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('driver_payments', [
            'booking_id' => 'BKG-0001',
            'amount' => 300000,
        ]);
    }

    public function test_account_creation(): void
    {
        $user = User::where('username', 'alfaprima')->first();
        $response = $this->actingAs($user)->postJson('/api/accounts', [
            'code' => '1102',
            'name' => 'Kas Kecil',
            'group' => 'Aset',
            'normal' => 'Debit',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('accounts', [
            'code' => '1102',
            'name' => 'Kas Kecil',
        ]);
    }

    public function test_save_all_syncs_database(): void
    {
        $user = User::where('username', 'alfaprima')->first();
        $response = $this->actingAs($user)->postJson('/api/save-all', [
            'customers' => [
                [
                    'id' => 'PLG-9999',
                    'nama' => 'Pelanggan Baru',
                    'alamat' => 'Semarang',
                    'wa' => '0899999999',
                    'status' => 'Aktif'
                ]
            ],
            'cars' => [
                [
                    'id' => 'ARM-9999',
                    'merk' => 'Honda',
                    'jenis' => 'Civic RS',
                    'plat' => 'H 9999 ZZ',
                    'trans' => 'Matic',
                    'status' => 'Tersedia',
                    'ownership' => 'sendiri',
                    'vehicleClass' => 'Premium'
                ]
            ]
        ]);

        $response->assertStatus(200);
        $response->assertJson(['ok' => true]);
        $this->assertDatabaseHas('customers', ['id' => 'PLG-9999']);
        $this->assertDatabaseHas('cars', ['id' => 'ARM-9999']);
    }

    public function test_deploy_unauthorized_without_token(): void
    {
        $response = $this->get('/deploy');
        $response->assertStatus(403);
        $response->assertSee('Akses Ditolak');
    }

    public function test_deploy_authorized_with_token(): void
    {
        $response = $this->get('/deploy?token=alfaprima-deploy');
        $response->assertStatus(200);
        $response->assertSee('ALFA');
        $response->assertSee('DEPLOY HELPER');
    }

    public function test_deploy_run_migrate(): void
    {
        $response = $this->get('/deploy/migrate?token=alfaprima-deploy');
        $response->assertStatus(200);
        $response->assertSee('Output Terminal Konsol');
    }

    public function test_signature_url_endpoint(): void
    {
        $response = $this->getJson('/api/signature-url');
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $this->assertNotEmpty($response->json('url'));
    }

    public function test_save_signature_settings_as_admin(): void
    {
        $admin = User::first();
        $response = $this->actingAs($admin)->postJson('/api/settings', [
            'public_signature_url' => 'https://custom-signature.test/verify',
            'signature_name' => 'Budi Santoso',
            'signature_title' => 'Direktur Utama',
            'signature_image' => '/images/custom_signature.png',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('settings', [
            'key' => 'signature_name',
            'value' => 'Budi Santoso',
        ]);
    }

    public function test_save_settings_forbidden_for_guest(): void
    {
        $response = $this->postJson('/api/settings', [
            'signature_name' => 'Hacker',
        ]);

        $response->assertStatus(403);
    }

    public function test_booking_with_signature_fields(): void
    {
        $admin = User::first();

        $response = $this->actingAs($admin)->postJson('/api/bookings', [
            'customer_id' => 'PLG-0001',
            'car_id' => 'ARM-0005',
            'start' => '2027-01-10',
            'end' => '2027-01-11',
            'days' => 2,
            'rate' => 1500000,
            'signature_url' => 'https://custom.test/sign/BKG-0001',
            'is_signed' => true,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('bookings', [
            'signature_url' => 'https://custom.test/sign/BKG-0001',
            'is_signed' => 1,
        ]);
    }
}

