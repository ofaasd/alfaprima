<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Customers Table (Pelanggan)
        Schema::create('customers', function (Blueprint $table) {
            $table->string('id')->primary(); // e.g. PLG-0001
            $table->string('nama');
            $table->text('alamat')->nullable();
            $table->string('wa')->nullable();
            $table->string('nik')->nullable();
            $table->string('sim')->nullable();
            $table->string('status')->default('Aktif'); // Aktif, Nonaktif, Blacklist
            $table->timestamps();
        });

        // 2. Partners Table (Mitra)
        Schema::create('partners', function (Blueprint $table) {
            $table->string('id')->primary(); // e.g. MTR-0001
            $table->string('name');
            $table->string('wa')->nullable();
            $table->text('address')->nullable();
            $table->string('bank')->nullable();
            $table->string('account_no')->nullable();
            $table->string('account_name')->nullable();
            $table->timestamps();
        });

        // 3. Cars Table (Armada)
        Schema::create('cars', function (Blueprint $table) {
            $table->string('id')->primary(); // e.g. ARM-0001
            $table->string('merk');
            $table->string('jenis');
            $table->string('plat');
            $table->string('trans')->default('Matic'); // Matic, Manual
            $table->string('status')->default('Tersedia'); // Tersedia, Disewa, Servis, Nonaktif
            $table->string('ownership')->default('sendiri'); // sendiri, mitra
            $table->string('partner_id')->nullable();
            $table->decimal('partner_rate', 15, 2)->default(0);
            $table->string('vehicle_class')->default('City Car')->nullable(); // Klasifikasi Armada
            $table->timestamps();

            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('set null');
        });

        // 4. Drivers Table (Driver)
        Schema::create('drivers', function (Blueprint $table) {
            $table->string('id')->primary(); // e.g. DRV-0001
            $table->string('name');
            $table->string('wa')->nullable();
            $table->text('address')->nullable();
            $table->string('license')->nullable();
            $table->string('status')->default('Aktif'); // Aktif, Nonaktif
            $table->timestamps();
        });

        // 5. Bookings Table (Booking)
        Schema::create('bookings', function (Blueprint $table) {
            $table->string('id')->primary(); // e.g. BKG-0001
            $table->string('customer_id');
            $table->string('car_id')->nullable();
            $table->date('start');
            $table->date('end');
            $table->integer('days')->default(1);
            $table->decimal('rate', 15, 2)->default(0);
            $table->decimal('partner_rate', 15, 2)->default(0);
            $table->string('driver_id')->nullable();
            $table->string('driver_name')->nullable();
            $table->decimal('driver_fee_per_day', 15, 2)->default(0);
            $table->decimal('driver_fee', 15, 2)->default(0);
            $table->string('destination')->nullable();
            $table->decimal('toll_cost', 15, 2)->default(0);
            $table->decimal('fuel_cost', 15, 2)->default(0);
            $table->decimal('meal_cost', 15, 2)->default(0);
            $table->decimal('lodging_cost', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->string('status')->default('Belum Bayar'); // Belum Bayar, DP, Lunas
            $table->longText('units_json')->nullable(); // Rincian Unit Booking JSON
            $table->string('created')->nullable(); // Tanggal Dibuat
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('restrict');
            $table->foreign('car_id')->references('id')->on('cars')->onDelete('set null');
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('set null');
        });

        // 6. Payments Table (Pembayaran)
        Schema::create('payments', function (Blueprint $table) {
            $table->string('id')->primary(); // e.g. BYR-0001
            $table->string('customer_id');
            $table->string('booking_id'); // Can be BKG-xxxx or BLY:BLY-xxxx
            $table->decimal('amount', 15, 2);
            $table->string('status')->default('Lunas'); // DP, Lunas, Kurang Bayar
            $table->date('date');
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });

        // 7. Expenses Table (Pengeluaran)
        Schema::create('expenses', function (Blueprint $table) {
            $table->string('id')->primary(); // e.g. EXP-0001
            $table->date('date');
            $table->string('category');
            $table->text('note')->nullable();
            $table->decimal('amount', 15, 2);
            $table->string('created')->nullable(); // Tanggal Catat
            $table->string('car_id')->nullable();
            $table->timestamps();

            $table->foreign('car_id')->references('id')->on('cars')->onDelete('set null');
        });

        // 8. Partner Payments Table (Pembayaran Mitra)
        Schema::create('partner_payments', function (Blueprint $table) {
            $table->string('id')->primary(); // e.g. PMT-0001
            $table->string('booking_id');
            $table->string('partner_id');
            $table->date('date');
            $table->decimal('amount', 15, 2);
            $table->string('status')->default('Dibayar');
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');
        });

        // 9. Accounts Table (Daftar Akun)
        Schema::create('accounts', function (Blueprint $table) {
            $table->string('code')->primary(); // e.g. 1101, 2101
            $table->string('name'); // e.g. Kas/Bank
            $table->string('group'); // Aset, Liabilitas, Ekuitas, Pendapatan, Beban
            $table->string('normal'); // Debit, Kredit
            $table->timestamps();
        });

        // 10. Journals Table (Jurnal Umum)
        Schema::create('journals', function (Blueprint $table) {
            $table->string('id')->primary(); // e.g. JRN-0001
            $table->date('date');
            $table->text('note');
            $table->string('debit_account'); // 1101, 2101, 4101, 4201, 5101
            $table->string('credit_account');
            $table->decimal('amount', 15, 2);
            $table->string('source')->default('Manual');
            $table->string('reference')->nullable();
            $table->timestamps();
        });

        // 11. Driver Payments Table (Pembayaran Driver)
        Schema::create('driver_payments', function (Blueprint $table) {
            $table->string('id')->primary(); // e.g. PDR0001
            $table->string('assignment_key')->nullable();
            $table->string('booking_id')->nullable();
            $table->integer('unit_index')->default(0);
            $table->string('driver_id')->nullable();
            $table->string('driver_name')->nullable();
            $table->date('date');
            $table->decimal('amount', 15, 2)->default(0);
            $table->text('note')->nullable();
            $table->timestamps();
        });

        // 12. Other Charges Table (Biaya Lain-lain)
        Schema::create('other_charges', function (Blueprint $table) {
            $table->string('id')->primary(); // e.g. BLY-0001
            $table->string('customer_id');
            $table->string('booking_id')->nullable();
            $table->date('date');
            $table->decimal('amount', 15, 2)->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('other_charges');
        Schema::dropIfExists('driver_payments');
        Schema::dropIfExists('journals');
        Schema::dropIfExists('accounts');
        Schema::dropIfExists('partner_payments');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('drivers');
        Schema::dropIfExists('cars');
        Schema::dropIfExists('partners');
        Schema::dropIfExists('customers');
    }
};
