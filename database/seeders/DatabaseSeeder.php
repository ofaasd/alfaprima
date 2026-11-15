<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\Partner;
use App\Models\Car;
use App\Models\Driver;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Expense;
use App\Models\PartnerPayment;
use App\Models\Account;
use App\Models\Journal;
use App\Models\DriverPayment;
use App\Models\OtherCharge;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Default Admin User (Sesuai Kode.server_js requireSession_)
        User::updateOrCreate(
            ['username' => 'alfaprima'],
            [
                'name' => 'Administrator Alfa Prima',
                'email' => 'admin@alfarent.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'active' => true,
            ]
        );

        // 2. Default Accounts (Sesuai Kode.server_js ensureDefaultAccounts_)
        $defaultAccounts = [
            ['code' => '1101', 'name' => 'Kas/Bank', 'group' => 'Aset', 'normal' => 'Debit'],
            ['code' => '2101', 'name' => 'Utang Mitra', 'group' => 'Liabilitas', 'normal' => 'Kredit'],
            ['code' => '3101', 'name' => 'Modal', 'group' => 'Ekuitas', 'normal' => 'Kredit'],
            ['code' => '4101', 'name' => 'Pendapatan Sewa', 'group' => 'Pendapatan', 'normal' => 'Kredit'],
            ['code' => '4201', 'name' => 'Pendapatan Margin Mitra', 'group' => 'Pendapatan', 'normal' => 'Kredit'],
            ['code' => '5101', 'name' => 'Beban Operasional', 'group' => 'Beban', 'normal' => 'Debit'],
        ];

        foreach ($defaultAccounts as $acc) {
            Account::updateOrCreate(['code' => $acc['code']], $acc);
        }

        // 3. Mitra / Partners (TABLES.partners)
        $partner1 = Partner::updateOrCreate(
            ['id' => 'MTR-0001'],
            [
                'name' => 'Hendra Pratama',
                'wa' => '081987654321',
                'address' => 'Jl. Pandanaran No. 45 Semarang',
                'bank' => 'BCA',
                'account_no' => '1234567890',
                'account_name' => 'Hendra Pratama',
            ]
        );

        $partner2 = Partner::updateOrCreate(
            ['id' => 'MTR-0002'],
            [
                'name' => 'Agus Setiawan',
                'wa' => '081399887711',
                'address' => 'Jl. Majapahit No. 102 Semarang',
                'bank' => 'Mandiri',
                'account_no' => '9876543210',
                'account_name' => 'Agus Setiawan',
            ]
        );

        // 4. Pelanggan / Customers (TABLES.customers)
        $customer1 = Customer::updateOrCreate(
            ['id' => 'PLG-0001'],
            [
                'nama' => 'Budi Santoso',
                'alamat' => 'Jl. Pemuda No. 12 Semarang',
                'wa' => '081234567890',
                'nik' => '3374012345670001',
                'sim' => 'SIMA-987654321',
                'status' => 'Aktif',
            ]
        );

        $customer2 = Customer::updateOrCreate(
            ['id' => 'PLG-0002'],
            [
                'nama' => 'Siti Rahmawati',
                'alamat' => 'Jl. Siliwangi No. 20 Semarang',
                'wa' => '085712345678',
                'nik' => '3374023456780002',
                'sim' => 'SIMA-123456789',
                'status' => 'Aktif',
            ]
        );

        // 5. Driver / Pengemudi (TABLES.drivers)
        $driver1 = Driver::updateOrCreate(
            ['id' => 'DRV-0001'],
            [
                'name' => 'Slamet Riyadi',
                'wa' => '082133445566',
                'address' => 'Jl. Gajah Mada No. 10 Semarang',
                'license' => 'SIM-8877665544',
                'status' => 'Aktif',
            ]
        );

        $driver2 = Driver::updateOrCreate(
            ['id' => 'DRV-0002'],
            [
                'name' => 'Joko Susilo',
                'wa' => '081299887766',
                'address' => 'Jl. Majapahit No. 88 Semarang',
                'license' => 'SIM-1122334455',
                'status' => 'Aktif',
            ]
        );

        // 6. Armada / Cars (TABLES.cars: vehicleClass, ownership, partnerRate, etc.)
        $car1 = Car::updateOrCreate(
            ['id' => 'ARM-0001'],
            [
                'merk' => 'Toyota',
                'jenis' => 'Innova Reborn',
                'plat' => 'H 1234 AB',
                'trans' => 'Matic',
                'status' => 'Tersedia',
                'ownership' => 'sendiri',
                'partner_id' => null,
                'partner_rate' => 0,
                'vehicle_class' => 'MPV',
            ]
        );

        $car2 = Car::updateOrCreate(
            ['id' => 'ARM-0002'],
            [
                'merk' => 'Toyota',
                'jenis' => 'Avanza Veloz',
                'plat' => 'H 5678 CD',
                'trans' => 'Manual',
                'status' => 'Tersedia',
                'ownership' => 'mitra',
                'partner_id' => 'MTR-0001',
                'partner_rate' => 250000,
                'vehicle_class' => 'LMPV',
            ]
        );

        $car3 = Car::updateOrCreate(
            ['id' => 'ARM-0003'],
            [
                'merk' => 'Honda',
                'jenis' => 'Brio',
                'plat' => 'H 9012 EF',
                'trans' => 'Matic',
                'status' => 'Tersedia',
                'ownership' => 'sendiri',
                'partner_id' => null,
                'partner_rate' => 0,
                'vehicle_class' => 'City Car',
            ]
        );

        $car4 = Car::updateOrCreate(
            ['id' => 'ARM-0004'],
            [
                'merk' => 'Toyota',
                'jenis' => 'Hiace Commuter',
                'plat' => 'H 3456 GH',
                'trans' => 'Manual',
                'status' => 'Tersedia',
                'ownership' => 'mitra',
                'partner_id' => 'MTR-0002',
                'partner_rate' => 600000,
                'vehicle_class' => 'Minibus',
            ]
        );

        $car5 = Car::updateOrCreate(
            ['id' => 'ARM-0005'],
            [
                'merk' => 'Toyota',
                'jenis' => 'Alphard',
                'plat' => 'H 7890 IJ',
                'trans' => 'Matic',
                'status' => 'Tersedia',
                'ownership' => 'sendiri',
                'partner_id' => null,
                'partner_rate' => 0,
                'vehicle_class' => 'Premium',
            ]
        );

        // 7. Booking / Bookings (TABLES.bookings)
        $unitsBooking1 = [
            [
                'carId' => 'ARM-0001',
                'ownership' => 'sendiri',
                'partnerId' => '',
                'rate' => 450000,
                'total' => 1350000,
                'partnerRate' => 0,
                'driverId' => 'DRV-0001',
                'driverName' => 'Slamet Riyadi',
                'driverFeePerDay' => 200000,
                'driverFee' => 600000,
                'destination' => 'Semarang - Yogyakarta',
                'destinationType' => 'Dalam kota',
                'tollCost' => 0,
                'fuelCost' => 0,
                'mealCost' => 0,
                'lodgingCost' => 0,
                'tollPerDay' => 0,
                'fuelPerDay' => 0,
                'mealPerDay' => 0,
                'lodgingPerDay' => 0,
                'dailySubtotal' => 650000,
                'otherCost' => 0,
                'otherCostNote' => '',
            ]
        ];

        $today = date('Y-m-d');
        $end1 = date('Y-m-d', strtotime('+2 days'));

        $booking1 = Booking::updateOrCreate(
            ['id' => 'BKG-0001'],
            [
                'customer_id' => 'PLG-0001',
                'car_id' => 'ARM-0001',
                'start' => $today,
                'end' => $end1,
                'days' => 3,
                'rate' => 450000,
                'partner_rate' => 0,
                'driver_id' => 'DRV-0001',
                'driver_name' => 'Slamet Riyadi',
                'driver_fee_per_day' => 200000,
                'driver_fee' => 600000,
                'destination' => 'Semarang - Yogyakarta',
                'toll_cost' => 0,
                'fuel_cost' => 0,
                'meal_cost' => 0,
                'lodging_cost' => 0,
                'total' => 1950000,
                'status' => 'Lunas',
                'units_json' => json_encode($unitsBooking1),
                'created' => now()->toIso8601String(),
            ]
        );

        // 8. Pembayaran / Payments (TABLES.payments)
        Payment::updateOrCreate(
            ['id' => 'BYR-0001'],
            [
                'customer_id' => 'PLG-0001',
                'booking_id' => 'BKG-0001',
                'amount' => 1950000,
                'status' => 'Lunas',
                'date' => $today,
            ]
        );

        // 9. Pengeluaran / Expenses (TABLES.expenses)
        Expense::updateOrCreate(
            ['id' => 'EXP-0001'],
            [
                'date' => $today,
                'category' => 'Servis dan Perawatan',
                'note' => 'Ganti oli Innova Reborn',
                'amount' => 350000,
                'created' => now()->toIso8601String(),
                'car_id' => 'ARM-0001',
            ]
        );

        // 10. Jurnal Umum / Journals (TABLES.journals)
        Journal::updateOrCreate(
            ['id' => 'JRN-0001'],
            [
                'date' => $today,
                'note' => 'Penerimaan sewa BKG-0001',
                'debit_account' => '1101',
                'credit_account' => '4101',
                'amount' => 1950000,
                'source' => 'Manual',
                'reference' => 'BKG-0001',
            ]
        );

        // 11. Pembayaran Driver / Driver Payments (TABLES.driverPayments)
        DriverPayment::updateOrCreate(
            ['id' => 'PDR0001'],
            [
                'assignment_key' => 'BKG-0001::0',
                'booking_id' => 'BKG-0001',
                'unit_index' => 0,
                'driver_id' => 'DRV-0001',
                'driver_name' => 'Slamet Riyadi',
                'date' => $today,
                'amount' => 600000,
                'note' => 'Honor driver sewa 3 hari',
            ]
        );
    }
}
