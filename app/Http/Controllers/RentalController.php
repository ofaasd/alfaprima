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
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
                'partner_id' => $request->partner_id ?: null,
                'partner_rate' => (float) ($request->partner_rate ?: 0),
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
            Journal::truncate();
            PartnerPayment::truncate();
            Expense::truncate();
            Payment::truncate();
            Booking::truncate();
            Driver::truncate();
            Car::truncate();
            Partner::truncate();
            Customer::truncate();

            if (!empty($data['customers'])) Customer::insert($data['customers']);
            if (!empty($data['partners'])) Partner::insert($data['partners']);
            if (!empty($data['cars'])) Car::insert($data['cars']);
            if (!empty($data['drivers'])) Driver::insert($data['drivers']);
            if (!empty($data['bookings'])) Booking::insert($data['bookings']);
            if (!empty($data['payments'])) Payment::insert($data['payments']);
            if (!empty($data['expenses'])) Expense::insert($data['expenses']);
            if (!empty($data['partnerPayments'])) PartnerPayment::insert($data['partnerPayments']);
            if (!empty($data['journals'])) Journal::insert($data['journals']);
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
            Journal::truncate();
            PartnerPayment::truncate();
            Expense::truncate();
            Payment::truncate();
            Booking::truncate();
            Driver::truncate();
            Car::truncate();
            Partner::truncate();
            Customer::truncate();
        });

        return response()->json(['success' => true]);
    }
}

