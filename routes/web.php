<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Redirect root to onboarding/register if not logged in
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('register');
});

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/verify', [AuthController::class, 'showVerify'])->name('verify.show');
Route::post('/verify', [AuthController::class, 'verify'])->name('verify.submit');
Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('otp.resend');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/contracts', [ContractController::class, 'index'])->name('contracts.index');
    Route::get('/contracts/{contract}', [ContractController::class, 'show'])->name('contracts.show');
    Route::post('/contracts/{contract}/purchase', [ContractController::class, 'purchase'])->name('contracts.purchase');

    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
    Route::post('/wallet/deposit', [WalletController::class, 'deposit'])->name('wallet.deposit');
    Route::post('/wallet/withdraw', [WalletController::class, 'withdraw'])->name('wallet.withdraw');

    Route::get('/team', [TeamController::class, 'index'])->name('team.index');

    Route::get('/profile', function() {
        return view('profile.index', ['user' => auth()->user()]);
    })->name('profile.index');
});

use App\Http\Controllers\ContractController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ContractController as AdminContractController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');

    Route::get('/contracts', [AdminContractController::class, 'index'])->name('contracts.index');
    Route::get('/contracts/create', [AdminContractController::class, 'create'])->name('contracts.create');
    Route::post('/contracts', [AdminContractController::class, 'store'])->name('contracts.store');
    Route::get('/contracts/{contract}/edit', [AdminContractController::class, 'edit'])->name('contracts.edit');
    Route::put('/contracts/{contract}', [AdminContractController::class, 'update'])->name('contracts.update');

    Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions/{transaction}/approve', [AdminTransactionController::class, 'approve'])->name('transactions.approve');
    Route::post('/transactions/{transaction}/reject', [AdminTransactionController::class, 'reject'])->name('transactions.reject');

    Route::get('/broadcast', [AdminController::class, 'showBroadcast'])->name('broadcast.show');
    Route::post('/broadcast', [AdminController::class, 'sendBroadcast'])->name('broadcast.send');

    Route::get('/settings', [AdminController::class, 'settings'])->name('settings.show');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
});
