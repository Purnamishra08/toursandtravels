<?php
use App\Http\Controllers\Admin\ManageUser\LoginController;
use App\Http\Controllers\Admin\ManageUser\ManageUserController;
use App\Http\Controllers\Admin\manageVehicles\VehicleTypeController;
use App\Http\Controllers\Admin\manageVehicles\VehiclePriceController;
use App\Http\Controllers\Admin\manageHotels\HotelTypeController;
use App\Http\Controllers\Admin\manageHotels\SeasonTypeController;
use App\Http\Controllers\Admin\manageHotels\HotelController;
use App\Http\Controllers\Admin\manageLocation\StateController;
use App\Http\Controllers\Admin\manageLocation\DestinationTypeController;
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

//php artisan optimize
Route::get('/optimize', function() {
    $output = [];
 
    // Clear cache
    Artisan::call('cache:clear');
    $output['cache'] = trim(Artisan::output());
 
    // Clear config
    Artisan::call('config:clear');
    $output['config'] = trim(Artisan::output());
 
    // Clear views
    Artisan::call('view:clear');
    $output['view'] = trim(Artisan::output());
 
    // Clear routes
    Artisan::call('route:clear');
    $output['route'] = trim(Artisan::output());
 
    return response()->json([
        'status' => 'success',
        'results' => $output
    ]);
});

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

// Manage User
Route::get('/manageUser', [ManageUserController::class, 'index'])->name('admin.manageUser');
Route::match(['get', 'post'], '/addUser', [ManageUserController::class, 'addUser'])->name('admin.manageUser.addUser');
Route::match(['get', 'post'], '/editUser/{id}', [ManageUserController::class, 'editUser'])->name('admin.manageUser.editUser');
Route::post('/manageUser/viewpop', [ManageUserController::class, 'viewPop'])
    ->name('admin.manageUser.viewPop');


Route::post('/deleteUser/{id}', [ManageUserController::class, 'deleteUser'])->name('admin.manageUser.deleteUser');
// Manage User


// Manage Vehicles
// Vehicle Type
Route::get('/vehicle-type', [VehicleTypeController::class, 'index'])->name('admin.manageVehicletype');
Route::match(['get', 'post'], '/addVehicleType', [VehicleTypeController::class, 'addVehicleType'])->name('admin.manageVehicletype.addVehicleType');
Route::match(['get', 'post'], '/editVehicleType/{id}', [VehicleTypeController::class, 'editVehicleType'])->name('admin.manageVehicletype.editVehicleType');
Route::post('/deleteVehicleType/{id}', [VehicleTypeController::class, 'deleteVehicleType'])->name('admin.manageVehicletype.deleteVehicleType');

// Vehicle Price
Route::get('/vehicle-price', [VehiclePriceController::class, 'index'])->name('admin.manageVehicleprice');
Route::match(['get', 'post'], '/addVehiclePrice', [VehiclePriceController::class, 'addVehiclePrice'])->name('admin.manageVehicleprice.addVehiclePrice');
Route::match(['get', 'post'], '/editVehiclePrice/{id}', [VehiclePriceController::class, 'editVehiclePrice'])->name('admin.manageVehicleprice.editVehiclePrice');
Route::post('/deleteVehiclePrice/{id}', [VehiclePriceController::class, 'deleteVehiclePrice'])->name('admin.manageVehicleprice.deleteVehiclePrice');

// Manage Vehicles

// Manage Hotels
// Hotel Type
Route::get('/hotel-type', [HotelTypeController::class, 'index'])->name('admin.manageHoteltype');
Route::match(['get', 'post'], '/addHotelType', [HotelTypeController::class, 'addHotelType'])->name('admin.manageHoteltype.addHotelType');
Route::match(['get', 'post'], '/editHotelType/{id}', [HotelTypeController::class, 'editHotelType'])->name('admin.manageHoteltype.editHotelType');
Route::post('/deleteHotelType/{id}', [HotelTypeController::class, 'deleteHotelType'])->name('admin.manageHoteltype.deleteHotelType');

// Season Type

//Hotel

// Manage Hotels


//Manage location
//state
Route::get('/state', [StateController::class, 'index'])->name('admin.state');
Route::match(['get', 'post'], '/addState', [StateController::class, 'addState'])->name('admin.state.addState');
Route::match(['get', 'post'], '/editState/{id}', [StateController::class, 'editState'])->name('admin.state.editState');
Route::post('/deleteState/{id}', [StateController::class, 'deleteState'])->name('admin.state.deleteState');
//Destination type
Route::get('/destination_type', [DestinationTypeController::class, 'index'])->name('admin.destinationtype');
Route::match(['get', 'post'], '/adddestination_type', [DestinationTypeController::class, 'adddestination_type'])->name('admin.destinationtype.adddestinationtype');
Route::match(['get', 'post'], '/editdestination_type/{id}', [DestinationTypeController::class, 'editdestination_type'])->name('admin.destinationtype.editdestinationtype');
Route::post('/deletedestination_type/{id}', [DestinationTypeController::class, 'deletedestination_type'])->name('admin.destinationtype.deletedestinationtype');
//Manage location