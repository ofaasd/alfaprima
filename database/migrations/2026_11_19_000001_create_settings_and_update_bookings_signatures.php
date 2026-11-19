<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Create settings table
        if (!Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $table) {
                $table->string('key')->primary();
                $table->longText('value')->nullable();
                $table->timestamps();
            });

            // Seed default settings
            $now = now();
            DB::table('settings')->insert([
                [
                    'key' => 'public_signature_url',
                    'value' => 'https://script.google.com/macros/s/AKfycbwCUeqKQNhM_JrFvXKHilzIx9K7lSuY0fPyOuAIzfbr3W4MvYukFQWmRTIapE0ab9xYZA/exec',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'key' => 'signature_name',
                    'value' => 'Alfa Prima',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'key' => 'signature_title',
                    'value' => 'Pemilik',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'key' => 'signature_image',
                    'value' => '/images/signature.png',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);
        }

        // 2. Add signature columns to bookings table
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'signature_url')) {
                $table->string('signature_url', 500)->nullable()->after('status');
            }
            if (!Schema::hasColumn('bookings', 'is_signed')) {
                $table->boolean('is_signed')->default(false)->after('signature_url');
            }
            if (!Schema::hasColumn('bookings', 'signed_at')) {
                $table->timestamp('signed_at')->nullable()->after('is_signed');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $cols = [];
            if (Schema::hasColumn('bookings', 'signature_url')) $cols[] = 'signature_url';
            if (Schema::hasColumn('bookings', 'is_signed')) $cols[] = 'is_signed';
            if (Schema::hasColumn('bookings', 'signed_at')) $cols[] = 'signed_at';
            if (!empty($cols)) {
                $table->dropColumn($cols);
            }
        });

        Schema::dropIfExists('settings');
    }
};
