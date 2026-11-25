<?php

use App\Http\Controllers\RentalController;
use App\Http\Controllers\DeployController;
use Illuminate\Support\Facades\Route;

// Main App View
Route::get('/', [RentalController::class, 'index'])->name('home');

// Data Loading & Session
Route::get('/api/load-data', [RentalController::class, 'loadData']);
Route::post('/api/login', [RentalController::class, 'login']);
Route::post('/api/logout', [RentalController::class, 'logout']);

// User Management (Admin)
Route::get('/api/users', [RentalController::class, 'listUsers']);
Route::post('/api/users', [RentalController::class, 'createUser']);
Route::put('/api/users/{id}', [RentalController::class, 'updateUser']);
Route::post('/api/users/{id}/toggle', [RentalController::class, 'toggleUser']);
Route::delete('/api/users/{id}', [RentalController::class, 'deleteUser']);

// Master Data CRUD
Route::post('/api/customers', [RentalController::class, 'saveCustomer']);
Route::delete('/api/customers/{id}', [RentalController::class, 'deleteCustomer']);

Route::post('/api/cars', [RentalController::class, 'saveCar']);
Route::delete('/api/cars/{id}', [RentalController::class, 'deleteCar']);

Route::post('/api/drivers', [RentalController::class, 'saveDriver']);
Route::delete('/api/drivers/{id}', [RentalController::class, 'deleteDriver']);

Route::post('/api/partners', [RentalController::class, 'savePartner']);

// Transaction CRUD
Route::post('/api/bookings', [RentalController::class, 'saveBooking']);
Route::delete('/api/bookings/{id}', [RentalController::class, 'deleteBooking']);

Route::post('/api/payments', [RentalController::class, 'savePayment']);
Route::put('/api/payments/{id}', [RentalController::class, 'updatePayment']);
Route::delete('/api/payments/{id}', [RentalController::class, 'deletePayment']);

Route::post('/api/expenses', [RentalController::class, 'saveExpense']);
Route::delete('/api/expenses/{id}', [RentalController::class, 'deleteExpense']);

Route::post('/api/partner-payments', [RentalController::class, 'savePartnerPayment']);
Route::post('/api/driver-payments', [RentalController::class, 'saveDriverPayment']);
Route::post('/api/other-charges', [RentalController::class, 'saveOtherCharge']);
Route::post('/api/accounts', [RentalController::class, 'saveAccount']);
Route::post('/api/journals', [RentalController::class, 'saveJournal']);
Route::post('/api/save-all', [RentalController::class, 'saveAll']);

// Settings & Signature
Route::get('/api/signature-url', [RentalController::class, 'getSignatureUrl']);
Route::post('/api/settings', [RentalController::class, 'saveSettings']);
Route::post('/api/upload-signature', [RentalController::class, 'uploadSignature']);

// Utilities: Backup, Restore, Export, Clear All
Route::get('/api/backup', [RentalController::class, 'backupJson']);
Route::post('/api/restore', [RentalController::class, 'restoreJson']);
Route::get('/api/export-csv', [RentalController::class, 'exportCsv']);
Route::post('/api/clear-all', [RentalController::class, 'clearAll']);

// cPanel Deployment & Database Maintenance (No Terminal Needed)
Route::get('/deploy', [DeployController::class, 'index'])->name('deploy.index');
Route::get('/deploy/{action}', [DeployController::class, 'runCommand'])->name('deploy.run');
