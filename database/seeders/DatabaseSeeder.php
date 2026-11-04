<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\Partner;
use App\Models\Car;
use App\Models\Driver;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Default Admin User
        User::create([
            'username' => 'alfaprima',
            'name' => 'Administrator Alfa Prima',
            'email' => 'admin@alfarent.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'active' => true,
        ]);

        // Sample Customer
        Customer::create([
            'id' => 'PLG-0001',
            'nama' => 'Budi Santoso',
            'alamat' => 'Jl. Pemuda No. 12 Semarang',
            'wa' => '081234567890',
            'nik' => '3374012345670001',
            'sim' => 'SIMA-987654321',
            'status' => 'Aktif',
        ]);

        // Sample Partner
        Partner::create([
            'id' => 'MTR-0001',
            'name' => 'Hendra Pratama',
            'wa' => '081987654321',
            'address' => 'Jl. Pandanaran No. 45 Semarang',
            'bank' => 'BCA',
            'account_no' => '1234567890',
            'account_name' => 'Hendra Pratama',
        ]);

        // Sample Cars
        Car::create([
            'id' => 'ARM-0001',
            'merk' => 'Toyota',
            'jenis' => 'Innova Reborn',
            'plat' => 'H 1234 AB',
            'trans' => 'Matic',
            'status' => 'Tersedia',
            'ownership' => 'sendiri',
            'partner_id' => null,
            'partner_rate' => 0,
        ]);

        Car::create([
            'id' => 'ARM-0002',
            'merk' => 'Toyota',
            'jenis' => 'Avanza Veloz',
            'plat' => 'H 5678 CD',
            'trans' => 'Manual',
            'status' => 'Tersedia',
            'ownership' => 'mitra',
            'partner_id' => 'MTR-0001',
            'partner_rate' => 250000,
        ]);

        // Sample Driver
        Driver::create([
            'id' => 'DRV-0001',
            'name' => 'Slamet Riyadi',
            'wa' => '082133445566',
            'address' => 'Jl. Gajah Mada No. 10 Semarang',
            'license' => 'SIM-8877665544',
            'status' => 'Aktif',
        ]);
    }
}
