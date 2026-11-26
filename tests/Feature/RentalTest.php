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
        $this->assertArrayHasKey('db', $response->json());
        $this->assertArrayHasKey('customers', $response->json('db'));
    }

    public function test_login_failed_provides_clear_feedback(): void
    {
        $response = $this->postJson('/api/login', [
            'username' => 'alfaprima',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'success' => false,
        ]);
        $this->assertStringContainsString('Password yang dimasukkan salah', $response->json('message'));
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

    public function test_clear_all_forbidden_for_guest(): void
    {
        $response = $this->postJson('/api/clear-all');
        $response->assertStatus(403);
    }

    public function test_clear_all_clears_database_for_admin(): void
    {
        $admin = User::first();
        $this->assertGreaterThan(0, Customer::count());

        $response = $this->actingAs($admin)->postJson('/api/clear-all');
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertEquals(0, Customer::count());
        $this->assertEquals(0, Car::count());
    }

    public function test_save_all_succeeds_when_booking_has_no_is_signed_field(): void
    {
        $admin = User::first();
        $response = $this->actingAs($admin)->postJson('/api/save-all', [
            'bookings' => [
                [
                    'id' => 'BKG-9999',
                    'customerId' => 'PLG-0001',
                    'carId' => 'ARM-0001',
                    'start' => '2026-11-20',
                    'end' => '2026-11-21',
                    'days' => 1,
                    'rate' => 300000,
                    'total' => 300000,
                ]
            ]
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('bookings', [
            'id' => 'BKG-9999',
            'is_signed' => 0,
        ]);
    }

    public function test_admin_can_manage_users_and_create_crew(): void
    {
        $admin = User::where('username', 'alfaprima')->first();

        // 1. Admin creates a crew user (even if passed as 'driver', normalizes to 'crew')
        $response = $this->actingAs($admin)->postJson('/api/users', [
            'username' => 'crew1',
            'name' => 'Pak Supri (Crew)',
            'role' => 'crew',
            'password' => 'crewpass123',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'user' => [
                'username' => 'crew1',
                'role' => 'crew',
            ]
        ]);
        $this->assertDatabaseHas('users', [
            'username' => 'crew1',
            'role' => 'crew',
            'active' => 1,
        ]);

        $crew = User::where('username', 'crew1')->first();

        // 2. Admin updates the user
        $updateResp = $this->actingAs($admin)->putJson('/api/users/' . $crew->id, [
            'username' => 'crew1',
            'name' => 'Pak Supri Handoko',
            'role' => 'crew',
        ]);
        $updateResp->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'id' => $crew->id,
            'name' => 'Pak Supri Handoko',
        ]);

        // 3. Admin cannot delete alfaprima
        $deleteAdminResp = $this->actingAs($admin)->deleteJson('/api/users/' . $admin->id);
        $deleteAdminResp->assertStatus(400);

        // 4. Admin deletes the crew user
        $deleteResp = $this->actingAs($admin)->deleteJson('/api/users/' . $crew->id);
        $deleteResp->assertStatus(200);
        $this->assertDatabaseMissing('users', [
            'id' => $crew->id,
        ]);
    }

    public function test_crew_role_can_login_and_load_data_but_forbidden_from_unpermitted_pages(): void
    {
        $crew = User::create([
            'username' => 'crew_andi',
            'name' => 'Andi Pratama',
            'email' => 'crew_andi@alfarent.local',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'crew',
            'active' => true,
        ]);

        // 1. Crew can log in
        $loginResp = $this->postJson('/api/login', [
            'username' => 'crew_andi',
            'password' => 'password123',
        ]);
        $loginResp->assertStatus(200);
        $loginResp->assertJson([
            'success' => true,
            'user' => [
                'username' => 'crew_andi',
                'role' => 'crew',
            ]
        ]);

        // 2. Crew can load dashboard data
        $loadResp = $this->actingAs($crew)->getJson('/api/load-data');
        $loadResp->assertStatus(200);
        $loadResp->assertJson([
            'success' => true,
            'user' => [
                'role' => 'crew',
            ]
        ]);

        // 3. Crew is forbidden from unpermitted pages by default (e.g. booking, customers, users, clear-all)
        $bookingResp = $this->actingAs($crew)->postJson('/api/bookings', [
            'customer_id' => 'PLG-0001',
            'car_id' => 'ARM-0001',
            'start' => '2026-12-01',
            'end' => '2026-12-02',
        ]);
        $bookingResp->assertStatus(403);
        $this->assertStringContainsString('ditolak', strtolower($bookingResp->json('message')));

        $customerResp = $this->actingAs($crew)->postJson('/api/customers', [
            'nama' => 'Test Customer',
        ]);
        $customerResp->assertStatus(403);

        $usersResp = $this->actingAs($crew)->getJson('/api/users');
        $usersResp->assertStatus(403);

        $clearResp = $this->actingAs($crew)->postJson('/api/clear-all');
        $clearResp->assertStatus(403);
    }

    public function test_role_management_custom_roles_and_flexible_page_permissions(): void
    {
        $admin = User::where('username', 'alfaprima')->first();

        // 1. Get initial roles configuration
        $rolesResp = $this->actingAs($admin)->getJson('/api/roles');
        $rolesResp->assertStatus(200);
        $rolesResp->assertJsonStructure([
            'success',
            'roles' => ['admin', 'karyawan', 'crew'],
            'available_pages',
        ]);

        // 2. Update 'crew' role: rename to 'Crew Lapangan' and grant 'booking' permission
        $updateRoleResp = $this->actingAs($admin)->postJson('/api/roles', [
            'key' => 'crew',
            'name' => 'Crew Lapangan',
            'icon' => '🛠️',
            'badge_color' => '#059669',
            'description' => 'Crew bertugas di lapangan dan diizinkan input booking',
            'permissions' => ['dashboard', 'booking'],
        ]);
        $updateRoleResp->assertStatus(200);
        $this->assertEquals('Crew Lapangan', $updateRoleResp->json('roles.crew.name'));
        $this->assertContains('booking', $updateRoleResp->json('roles.crew.permissions'));

        // 3. Test that a crew user can now access 'booking' API because it was granted
        $crew = User::create([
            'username' => 'crew_budi',
            'name' => 'Budi Lapangan',
            'email' => 'crew_budi@alfarent.local',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'crew',
            'active' => true,
        ]);

        $bookingResp = $this->actingAs($crew)->postJson('/api/bookings', [
            'customer_id' => 'PLG-0001',
            'car_id' => 'ARM-0001',
            'start' => '2026-12-10',
            'end' => '2026-12-12',
            'days' => 2,
            'rate' => 300000,
            'total' => 600000,
            'destination' => 'Solo',
            'units' => [
                [
                    'carId' => 'ARM-0001',
                    'rate' => 300000,
                    'driverFee' => 0,
                    'destination' => 'Solo',
                    'dailySubtotal' => 300000,
                    'total' => 600000,
                ]
            ]
        ]);
        $bookingResp->assertStatus(200);

        // But crew is still forbidden from unpermitted pages like 'pelanggan'
        $custResp = $this->actingAs($crew)->postJson('/api/customers', [
            'nama' => 'Pelanggan Baru',
        ]);
        $custResp->assertStatus(403);

        // 4. Create a custom role 'supervisor'
        $createRoleResp = $this->actingAs($admin)->postJson('/api/roles', [
            'key' => 'supervisor',
            'name' => 'Supervisor Cabang',
            'icon' => '👔',
            'badge_color' => '#8b5cf6',
            'description' => 'Supervisor cabang dengan akses laporan dan dashboard',
            'permissions' => ['dashboard', 'laporan'],
        ]);
        $createRoleResp->assertStatus(200);
        $this->assertEquals('Supervisor Cabang', $createRoleResp->json('roles.supervisor.name'));

        // 5. Delete custom role 'supervisor'
        $deleteRoleResp = $this->actingAs($admin)->deleteJson('/api/roles/supervisor');
        $deleteRoleResp->assertStatus(200);
        $this->assertArrayNotHasKey('supervisor', $deleteRoleResp->json('roles'));

        // 6. Admin cannot delete system role 'crew' or 'admin'
        $deleteSystemResp = $this->actingAs($admin)->deleteJson('/api/roles/crew');
        $deleteSystemResp->assertStatus(400);

        // 7. Non-admin user cannot edit or delete roles
        $unauthEditResp = $this->actingAs($crew)->postJson('/api/roles', [
            'key' => 'crew',
            'name' => 'Hacked Role',
        ]);
        $unauthEditResp->assertStatus(403);
    }

    public function test_save_all_unauthenticated_returns_401_and_authenticated_succeeds(): void
    {
        // 1. Without login, /api/save-all must return 401 with clear message
        $unauthResp = $this->postJson('/api/save-all', [
            'bookings' => []
        ]);
        $unauthResp->assertStatus(401);
        $unauthResp->assertJson([
            'success' => false,
            'unauthenticated' => true,
        ]);
        $this->assertStringContainsString('Unauthenticated', $unauthResp->json('message'));

        // 2. Login via /api/login sets remember cookie and allows saveAll
        $loginResp = $this->postJson('/api/login', [
            'username' => 'alfaprima',
            'password' => 'password123',
        ]);
        $loginResp->assertStatus(200);

        $admin = User::where('username', 'alfaprima')->first();
        $saveResp = $this->actingAs($admin)->postJson('/api/save-all', [
            'customers' => [],
            'cars' => [],
            'bookings' => [
                [
                    'id' => 'BKG-0001',
                    'customerId' => 'PLG-0001',
                    'carId' => 'ARM-0001',
                    'start' => '2026-12-01',
                    'end' => '2026-12-03',
                    'days' => 3,
                    'rate' => 350000,
                    'total' => 1050000,
                    'status' => 'Aktif',
                ]
            ],
            'payments' => [],
            'expenses' => [],
            'partners' => [],
        ]);
        $saveResp->assertStatus(200);
        $saveResp->assertJson(['success' => true]);
    }
}
