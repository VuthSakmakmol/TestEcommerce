<?php

use App\Models\User;
use Inertia\Inertia;
use App\Http\Controllers\Debugging;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within the "web" middleware
| group. Now create something great!
|
*/

// Public Route
// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin'       => Route::has('login'),
//         'canRegister'    => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion'     => PHP_VERSION,
//     ]);
// });


Route::get('/', function () {
    return view('home'); // Default view for guests
})->middleware('App\Http\Middleware\RedirectIfAuthenticatedWithRole')->name('home');


// Admin Dashboard Route
Route::middleware(['auth', 'role:admin'])->get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// User Dashboard Route
Route::middleware(['auth', 'role:user'])->get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');


// Authentication Routes
require __DIR__ . '/auth.php';

// // Dashboard Route (Authenticated Users)
// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::get('/dashboard', function () {
//         return Inertia::render('Dashboard');
//     })->name('dashboard');
// });

// Profile Routes (Authenticated Users)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes (Authenticated and Role-Based)
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Admin Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Manage Users
    Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.users');
    Route::post('/admin/users/{user}/assign-role', [AdminController::class, 'assignRole'])->name('admin.assignRole');

    // Admin Profile Management
    Route::get('/admin/users/{user}/edit', [ProfileController::class, 'adminEdit'])->name('admin.profile.edit');
    Route::patch('/admin/users/{user}', [ProfileController::class, 'adminUpdate'])->name('admin.profile.update');
});

// User Routes (Authenticated and Role-Based)
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
});

// Debug Routes (Development Only)
if (app()->environment('local')) {
    Route::get('/debug-roles', [Debugging::class, 'debugRoles'])->name('debug.roles');
    Route::get('/assign-role', function () {
        $user = User::find(1); // Replace with your user ID
        $user->assignRole('admin'); // Replace 'admin' with the role you want to assign
        return 'Role assigned successfully!';
    })->name('debug.assign-role');
}
