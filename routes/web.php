<?php
use App\Http\Controllers\Admin\ManageUser\LoginController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/admin', [LoginController::class, 'index'])->name('admin.login');
Route::post('/admin', [LoginController::class, 'login'])->name('admin.processLogin');
Route::get('/forgot-password', [LoginController::class, 'forgotPassword'])->name('admin.forgot-password');

Route::middleware('auth')->group(function () {
    Route::match(['get', 'post'], '/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::match(['get', 'post'], '/logout', [LoginController::class, 'logout'])->name('admin.logout');
});

