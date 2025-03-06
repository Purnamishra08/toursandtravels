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
use App\Http\Controllers\Admin\manageLocation\DestinationController;
use App\Http\Controllers\Admin\manageMenus\CategoryController;
use App\Http\Controllers\Admin\manageMenus\CategoryTagsController;
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
Route::post('/manageUser/viewpop', [ManageUserController::class, 'viewPop'])->name('admin.manageUser.viewPop');
Route::post('/activeUser/{id}', [ManageUserController::class, 'activeUser'])->name('admin.manageUser.activeUser');
Route::post('/deleteUser/{id}', [ManageUserController::class, 'deleteUser'])->name('admin.manageUser.deleteUser');
// Manage User


// Manage Vehicles
// Vehicle Type
Route::get('/vehicle-type', [VehicleTypeController::class, 'index'])->name('admin.manageVehicletype');
Route::match(['get', 'post'], '/addVehicleType', [VehicleTypeController::class, 'addVehicleType'])->name('admin.manageVehicletype.addVehicleType');
Route::match(['get', 'post'], '/editVehicleType/{id}', [VehicleTypeController::class, 'editVehicleType'])->name('admin.manageVehicletype.editVehicleType');
Route::post('/deleteVehicleType/{id}', [VehicleTypeController::class, 'deleteVehicleType'])->name('admin.manageVehicletype.deleteVehicleType');
Route::post('/activeVehicleType/{id}', [VehicleTypeController::class, 'activeVehicleType'])->name('admin.manageVehicletype.activeVehicleType');

// Vehicle Price
Route::get('/vehicle-price', [VehiclePriceController::class, 'index'])->name('admin.manageVehicleprice');
Route::match(['get', 'post'], '/addVehiclePrice', [VehiclePriceController::class, 'addVehiclePrice'])->name('admin.manageVehicleprice.addVehiclePrice');
Route::match(['get', 'post'], '/editVehiclePrice/{id}', [VehiclePriceController::class, 'editVehiclePrice'])->name('admin.manageVehicleprice.editVehiclePrice');
Route::post('/deleteVehiclePrice/{id}', [VehiclePriceController::class, 'deleteVehiclePrice'])->name('admin.manageVehicleprice.deleteVehiclePrice');
Route::post('/activeVehiclePrice/{id}', [VehiclePriceController::class, 'activeVehiclePrice'])->name('admin.manageVehicleprice.activeVehiclePrice');

// Manage Vehicles

// Manage Hotels
// Hotel Type
Route::get('/hotel-type', [HotelTypeController::class, 'index'])->name('admin.manageHoteltype');
Route::match(['get', 'post'], '/addHotelType', [HotelTypeController::class, 'addHotelType'])->name('admin.manageHoteltype.addHotelType');
Route::match(['get', 'post'], '/editHotelType/{id}', [HotelTypeController::class, 'editHotelType'])->name('admin.manageHoteltype.editHotelType');
Route::post('/deleteHotelType/{id}', [HotelTypeController::class, 'deleteHotelType'])->name('admin.manageHoteltype.deleteHotelType');
Route::post('/activeHotelType/{id}', [HotelTypeController::class, 'activeHotelType'])->name('admin.manageHoteltype.activeHotelType');

// Season Type
Route::get('/season-type', [SeasonTypeController::class, 'index'])->name('admin.manageSeasontype');
Route::match(['get', 'post'], '/addSeasonType', [SeasonTypeController::class, 'addSeasonType'])->name('admin.manageSeasontype.addSeasonType');
Route::match(['get', 'post'], '/editSeasonType/{id}', [SeasonTypeController::class, 'editSeasonType'])->name('admin.manageSeasontype.editSeasonType');
Route::post('/deleteSeasonType/{id}', [SeasonTypeController::class, 'deleteSeasonType'])->name('admin.manageSeasontype.deleteSeasonType');
Route::post('/activeSeasonType/{id}', [SeasonTypeController::class, 'activeSeasonType'])->name('admin.manageSeasontype.activeSeasonType');

// Hotel
Route::get('/hotel', [HotelController::class, 'index'])->name('admin.manageHotel');
Route::match(['get', 'post'], '/addHotel', [HotelController::class, 'addHotel'])->name('admin.manageHotel.addHotel');
Route::match(['get', 'post'], '/editHotel/{id}', [HotelController::class, 'editHotel'])->name('admin.manageHotel.editHotel');
Route::post('/deleteHotel/{id}', [HotelController::class, 'deleteHotel'])->name('admin.manageHotel.deleteHotel');
Route::post('/activeHotel/{id}', [HotelController::class, 'activeHotel'])->name('admin.manageHotel.activeHotel');

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
Route::post('/activeDestinationType/{id}', [DestinationTypeController::class, 'activeDestinationType'])->name('admin.destinationtype.activeDestinationType');
//Destination
Route::get('/destination', [DestinationController::class, 'index'])->name('admin.destination');
Route::match(['get', 'post'], '/adddestination', [DestinationController::class, 'adddestination'])->name('admin.destination.adddestination');

//Manage location

//Manage Menus
//Manage category
Route::get('/category', [CategoryController::class, 'index'])->name('admin.category');
Route::match(['get', 'post'], '/addcategory', [CategoryController::class, 'addcategory'])->name('admin.category.addcategory');
Route::match(['get', 'post'], '/editcategory/{id}', [CategoryController::class, 'editcategory'])->name('admin.category.editcategory');
Route::post('/deletecategory/{id}', [CategoryController::class, 'deletecategory'])->name('admin.category.deletecategory');
Route::post('/activecategory/{id}', [CategoryController::class, 'activecategory'])->name('admin.category.activecategory');
//Manage category tags
Route::get('/categorytags', [CategoryTagsController::class, 'index'])->name('admin.categorytags');
Route::match(['get', 'post'], '/addcategorytags', [CategoryTagsController::class, 'addcategorytags'])->name('admin.categorytags.addcategorytags');
Route::match(['get', 'post'], '/editcategorytags/{id}', [CategoryTagsController::class, 'editcategorytags'])->name('admin.categorytags.editcategorytags');
Route::post('/deletecategorytags/{id}', [CategoryTagsController::class, 'deletecategorytags'])->name('admin.categorytags.deletecategorytags');
Route::post('/activecategorytags/{id}', [CategoryTagsController::class, 'activecategorytags'])->name('admin.categorytags.activecategorytags');
Route::post('/categorytags/getCategoryMenuWise', [CategoryTagsController::class, 'getCategoryMenuWise'])->name('admin.categorytags.getCategoryMenuWise');
//Manage Menus