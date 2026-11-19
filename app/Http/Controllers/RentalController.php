<?php

namespace App\Http\Controllers;

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
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RentalController extends Controller
{
    /**
     * Display the main application page.
     */
    public function index()
    {
        return view('rental.index');
    }

    /**
     * Generate sequential custom IDs like PLG-0001, ARM-0001, etc.
     */
    private function getNextId($modelClass, string $prefix): string
    {
        $ids = $modelClass::pluck('id')->toArray();
        $max = 0;
        foreach ($ids as $id) {
            $num = (int) preg_replace('/\D/', '', $id);
            if ($num > $max) {
                $max = $num;
            }
        }
        return $prefix . str_pad($max + 1, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Load all system data for frontend hydration.
     */
    public function loadData()
    {
        if (User::count() === 0) {
            User::create([
                'username' => 'alfaprima',
                'name' => 'Administrator Alfa Prima',
                'email' => 'admin@alfarent.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'active' => true,
            ]);
        }

        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => true,
                'user' => null,
                'db' => null,
            ]);
        }

        $settings = [];
        try {
            if (Schema::hasTable('settings')) {
                $settings = Setting::pluck('value', 'key')->toArray();
            }
        } catch (\Throwable $e) {
            $settings = [];
        }

        if (empty($settings['public_signature_url'])) {
            $settings['public_signature_url'] = env('ALFA_PRIMA_PUBLIC_SIGNATURE_URL', 'https://script.google.com/macros/s/AKfycbwCUeqKQNhM_JrFvXKHilzIx9K7lSuY0fPyOuAIzfbr3W4MvYukFQWmRTIapE0ab9xYZA/exec');
        }
        if (empty($settings['signature_name'])) {
            $settings['signature_name'] = 'Alfa Prima';
        }
        if (empty($settings['signature_title'])) {
            $settings['signature_title'] = 'Pemilik';
        }
        if (empty($settings['signature_image'])) {
            $settings['signature_image'] = '/images/signature.png';
        }

        return response()->json([
            'success' => true,
            'user' => $user ? [
                'id' => $user->id,
                'username' => $user->username,
                'role' => $user->role,
                'active' => (bool)$user->active,
            ] : null,
            'db' => [
                'customers' => Customer::orderBy('id')->get(),
                'cars' => Car::orderBy('id')->get(),
                'drivers' => Driver::orderBy('id')->get(),
                'partners' => Partner::orderBy('id')->get(),
                'bookings' => Booking::orderBy('id', 'desc')->get(),
                'payments' => Payment::orderBy('date', 'desc')->get(),
                'expenses' => Expense::orderBy('date', 'desc')->get(),
                'partnerPayments' => PartnerPayment::orderBy('date', 'desc')->get(),
                'journals' => Journal::orderBy('date', 'desc')->get(),
                'accounts' => Account::orderBy('code')->get(),
                'driverPayments' => DriverPayment::orderBy('date', 'desc')->get(),
                'otherCharges' => OtherCharge::orderBy('date', 'desc')->get(),
                'settings' => $settings,
            ],
        ]);
    }

    /**
     * Authentication: Login
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // If no user exists yet, auto-create the initial admin account
        if (User::count() === 0) {
            User::create([
                'username' => 'alfaprima',
                'name' => 'Administrator Alfa Prima',
                'email' => 'admin@alfarent.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'active' => true,
            ]);
        }

        $inputUsername = trim($request->username);
        $user = User::whereRaw('LOWER(username) = ?', [strtolower($inputUsername)])->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Username atau password salah.'], 401);
        }

        if (!$user->active) {
            return response()->json(['success' => false, 'message' => 'Akun dinonaktifkan. Hubungi admin.'], 403);
        }

        Auth::login($user);

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'role' => $user->role,
                'active' => (bool)$user->active,
            ],
        ]);
    }

    /**
     * Authentication: Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['success' => true]);
    }

    /**
     * Admin: List users
     */
    public function listUsers()
    {
        if (Auth::user()?->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $users = User::select('id', 'username', 'role', 'active')->orderBy('id')->get();
        return response()->json($users);
    }

    /**
     * Admin: Create Employee Account
     */
    public function createUser(Request $request)
    {
        if (Auth::user()?->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'username' => 'required|string|min:4|unique:users,username',
            'password' => 'required|string|min:10',
        ]);

        $user = User::create([
            'username' => $request->username,
            'name' => $request->username,
            'email' => $request->username . '@alfarent.local',
            'password' => Hash::make($request->password),
            'role' => 'karyawan',
            'active' => true,
        ]);

        return response()->json(['success' => true, 'user' => $user]);
    }

    /**
     * Admin: Toggle User active state
     */
    public function toggleUser(Request $request, $id)
    {
        if (Auth::user()?->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $user = User::findOrFail($id);
        if ($user->role === 'admin') {
            return response()->json(['message' => 'Akun admin tidak dapat dinonaktifkan.'], 400);
        }

        $user->active = (bool) $request->input('active', !$user->active);
        $user->save();

        return response()->json(['success' => true, 'user' => $user]);
    }

    /**
     * Customer: Save (Create or Update)
     */
    public function saveCustomer(Request $request)
    {
        $id = $request->id ?: $this->getNextId(Customer::class, 'PLG-');

        $customer = Customer::updateOrCreate(
            ['id' => $id],
            [
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'wa' => $request->wa,
                'nik' => $request->nik,
                'sim' => $request->sim,
                'status' => $request->status ?: 'Aktif',
            ]
        );

        return response()->json(['success' => true, 'data' => $customer]);
    }

    /**
     * Customer: Delete
     */
    public function deleteCustomer($id)
    {
        if (Auth::user()?->role !== 'admin') {
            return response()->json(['message' => 'Hanya admin yang dapat menghapus data.'], 403);
        }

        if (Booking::where('customer_id', $id)->exists()) {
            return response()->json(['message' => 'Pelanggan sudah memiliki booking dan tidak dapat dihapus.'], 422);
        }

        Customer::where('id', $id)->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Car: Save (Create or Update)
     */
    public function saveCar(Request $request)
    {
        $id = $request->id ?: $this->getNextId(Car::class, 'ARM-');

        $car = Car::updateOrCreate(
            ['id' => $id],
            [
                'merk' => $request->merk,
                'jenis' => $request->jenis,
                'plat' => strtoupper(trim($request->plat)),
                'trans' => $request->trans ?: 'Matic',
                'status' => $request->status ?: 'Tersedia',
                'ownership' => $request->ownership ?: 'sendiri',
                'partner_id' => $request->partner_id ?? $request->partnerId ?? null,
                'partner_rate' => (float) ($request->partner_rate ?? $request->partnerRate ?? 0),
                'vehicle_class' => $request->vehicle_class ?? $request->vehicleClass ?? null,
            ]
        );

        return response()->json(['success' => true, 'data' => $car]);
    }

    /**
     * Car: Delete
     */
    public function deleteCar($id)
    {
        if (Auth::user()?->role !== 'admin') {
            return response()->json(['message' => 'Hanya admin yang dapat menghapus data.'], 403);
        }

        if (Booking::where('car_id', $id)->exists()) {
            return response()->json(['message' => 'Armada sudah memiliki riwayat booking dan tidak dapat dihapus. Ubah status menjadi Nonaktif.'], 422);
        }

        Car::where('id', $id)->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Driver: Save (Create or Update)
     */
    public function saveDriver(Request $request)
    {
        $id = $request->id ?: $this->getNextId(Driver::class, 'DRV-');

        $driver = Driver::updateOrCreate(
            ['id' => $id],
            [
                'name' => $request->name,
                'wa' => $request->wa,
                'address' => $request->address,
                'license' => $request->license,
                'status' => $request->status ?: 'Aktif',
            ]
        );

        return response()->json(['success' => true, 'data' => $driver]);
    }

    /**
     * Driver: Delete
     */
    public function deleteDriver($id)
    {
        if (Auth::user()?->role !== 'admin') {
            return response()->json(['message' => 'Hanya admin yang dapat menghapus data.'], 403);
        }

        if (Booking::where('driver_id', $id)->exists()) {
            return response()->json(['message' => 'Driver sudah terhubung dengan booking. Ubah status menjadi Nonaktif.'], 422);
        }

        Driver::where('id', $id)->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Partner: Save
     */
    public function savePartner(Request $request)
    {
        $id = $request->id ?: $this->getNextId(Partner::class, 'MTR-');

        $partner = Partner::updateOrCreate(
            ['id' => $id],
            [
                'name' => $request->name,
                'wa' => $request->wa,
                'address' => $request->address,
                'bank' => $request->bank,
                'account_no' => $request->account_no,
                'account_name' => $request->account_name,
            ]
        );

        return response()->json(['success' => true, 'data' => $partner]);
    }

    /**
     * Booking: Save (Create or Update)
     */
    public function saveBooking(Request $request)
    {
        $editId = $request->id;
        $customerId = $request->customer_id;
        $carId = $request->car_id;
        $start = $request->start;
        $end = $request->end;
        $rate = (float) $request->rate;
        $days = (int) $request->days;

        if (!$customerId || !$carId || $days < 1 || $rate <= 0) {
            return response()->json(['message' => 'Periksa data booking.'], 422);
        }

        $customer = Customer::find($customerId);
        if (!$customer || $customer->status !== 'Aktif') {
            return response()->json(['message' => 'Pelanggan harus berstatus Aktif untuk booking.'], 422);
        }

        $car = Car::find($carId);
        if (!$car || !in_array($car->status, ['Tersedia', 'Disewa'])) {
            return response()->json(['message' => 'Armada tidak tersedia untuk booking.'], 422);
        }

        // Check date conflict with other bookings
        $clash = Booking::where('car_id', $carId)
            ->when($editId, fn($q) => $q->where('id', '!=', $editId))
            ->where(function ($q) use ($start, $end) {
                $q->where('start', '<=', $end)->where('end', '>=', $start);
            })
            ->exists();

        if ($clash) {
            return response()->json(['message' => 'Jadwal armada bentrok dengan booking lain.'], 422);
        }

        $driverFeePerDay = (float) ($request->driver_fee_per_day ?: 0);
        $tollCost = (float) ($request->toll_cost ?: 0);
        $fuelCost = (float) ($request->fuel_cost ?: 0);
        $mealCost = (float) ($request->meal_cost ?: 0);
        $lodgingCost = (float) ($request->lodging_cost ?: 0);

        $driverFeeTotal = $days * $driverFeePerDay;
        $total = ($days * $rate) + $driverFeeTotal + $tollCost + $fuelCost + $mealCost + $lodgingCost;

        $id = $editId ?: $this->getNextId(Booking::class, 'BKG-');

        $driver = $request->driver_id ? Driver::find($request->driver_id) : null;
        $driverName = $driver ? $driver->name : ($request->driver_name ?: null);

        $unitsJson = null;
        if ($request->has('units_json')) {
            $unitsJson = is_string($request->units_json) ? $request->units_json : json_encode($request->units_json);
        } elseif ($request->has('units')) {
            $unitsJson = json_encode($request->units);
        }

        $booking = Booking::updateOrCreate(
            ['id' => $id],
            [
                'customer_id' => $customerId,
                'car_id' => $carId,
                'start' => $start,
                'end' => $end,
                'days' => $days,
                'rate' => $rate,
                'partner_rate' => (float) ($car->partner_rate ?: 0),
                'driver_id' => $driver ? $driver->id : null,
                'driver_name' => $driverName,
                'driver_fee_per_day' => $driverFeePerDay,
                'driver_fee' => $driverFeeTotal,
                'destination' => $request->destination ?: '',
                'toll_cost' => $tollCost,
                'fuel_cost' => $fuelCost,
                'meal_cost' => $mealCost,
                'lodging_cost' => $lodgingCost,
                'total' => $total,
                'units_json' => $unitsJson,
                'created' => $request->created ?: now()->toIso8601String(),
                'signature_url' => $request->signature_url ?: ($request->signatureUrl ?: null),
                'is_signed' => (bool) ($request->is_signed ?? $request->isSigned ?? false),
                'signed_at' => $request->signed_at ?: ($request->signedAt ?: null),
            ]
        );

        // Update booking status based on payment
        $totalPaid = Payment::where('booking_id', $booking->id)->sum('amount');
        if ($totalPaid <= 0) {
            $booking->status = 'Belum Bayar';
        } elseif ($totalPaid >= $booking->total) {
            $booking->status = 'Lunas';
        } else {
            $booking->status = 'DP';
        }
        $booking->save();

        return response()->json(['success' => true, 'data' => $booking]);
    }

    /**
     * Booking: Delete
     */
    public function deleteBooking($id)
    {
        if (Auth::user()?->role !== 'admin') {
            return response()->json(['message' => 'Hanya admin yang dapat menghapus data.'], 403);
        }

        DB::transaction(function () use ($id) {
            Payment::where('booking_id', $id)->delete();
            PartnerPayment::where('booking_id', $id)->delete();
            Booking::where('id', $id)->delete();
        });

        return response()->json(['success' => true]);
    }

    /**
     * Payment: Save
     */
    public function savePayment(Request $request)
    {
        $booking = Booking::find($request->booking_id);
        $amount = (float) $request->amount;

        if (!$booking || $amount <= 0) {
            return response()->json(['message' => 'Pilih booking dan masukkan nominal yang valid.'], 422);
        }

        $paidSoFar = Payment::where('booking_id', $booking->id)->sum('amount');
        $remain = max(0, $booking->total - $paidSoFar);

        if ($amount > $remain) {
            return response()->json(['message' => 'Pembayaran melebihi sisa tagihan Rp' . number_format($remain, 0, ',', '.')], 422);
        }

        $id = $this->getNextId(Payment::class, 'BYR-');
        $status = ($amount + $paidSoFar >= $booking->total) ? 'Lunas' : 'DP';

        $payment = Payment::create([
            'id' => $id,
            'booking_id' => $booking->id,
            'customer_id' => $booking->customer_id,
            'amount' => $amount,
            'status' => $status,
            'date' => now()->toDateString(),
        ]);

        // Update booking status
        $booking->status = $status;
        $booking->save();

        return response()->json(['success' => true, 'data' => $payment]);
    }

    /**
     * Payment: Update (Admin only)
     */
    public function updatePayment(Request $request, $id)
    {
        if (Auth::user()?->role !== 'admin') {
            return response()->json(['message' => 'Hanya admin yang dapat mengubah pembayaran.'], 403);
        }

        $payment = Payment::findOrFail($id);
        $booking = Booking::findOrFail($payment->booking_id);
        $newAmount = (float) $request->amount;

        if ($newAmount <= 0) {
            return response()->json(['message' => 'Nominal pembayaran tidak valid.'], 422);
        }

        $otherPaid = Payment::where('booking_id', $payment->booking_id)
            ->where('id', '!=', $id)
            ->sum('amount');

        if ($otherPaid + $newAmount > $booking->total) {
            return response()->json(['message' => 'Total pembayaran melebihi total tagihan booking.'], 422);
        }

        $payment->amount = $newAmount;
        $payment->status = ($otherPaid + $newAmount >= $booking->total) ? 'Lunas' : 'DP';
        $payment->save();

        // Update booking status
        $totalPaid = $otherPaid + $newAmount;
        $booking->status = ($totalPaid <= 0) ? 'Belum Bayar' : (($totalPaid >= $booking->total) ? 'Lunas' : 'DP');
        $booking->save();

        return response()->json(['success' => true, 'data' => $payment]);
    }

    /**
     * Expense: Save
     */
    public function saveExpense(Request $request)
    {
        $amount = (float) $request->amount;
        if ($amount <= 0) {
            return response()->json(['message' => 'Nominal pengeluaran harus lebih dari 0.'], 422);
        }

        $id = $this->getNextId(Expense::class, 'EXP-');

        $expense = Expense::create([
            'id' => $id,
            'date' => $request->date ?: now()->toDateString(),
            'category' => $request->category,
            'amount' => $amount,
            'car_id' => $request->car_id ?: null,
            'note' => $request->note ?: '',
        ]);

        return response()->json(['success' => true, 'data' => $expense]);
    }

    /**
     * Expense: Delete
     */
    public function deleteExpense($id)
    {
        if (Auth::user()?->role !== 'admin') {
            return response()->json(['message' => 'Hanya admin yang dapat menghapus data.'], 403);
        }

        Expense::where('id', $id)->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Partner Payment: Save
     */
    public function savePartnerPayment(Request $request)
    {
        $amount = (float) $request->amount;
        if ($amount <= 0) {
            return response()->json(['message' => 'Nominal harus lebih dari 0.'], 422);
        }

        $id = $this->getNextId(PartnerPayment::class, 'PMT-');

        $partnerPayment = PartnerPayment::create([
            'id' => $id,
            'booking_id' => $request->booking_id,
            'partner_id' => $request->partner_id,
            'date' => $request->date ?: now()->toDateString(),
            'amount' => $amount,
            'status' => 'Dibayar',
            'note' => $request->note ?: '',
        ]);

        return response()->json(['success' => true, 'data' => $partnerPayment]);
    }

    /**
     * Driver Payment: Save
     */
    public function saveDriverPayment(Request $request)
    {
        $amount = (float) $request->amount;
        if ($amount <= 0) {
            return response()->json(['message' => 'Nominal harus lebih dari 0.'], 422);
        }

        $id = $request->id ?: $this->getNextId(DriverPayment::class, 'PDR');

        $driverPayment = DriverPayment::create([
            'id' => $id,
            'assignment_key' => $request->assignment_key ?? $request->assignmentKey ?? '',
            'booking_id' => $request->booking_id ?? $request->bookingId ?? null,
            'unit_index' => (int) ($request->unit_index ?? $request->unitIndex ?? 0),
            'driver_id' => $request->driver_id ?? $request->driverId ?? null,
            'driver_name' => $request->driver_name ?? $request->driverName ?? '',
            'date' => $request->date ?: now()->toDateString(),
            'amount' => $amount,
            'note' => $request->note ?: '',
        ]);

        return response()->json(['success' => true, 'data' => $driverPayment]);
    }

    /**
     * Other Charge: Save
     */
    public function saveOtherCharge(Request $request)
    {
        $amount = (float) $request->amount;
        if ($amount <= 0) {
            return response()->json(['message' => 'Nominal harus lebih dari 0.'], 422);
        }

        $id = $request->id ?: $this->getNextId(OtherCharge::class, 'BLY-');

        $otherCharge = OtherCharge::create([
            'id' => $id,
            'customer_id' => $request->customer_id ?? $request->customerId ?? null,
            'booking_id' => $request->booking_id ?? $request->bookingId ?? null,
            'date' => $request->date ?: now()->toDateString(),
            'amount' => $amount,
            'description' => $request->description ?: '',
        ]);

        return response()->json(['success' => true, 'data' => $otherCharge]);
    }

    /**
     * Account: Save
     */
    public function saveAccount(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'name' => 'required|string',
            'group' => 'required|string',
            'normal' => 'required|string',
        ]);

        $account = Account::updateOrCreate(
            ['code' => $request->code],
            [
                'name' => $request->name,
                'group' => $request->group,
                'normal' => $request->normal,
            ]
        );

        return response()->json(['success' => true, 'data' => $account]);
    }

    /**
     * Delete payment
     */
    public function deletePayment($id)
    {
        if (Auth::user()?->role !== 'admin') {
            return response()->json(['message' => 'Hanya admin yang dapat menghapus pembayaran.'], 403);
        }

        $payment = Payment::find($id);
        if ($payment) {
            $booking = Booking::find($payment->booking_id);
            $payment->delete();

            if ($booking) {
                $totalPaid = Payment::where('booking_id', $booking->id)->sum('amount');
                $booking->status = ($totalPaid <= 0) ? 'Belum Bayar' : (($totalPaid >= $booking->total) ? 'Lunas' : 'DP');
                $booking->save();
            }
        }

        return response()->json(['success' => true]);
    }

    /**
     * Batch save/sync all database tables (matching persistToDatabase / apiSave)
     */
    public function saveAll(Request $request)
    {
        $data = $request->all();
        if (!is_array($data)) {
            return response()->json(['message' => 'Data tidak valid.'], 422);
        }

        DB::transaction(function () use ($data) {
            Schema::disableForeignKeyConstraints();

            // 1. Partners
            if (isset($data['partners']) && is_array($data['partners'])) {
                $ids = [];
                foreach ($data['partners'] as $p) {
                    if (empty($p['id'])) continue;
                    $ids[] = $p['id'];
                    Partner::updateOrCreate(
                        ['id' => $p['id']],
                        [
                            'name' => $p['name'] ?? '',
                            'wa' => $p['wa'] ?? '',
                            'address' => $p['address'] ?? '',
                            'bank' => $p['bank'] ?? '',
                            'account_no' => $p['accountNo'] ?? $p['account_no'] ?? '',
                            'account_name' => $p['accountName'] ?? $p['account_name'] ?? '',
                        ]
                    );
                }
                if (!empty($ids)) {
                    Partner::whereNotIn('id', $ids)->whereDoesntHave('cars')->delete();
                }
            }

            // 2. Customers
            if (isset($data['customers']) && is_array($data['customers'])) {
                $ids = [];
                foreach ($data['customers'] as $c) {
                    if (empty($c['id'])) continue;
                    $ids[] = $c['id'];
                    Customer::updateOrCreate(
                        ['id' => $c['id']],
                        [
                            'nama' => $c['nama'] ?? '',
                            'alamat' => $c['alamat'] ?? '',
                            'wa' => $c['wa'] ?? '',
                            'nik' => $c['nik'] ?? null,
                            'sim' => $c['sim'] ?? null,
                            'status' => $c['status'] ?? 'Aktif',
                        ]
                    );
                }
                if (!empty($ids)) {
                    Customer::whereNotIn('id', $ids)->whereDoesntHave('bookings')->delete();
                }
            }

            // 3. Cars
            if (isset($data['cars']) && is_array($data['cars'])) {
                $ids = [];
                foreach ($data['cars'] as $c) {
                    if (empty($c['id'])) continue;
                    $ids[] = $c['id'];
                    Car::updateOrCreate(
                        ['id' => $c['id']],
                        [
                            'merk' => $c['merk'] ?? '',
                            'jenis' => $c['jenis'] ?? '',
                            'plat' => strtoupper(trim($c['plat'] ?? '')),
                            'trans' => $c['trans'] ?? 'Matic',
                            'status' => $c['status'] ?? 'Tersedia',
                            'ownership' => $c['ownership'] ?? 'sendiri',
                            'partner_id' => $c['partnerId'] ?? $c['partner_id'] ?? null,
                            'partner_rate' => (float) ($c['partnerRate'] ?? $c['partner_rate'] ?? 0),
                            'vehicle_class' => $c['vehicleClass'] ?? $c['vehicle_class'] ?? 'City Car',
                        ]
                    );
                }
                if (!empty($ids)) {
                    Car::whereNotIn('id', $ids)->whereDoesntHave('bookings')->delete();
                }
            }

            // 4. Drivers
            if (isset($data['drivers']) && is_array($data['drivers'])) {
                $ids = [];
                foreach ($data['drivers'] as $d) {
                    if (empty($d['id'])) continue;
                    $ids[] = $d['id'];
                    Driver::updateOrCreate(
                        ['id' => $d['id']],
                        [
                            'name' => $d['name'] ?? '',
                            'wa' => $d['wa'] ?? '',
                            'address' => $d['address'] ?? '',
                            'license' => $d['license'] ?? '',
                            'status' => $d['status'] ?? 'Aktif',
                        ]
                    );
                }
                if (!empty($ids)) {
                    Driver::whereNotIn('id', $ids)->whereDoesntHave('bookings')->delete();
                }
            }

            // 5. Bookings
            if (isset($data['bookings']) && is_array($data['bookings'])) {
                $ids = [];
                foreach ($data['bookings'] as $b) {
                    if (empty($b['id'])) continue;
                    $ids[] = $b['id'];
                    $units = $b['units'] ?? null;
                    $unitsJson = $b['unitsJson'] ?? $b['units_json'] ?? null;
                    if ($units && is_array($units)) {
                        $unitsJson = json_encode($units);
                    }
                    Booking::updateOrCreate(
                        ['id' => $b['id']],
                        [
                            'customer_id' => $b['customerId'] ?? $b['customer_id'] ?? null,
                            'car_id' => $b['carId'] ?? $b['car_id'] ?? null,
                            'start' => $b['start'] ?? null,
                            'end' => $b['end'] ?? null,
                            'days' => (int) ($b['days'] ?? 0),
                            'rate' => (float) ($b['rate'] ?? 0),
                            'partner_rate' => (float) ($b['partnerRate'] ?? $b['partner_rate'] ?? 0),
                            'driver_id' => $b['driverId'] ?? $b['driver_id'] ?? null,
                            'driver_name' => $b['driverName'] ?? $b['driver_name'] ?? null,
                            'driver_fee_per_day' => (float) ($b['driverFeePerDay'] ?? $b['driver_fee_per_day'] ?? 0),
                            'driver_fee' => (float) ($b['driverFee'] ?? $b['driver_fee'] ?? 0),
                            'destination' => $b['destination'] ?? '',
                            'toll_cost' => (float) ($b['tollCost'] ?? $b['toll_cost'] ?? 0),
                            'fuel_cost' => (float) ($b['fuelCost'] ?? $b['fuel_cost'] ?? 0),
                            'meal_cost' => (float) ($b['mealCost'] ?? $b['meal_cost'] ?? 0),
                            'lodging_cost' => (float) ($b['lodgingCost'] ?? $b['lodging_cost'] ?? 0),
                            'total' => (float) ($b['total'] ?? 0),
                            'status' => $b['status'] ?? 'Belum Bayar',
                            'units_json' => $unitsJson,
                            'created' => $b['created'] ?? now()->toIso8601String(),
                            'signature_url' => $b['signatureUrl'] ?? $b['signature_url'] ?? null,
                            'is_signed' => (bool) (!empty($b['isSigned'] ?? $b['is_signed'])),
                            'signed_at' => $b['signedAt'] ?? $b['signed_at'] ?? null,
                        ]
                    );
                }
                if (!empty($ids)) {
                    Booking::whereNotIn('id', $ids)->delete();
                }
            }

            // 6. Payments
            if (isset($data['payments']) && is_array($data['payments'])) {
                $ids = [];
                foreach ($data['payments'] as $p) {
                    if (empty($p['id'])) continue;
                    $ids[] = $p['id'];
                    Payment::updateOrCreate(
                        ['id' => $p['id']],
                        [
                            'customer_id' => $p['customerId'] ?? $p['customer_id'] ?? null,
                            'booking_id' => $p['bookingId'] ?? $p['booking_id'] ?? null,
                            'amount' => (float) ($p['amount'] ?? 0),
                            'status' => $p['status'] ?? 'Lunas',
                            'date' => $p['date'] ?? now()->toDateString(),
                        ]
                    );
                }
                if (!empty($ids)) {
                    Payment::whereNotIn('id', $ids)->delete();
                }
            }

            // 7. Other Charges
            if (isset($data['otherCharges']) && is_array($data['otherCharges'])) {
                $ids = [];
                foreach ($data['otherCharges'] as $o) {
                    if (empty($o['id'])) continue;
                    $ids[] = $o['id'];
                    OtherCharge::updateOrCreate(
                        ['id' => $o['id']],
                        [
                            'customer_id' => $o['customerId'] ?? $o['customer_id'] ?? null,
                            'booking_id' => $o['bookingId'] ?? $o['booking_id'] ?? null,
                            'date' => $o['date'] ?? now()->toDateString(),
                            'amount' => (float) ($o['amount'] ?? 0),
                            'description' => $o['description'] ?? '',
                        ]
                    );
                }
                if (!empty($ids)) {
                    OtherCharge::whereNotIn('id', $ids)->delete();
                }
            }

            // 8. Expenses
            if (isset($data['expenses']) && is_array($data['expenses'])) {
                $ids = [];
                foreach ($data['expenses'] as $e) {
                    if (empty($e['id'])) continue;
                    $ids[] = $e['id'];
                    Expense::updateOrCreate(
                        ['id' => $e['id']],
                        [
                            'date' => $e['date'] ?? now()->toDateString(),
                            'category' => $e['category'] ?? '',
                            'note' => $e['note'] ?? '',
                            'amount' => (float) ($e['amount'] ?? 0),
                            'created' => $e['created'] ?? now()->toIso8601String(),
                            'car_id' => $e['carId'] ?? $e['car_id'] ?? null,
                        ]
                    );
                }
                if (!empty($ids)) {
                    Expense::whereNotIn('id', $ids)->delete();
                }
            }

            // 9. Partner Payments
            if (isset($data['partnerPayments']) && is_array($data['partnerPayments'])) {
                $ids = [];
                foreach ($data['partnerPayments'] as $pp) {
                    if (empty($pp['id'])) continue;
                    $ids[] = $pp['id'];
                    PartnerPayment::updateOrCreate(
                        ['id' => $pp['id']],
                        [
                            'booking_id' => $pp['bookingId'] ?? $pp['booking_id'] ?? null,
                            'partner_id' => $pp['partnerId'] ?? $pp['partner_id'] ?? null,
                            'date' => $pp['date'] ?? now()->toDateString(),
                            'amount' => (float) ($pp['amount'] ?? 0),
                            'status' => $pp['status'] ?? 'Dibayar',
                            'note' => $pp['note'] ?? '',
                        ]
                    );
                }
                if (!empty($ids)) {
                    PartnerPayment::whereNotIn('id', $ids)->delete();
                }
            }

            // 10. Accounts
            if (isset($data['accounts']) && is_array($data['accounts'])) {
                $codes = [];
                foreach ($data['accounts'] as $a) {
                    if (empty($a['code'])) continue;
                    $codes[] = $a['code'];
                    Account::updateOrCreate(
                        ['code' => $a['code']],
                        [
                            'name' => $a['name'],
                            'group' => $a['group'],
                            'normal' => $a['normal'],
                        ]
                    );
                }
                if (!empty($codes)) {
                    Account::whereNotIn('code', $codes)->delete();
                }
            }

            // 11. Journals
            if (isset($data['journals']) && is_array($data['journals'])) {
                $ids = [];
                foreach ($data['journals'] as $j) {
                    if (empty($j['id'])) continue;
                    $ids[] = $j['id'];
                    Journal::updateOrCreate(
                        ['id' => $j['id']],
                        [
                            'date' => $j['date'] ?? now()->toDateString(),
                            'note' => $j['note'] ?? '',
                            'debit_account' => $j['debitAccount'] ?? $j['debit_account'] ?? '',
                            'credit_account' => $j['creditAccount'] ?? $j['credit_account'] ?? '',
                            'amount' => (float) ($j['amount'] ?? 0),
                            'source' => $j['source'] ?? 'Manual',
                            'reference' => $j['reference'] ?? '',
                        ]
                    );
                }
                if (!empty($ids)) {
                    Journal::whereNotIn('id', $ids)->delete();
                }
            }

            // 12. Driver Payments
            if (isset($data['driverPayments']) && is_array($data['driverPayments'])) {
                $ids = [];
                foreach ($data['driverPayments'] as $dp) {
                    if (empty($dp['id'])) continue;
                    $ids[] = $dp['id'];
                    DriverPayment::updateOrCreate(
                        ['id' => $dp['id']],
                        [
                            'assignment_key' => $dp['assignmentKey'] ?? $dp['assignment_key'] ?? '',
                            'booking_id' => $dp['bookingId'] ?? $dp['booking_id'] ?? null,
                            'unit_index' => (int) ($dp['unitIndex'] ?? $dp['unit_index'] ?? 0),
                            'driver_id' => $dp['driverId'] ?? $dp['driver_id'] ?? null,
                            'driver_name' => $dp['driverName'] ?? $dp['driver_name'] ?? '',
                            'date' => $dp['date'] ?? now()->toDateString(),
                            'amount' => (float) ($dp['amount'] ?? 0),
                            'note' => $dp['note'] ?? '',
                        ]
                    );
                }
                if (!empty($ids)) {
                    DriverPayment::whereNotIn('id', $ids)->delete();
                }
            }

            // 13. Settings
            if (isset($data['settings']) && is_array($data['settings']) && Schema::hasTable('settings')) {
                foreach ($data['settings'] as $k => $v) {
                    if (is_string($k)) {
                        Setting::set($k, is_string($v) ? $v : json_encode($v));
                    }
                }
            }

            Schema::enableForeignKeyConstraints();
        });

        return response()->json([
            'ok' => true,
            'success' => true,
            'savedAt' => now()->toIso8601String(),
        ]);
    }

    /**
     * Accounting Journal: Save
     */
    public function saveJournal(Request $request)
    {
        $amount = (float) $request->amount;
        if ($amount <= 0 || $request->debit_account === $request->credit_account) {
            return response()->json(['message' => 'Nominal harus positif dan akun debit/kredit harus berbeda.'], 422);
        }

        $id = $this->getNextId(Journal::class, 'JRN-');

        $journal = Journal::create([
            'id' => $id,
            'date' => $request->date ?: now()->toDateString(),
            'note' => $request->note,
            'debit_account' => $request->debit_account,
            'credit_account' => $request->credit_account,
            'amount' => $amount,
            'source' => 'Manual',
            'reference' => $request->reference ?: '',
        ]);

        return response()->json(['success' => true, 'data' => $journal]);
    }

    /**
     * Backup JSON export
     */
    public function backupJson()
    {
        $data = [
            'customers' => Customer::all(),
            'cars' => Car::all(),
            'drivers' => Driver::all(),
            'partners' => Partner::all(),
            'bookings' => Booking::all(),
            'payments' => Payment::all(),
            'expenses' => Expense::all(),
            'partnerPayments' => PartnerPayment::all(),
            'driverPayments' => DriverPayment::all(),
            'otherCharges' => OtherCharge::all(),
            'accounts' => Account::all(),
            'journals' => Journal::all(),
        ];

        return response()->json($data)
            ->header('Content-Disposition', 'attachment; filename="backup_alfa_prima_rent_car.json"');
    }

    /**
     * Restore JSON import
     */
    public function restoreJson(Request $request)
    {
        if (Auth::user()?->role !== 'admin') {
            return response()->json(['message' => 'Hanya admin yang dapat memulihkan data.'], 403);
        }

        $data = json_decode($request->getContent(), true);
        if (!$data || !is_array($data)) {
            return response()->json(['message' => 'Format file JSON tidak valid.'], 422);
        }

        DB::transaction(function () use ($data) {
            Schema::disableForeignKeyConstraints();
            DriverPayment::truncate();
            OtherCharge::truncate();
            PartnerPayment::truncate();
            Journal::truncate();
            Expense::truncate();
            Payment::truncate();
            Booking::truncate();
            Driver::truncate();
            Car::truncate();
            Partner::truncate();
            Customer::truncate();
            Account::truncate();

            if (!empty($data['accounts'])) Account::insert($data['accounts']);
            if (!empty($data['customers'])) Customer::insert($data['customers']);
            if (!empty($data['partners'])) Partner::insert($data['partners']);
            if (!empty($data['cars'])) Car::insert($data['cars']);
            if (!empty($data['drivers'])) Driver::insert($data['drivers']);
            if (!empty($data['bookings'])) Booking::insert($data['bookings']);
            if (!empty($data['payments'])) Payment::insert($data['payments']);
            if (!empty($data['expenses'])) Expense::insert($data['expenses']);
            if (!empty($data['partnerPayments'])) PartnerPayment::insert($data['partnerPayments']);
            if (!empty($data['driverPayments'])) DriverPayment::insert($data['driverPayments']);
            if (!empty($data['otherCharges'])) OtherCharge::insert($data['otherCharges']);
            if (!empty($data['journals'])) Journal::insert($data['journals']);
            Schema::enableForeignKeyConstraints();
        });

        return response()->json(['success' => true, 'message' => 'Backup berhasil dipulihkan.']);
    }

    /**
     * Export Bookings to CSV
     */
    public function exportCsv(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="laporan_booking_alfa_prima.csv"',
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');
            fputs($handle, "\xEF\xBB\xBF"); // BOM for UTF-8 Excel compatibility

            fputcsv($handle, [
                'ID Booking', 'ID Pelanggan', 'Nama', 'ID Armada', 'Jenis Armada',
                'Tanggal Awal', 'Tanggal Akhir', 'Lama Hari', 'Harga/Hari', 'Total',
                'Dibayar', 'Sisa', 'Status'
            ], ';');

            $bookings = Booking::with(['customer', 'car', 'payments'])->get();

            foreach ($bookings as $b) {
                $paid = $b->payments->sum('amount');
                $remain = max(0, $b->total - $paid);
                $status = ($paid <= 0) ? 'Belum Bayar' : (($paid >= $b->total) ? 'Lunas' : 'DP');

                fputcsv($handle, [
                    $b->id,
                    $b->customer_id,
                    $b->customer?->nama ?? '',
                    $b->car_id,
                    $b->car?->jenis ?? '',
                    $b->start,
                    $b->end,
                    $b->days,
                    $b->rate,
                    $b->total,
                    $paid,
                    $remain,
                    $status,
                ], ';');
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Clear all database entries (admin only)
     */
    public function clearAll()
    {
        if (Auth::user()?->role !== 'admin') {
            return response()->json(['message' => 'Hanya admin yang dapat menghapus seluruh data.'], 403);
        }

        DB::transaction(function () {
            Schema::disableForeignKeyConstraints();
            DriverPayment::truncate();
            OtherCharge::truncate();
            PartnerPayment::truncate();
            Journal::truncate();
            Expense::truncate();
            Payment::truncate();
            Booking::truncate();
            Driver::truncate();
            Car::truncate();
            Partner::truncate();
            Customer::truncate();
            Schema::enableForeignKeyConstraints();
        });

        return response()->json(['success' => true]);
    }

    /**
     * Get signature verification URL and metadata.
     */
    public function getSignatureUrl()
    {
        $defaultUrl = env('ALFA_PRIMA_PUBLIC_SIGNATURE_URL', 'https://script.google.com/macros/s/AKfycbwCUeqKQNhM_JrFvXKHilzIx9K7lSuY0fPyOuAIzfbr3W4MvYukFQWmRTIapE0ab9xYZA/exec');
        $url = Schema::hasTable('settings') ? Setting::get('public_signature_url', $defaultUrl) : $defaultUrl;
        $name = Schema::hasTable('settings') ? Setting::get('signature_name', 'Alfa Prima') : 'Alfa Prima';
        $title = Schema::hasTable('settings') ? Setting::get('signature_title', 'Pemilik') : 'Pemilik';
        $image = Schema::hasTable('settings') ? Setting::get('signature_image', '/images/signature.png') : '/images/signature.png';

        return response()->json([
            'success' => true,
            'url' => $url,
            'signature_name' => $name,
            'signature_title' => $title,
            'signature_image' => $image,
        ]);
    }

    /**
     * Update application settings (Admin only).
     */
    public function saveSettings(Request $request)
    {
        if (Auth::user()?->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Hanya admin yang dapat mengubah pengaturan.'], 403);
        }

        $request->validate([
            'public_signature_url' => 'nullable|string|max:1000',
            'signature_name' => 'nullable|string|max:255',
            'signature_title' => 'nullable|string|max:255',
            'signature_image' => 'nullable|string',
        ]);

        if (Schema::hasTable('settings')) {
            if ($request->has('public_signature_url')) {
                Setting::set('public_signature_url', $request->input('public_signature_url'));
            }
            if ($request->has('signature_name')) {
                Setting::set('signature_name', $request->input('signature_name'));
            }
            if ($request->has('signature_title')) {
                Setting::set('signature_title', $request->input('signature_title'));
            }
            if ($request->has('signature_image')) {
                Setting::set('signature_image', $request->input('signature_image'));
            }
        }

        $all = Schema::hasTable('settings') ? Setting::pluck('value', 'key')->toArray() : [];

        return response()->json([
            'success' => true,
            'message' => 'Pengaturan tanda tangan berhasil disimpan.',
            'settings' => $all,
        ]);
    }

    /**
     * Upload custom signature image (Admin only).
     */
    public function uploadSignature(Request $request)
    {
        if (Auth::user()?->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Hanya admin yang dapat mengunggah tanda tangan.'], 403);
        }

        $request->validate([
            'signature_file' => 'required|file|mimes:png,jpg,jpeg,webp,svg|max:5120',
        ]);

        $file = $request->file('signature_file');
        $fileName = 'signature_' . time() . '.' . $file->getClientOriginalExtension();
        $targetDir = public_path('images');
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }
        $file->move($targetDir, $fileName);
        $filePath = '/images/' . $fileName;

        if (Schema::hasTable('settings')) {
            Setting::set('signature_image', $filePath);
        }

        return response()->json([
            'success' => true,
            'message' => 'File gambar tanda tangan berhasil diunggah.',
            'path' => $filePath,
        ]);
    }
}

