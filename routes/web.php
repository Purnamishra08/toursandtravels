<?php
use App\Http\Controllers\Admin\ManageUser\LoginController;
use App\Http\Controllers\Admin\ManageUser\ManageUserController;
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
Route::get('/admin/login', [LoginController::class, 'index'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login'])->name('admin.processLogin');
Route::get('/admin/forgot-password', [LoginController::class, 'forgotPassword'])->name('admin.forgot-password');
Route::get('/admin/change-password', [LoginController::class, 'changePassword'])->name('admin.change-password');

Route::middleware('auth')->group(function () {
    Route::match(['get', 'post'], '/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::match(['get', 'post'], '/logout', [LoginController::class, 'logout'])->name('admin.logout');
});

Route::get('/manageUser', [ManageUserController::class, 'index'])->name('admin.manageUser');
Route::match(['get', 'post'], '/addUser', [ManageUserController::class, 'addUser'])->name('admin.manageUser.addUser');
Route::match(['get', 'post'], '/editUser/{id}', [ManageUserController::class, 'editUser'])->name('admin.manageUser.editUser');
Route::get('viewpop/{id}', [ManageUserController::class, 'viewPop'])->name('admin.viewpop');

