<?php
use Illuminate\Support\Facades\Route;
/********  ADMIN ROUTING    ********/
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
use App\Http\Controllers\Admin\manageLocation\PlacesController;
use App\Http\Controllers\Admin\manageMenus\MenutagController;
use App\Http\Controllers\Admin\manageMenus\CategoryController;
use App\Http\Controllers\Admin\manageMenus\CategoryTagsController;
use App\Http\Controllers\Admin\ManagePackages\PackageDurationsController;
use App\Http\Controllers\Admin\ManagePackages\TourPackagesController;
use App\Http\Controllers\Admin\ManageGeneralSettings\GeneralSettingsController;
use App\Http\Controllers\Admin\ManageEnquiries\EnquiryController;
use App\Http\Controllers\Admin\ManageReviews\ReviewsController;
use App\Http\Controllers\Admin\ManageEnquiries\ItineraryEnquiryController;
use App\Http\Controllers\Admin\ManageEnquiries\PackageEnquiryController;
use App\Http\Controllers\Admin\ManageFaqs\CommonFaqController;
use App\Http\Controllers\Admin\ManageFaqs\PackageFaqController;
use App\Http\Controllers\Admin\ManageCms\ManageCmsController;
use App\Http\Controllers\Admin\ManageFooter\FooterLinksController;
use App\Http\Controllers\Admin\ManageFollowUpEnquiries\SourcesController;
use App\Http\Controllers\Admin\ManageFollowUpEnquiries\StatusListController;
use App\Http\Controllers\Admin\ManageFollowUpEnquiries\EnquiriesEntryController;
use App\Http\Controllers\Admin\ManageFollowUpEnquiries\EnquiriesReportController;
use App\Http\Controllers\Admin\ManageBlogs\ManageBlogsController;
use App\Http\Controllers\Admin\ManageBlogs\ManageBlogsCommentsController;
use App\Http\Controllers\Admin\ManagePackages\PackagePdfController;
/********  ADMIN ROUTING    ********/

/********  WEBSITE ROUTING    ********/
use App\Http\Controllers\Website\Blogs\BlogsController;
use App\Http\Controllers\Website\Home\HomeController;
use App\Http\Controllers\Website\Contact\ContactController;
use App\Http\Controllers\Website\Footer\FooterController;

/********  WEBSITE ROUTING    ********/
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


/********  WEBSITE ROUTING    ********/
Route::get('/', [HomeController::class, 'index'])->name('website.home');
Route::view('/contactus', 'website.contactus');
Route::view('/aboutus', 'website.aboutus');
Route::view('/faq', 'website.faq');
Route::view('/tourlisting', 'website.tourlisting');
Route::view('/tourdetails', 'website.tourdetails');
Route::get('/bloglisting', [BlogsController::class, 'index'])->name('website.bloglisting');
Route::get('blogdetails/{slug}', [BlogsController::class, 'blogdetails'])->name('website.blogdetails');


//Footer
Route::match(['get', 'post'], '/footer', [FooterController::class, 'index'])->name('website.footer');
//Footer
/********  WEBSITE ROUTING    ********/


/********  ADMIN ROUTING    ********/
Route::get('/admin', [LoginController::class, 'index'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login'])->name('admin.processLogin');
Route::get('/admin/forgot-password', [LoginController::class, 'forgotPassword'])->name('admin.forgot-password');
Route::get('/admin/change-password', [LoginController::class, 'changePassword'])->name('admin.change-password');
Route::match(['get', 'post'], '/logout', [LoginController::class, 'logout'])->name('admin.logout');
Route::middleware('auth')->group(function () {
    Route::match(['get', 'post'], '/dashboard', function () {return view('admin.dashboard');})->name('admin.dashboard');
    // Manage User
    Route::get('/manageUser', [ManageUserController::class, 'index'])->name('admin.manageUser');
    Route::get('/manageUser/data', [ManageUserController::class, 'getData'])->name('admin.manageUser.data');
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
    Route::match(['get', 'post'], '/hotel', [HotelController::class, 'index'])->name('admin.manageHotels');
    Route::match(['get', 'post'], '/addHotel', [HotelController::class, 'addHotel'])->name('admin.manageHotels.addHotel');
    Route::match(['get', 'post'], '/editHotel/{id}', [HotelController::class, 'editHotel'])->name('admin.manageHotels.editHotel');
    Route::match(['get', 'post'], '/viewHotel/{id}', [HotelController::class, 'viewHotel'])->name('admin.manageHotels.viewHotel');
    Route::post('/deleteHotel/{id}', [HotelController::class, 'deleteHotel'])->name('admin.manageHotels.deleteHotel');
    Route::post('/activeHotel/{id}', [HotelController::class, 'activeHotel'])->name('admin.manageHotels.activeHotel');

    // Manage Hotels


    //Manage location
    //state
    Route::get('/state', [StateController::class, 'index'])->name('admin.state');
    Route::match(['get', 'post'], '/addState', [StateController::class, 'addState'])->name('admin.state.addState');
    Route::match(['get', 'post'], '/editState/{id}', [StateController::class, 'editState'])->name('admin.state.editState');
    Route::post('/deleteState/{id}', [StateController::class, 'deleteState'])->name('admin.state.deleteState');
    //Destination type
    Route::get('/destination_type', [DestinationTypeController::class, 'index'])->name('admin.destinationtype');
    Route::get('/destination_type/data', [DestinationTypeController::class, 'getData'])->name('admin.destination_type.data');
    Route::match(['get', 'post'], '/adddestination_type', [DestinationTypeController::class, 'adddestination_type'])->name('admin.destinationtype.adddestinationtype');
    Route::match(['get', 'post'], '/editdestination_type/{id}', [DestinationTypeController::class, 'editdestination_type'])->name('admin.destinationtype.editdestinationtype');
    Route::post('/deletedestination_type/{id}', [DestinationTypeController::class, 'deletedestination_type'])->name('admin.destinationtype.deletedestinationtype');
    Route::post('/activeDestinationType/{id}', [DestinationTypeController::class, 'activeDestinationType'])->name('admin.destinationtype.activeDestinationType');
    //Destination
    Route::match(['get', 'post'], '/destination', [DestinationController::class, 'index'])->name('admin.destination');
    Route::get('/destination/data', [DestinationController::class, 'getData'])->name('admin.destination.data');
    Route::match(['get', 'post'], '/adddestination', [DestinationController::class, 'adddestination'])->name('admin.destination.adddestination');
    Route::match(['get', 'post'], '/editdestination/{id}', [DestinationController::class, 'editdestination'])->name('admin.destination.editdestination');
    Route::post('/deletedestination/{id}', [DestinationController::class, 'deletedestination'])->name('admin.destination.deletedestination');
    Route::post('/activeDestination/{id}', [DestinationController::class, 'activeDestination'])->name('admin.destination.activeDestination');
    Route::get('/destination/pickupdestinationdata', [DestinationController::class, 'pickupdestinationdata'])->name('admin.destination.pickupdestinationdata');
    Route::match(['get', 'post'], '/addpickupdestination', [DestinationController::class, 'addpickupdestination'])->name('admin.destination.addpickupdestination');
    Route::get('/editpickupdestination/edit/{id}', [DestinationController::class, 'editpickupdestination'])->name('admin.destination.editpickupdestination');
    Route::post('/updatepickupdestination/update', [DestinationController::class, 'updatepickupdestination'])->name('admin.destination.updatepickupdestination');
    
    //Places
    Route::get('/places', [PlacesController::class, 'index'])->name('admin.places');
    Route::get('/places/data', [PlacesController::class, 'getData'])->name('admin.places.data');
    Route::match(['get', 'post'], '/addplaces', [PlacesController::class, 'addplaces'])->name('admin.places.addplaces');
    Route::match(['get', 'post'], '/editplaces/{id}', [PlacesController::class, 'editplaces'])->name('admin.places.editplaces');
    Route::post('/deleteplaces/{id}', [PlacesController::class, 'deleteplaces'])->name('admin.places.deleteplaces');
    Route::post('/activeplaces/{id}', [PlacesController::class, 'activeplaces'])->name('admin.places.activeplaces');
    
    //Manage location

    //Manage Menus
    //manage menu tag
    Route::get('/menutag', [MenutagController::class, 'index'])->name('admin.menutag');
    Route::get('/menutag/data', [MenutagController::class, 'getData'])->name('admin.menutag.data');
    Route::match(['get', 'post'], '/addmenutag', [MenutagController::class, 'addmenutag'])->name('admin.category.addmenutag');
    Route::match(['get', 'post'], '/editmenutag/{id}', [MenutagController::class, 'editmenutag'])->name('admin.category.editmenutag');
    Route::post('/deletemenutag/{id}', [MenutagController::class, 'deletemenutag'])->name('admin.category.deletemenutag');
    Route::post('/activemenutag/{id}', [MenutagController::class, 'activemenutag'])->name('admin.category.activemenutag');
    //Manage category
    Route::get('/category', [CategoryController::class, 'index'])->name('admin.category');
    Route::get('/category/data', [CategoryController::class, 'getData'])->name('admin.category.data');
    Route::match(['get', 'post'], '/addcategory', [CategoryController::class, 'addcategory'])->name('admin.category.addcategory');
    Route::match(['get', 'post'], '/editcategory/{id}', [CategoryController::class, 'editcategory'])->name('admin.category.editcategory');
    Route::post('/deletecategory/{id}', [CategoryController::class, 'deletecategory'])->name('admin.category.deletecategory');
    Route::post('/activecategory/{id}', [CategoryController::class, 'activecategory'])->name('admin.category.activecategory');
    //Manage category tags
    Route::get('/categorytags', [CategoryTagsController::class, 'index'])->name('admin.categorytags');
    Route::get('/categorytags/data', [CategoryTagsController::class, 'getData'])->name('admin.categorytags.data');
    Route::match(['get', 'post'], '/addcategorytags', [CategoryTagsController::class, 'addcategorytags'])->name('admin.categorytags.addcategorytags');
    Route::match(['get', 'post'], '/editcategorytags/{id}', [CategoryTagsController::class, 'editcategorytags'])->name('admin.categorytags.editcategorytags');
    Route::post('/deletecategorytags/{id}', [CategoryTagsController::class, 'deletecategorytags'])->name('admin.categorytags.deletecategorytags');
    Route::post('/activecategorytags/{id}', [CategoryTagsController::class, 'activecategorytags'])->name('admin.categorytags.activecategorytags');
    Route::post('/categorytags/getCategoryMenuWise', [CategoryTagsController::class, 'getCategoryMenuWise'])->name('admin.categorytags.getCategoryMenuWise');
    //Manage Menus

    // Manage Packages 

    // Package Duration
    Route::match(['get', 'post'], '/package-durations', [PackageDurationsController::class, 'index'])->name('admin.managepackagedurations');
    Route::match(['get', 'post'], '/addPackageDurations', [PackageDurationsController::class, 'addPackageDurations'])->name('admin.managepackagedurations.addPackageDurations');
    Route::match(['get', 'post'], '/editPackageDurations/{id}', [PackageDurationsController::class, 'editPackageDurations'])->name('admin.managepackagedurations.editPackageDurations');
    Route::post('/deletePackageDurations/{id}', [PackageDurationsController::class, 'deletePackageDurations'])->name('admin.managepackagedurations.deletePackageDurations');
    Route::post('/activePackageDurations/{id}', [PackageDurationsController::class, 'activePackageDurations'])->name('admin.managepackagedurations.activePackageDurations');
    // Package Duration

    // Tour Package
    Route::match(['get', 'post'], '/tour-packages', [TourPackagesController::class, 'index'])->name('admin.managetourpackages');
    Route::match(['get', 'post'], '/addTourPackages', [TourPackagesController::class, 'addTourPackages'])->name('admin.managetourpackages.addTourPackages');
    Route::match(['get', 'post'], '/editTourPackages/{id}', [TourPackagesController::class, 'editTourPackages'])->name('admin.managetourpackages.editTourPackages');
    Route::post('/deleteTourPackages/{id}', [TourPackagesController::class, 'deleteTourPackages'])->name('admin.managetourpackages.deleteTourPackages');
    Route::post('/activeTourPackages/{id}', [TourPackagesController::class, 'activeTourPackages'])->name('admin.managetourpackages.activeTourPackages');
    Route::match(['get', 'post'], '/getItineraryAddmore', [TourPackagesController::class, 'getItineraryAddmore'])->name('admin.managetourpackages.getItineraryAddmore');
    Route::match(['get', 'post'], '/editItineraryAddmore', [TourPackagesController::class, 'editItineraryAddmore'])->name('admin.managetourpackages.editItineraryAddmore');
    Route::match(['get', 'post'], '/viewTourPackages/{id}', [TourPackagesController::class, 'viewTourPackages'])->name('admin.managetourpackages.viewTourPackages');
    // Tour Package

    // Manage Packages

    //General setiings
    Route::get('/generalsettings', [GeneralSettingsController::class, 'index'])->name('admin.generalsettings');
    Route::get('/generalsettings/data', [GeneralSettingsController::class, 'getData'])->name('admin.generalsettings.data');
    Route::match(['get', 'post'], '/editgeneralsettings/{id}', [GeneralSettingsController::class, 'editgeneralsettings'])->name('admin.managetourpackages.editgeneralsettings');
    
    //Manage Enquiries
    //Enquiry
    Route::match(['get', 'post'], '/enquiry', [EnquiryController::class, 'index'])->name('admin.manageenquiry');
    Route::match(['get', 'post'], '/viewEnquiry/{id}', [EnquiryController::class, 'viewEnquiry'])->name('admin.manageenquiry.viewEnquiry');
    Route::post('/deleteEnquiry/{id}', [EnquiryController::class, 'deleteEnquiry'])->name('admin.manageenquiry.deleteEnquiry');
    //Enquiry
    //Itinerary Enquiry
    Route::match(['get', 'post'], '/itinerary-enquiry', [ItineraryEnquiryController::class, 'index'])->name('admin.manageitineraryenquiry');
    Route::match(['get', 'post'], '/viewItineraryEnquiry/{id}', [ItineraryEnquiryController::class, 'viewItineraryEnquiry'])->name('admin.manageitineraryenquiry.viewItineraryEnquiry');
    Route::post('/deleteItineraryEnquiry/{id}', [ItineraryEnquiryController::class, 'deleteItineraryEnquiry'])->name('admin.manageitineraryenquiry.deleteItineraryEnquiry');
    //Itinerary Enquiry
    //Package Enquiry
    Route::match(['get', 'post'], '/package-enquiry', [PackageEnquiryController::class, 'index'])->name('admin.managepackageenquiry');
    Route::match(['get', 'post'], '/viewPackageEnquiry/{id}', [PackageEnquiryController::class, 'viewPackageEnquiry'])->name('admin.managepackageenquiry.viewPackageEnquiry');
    Route::post('/deletePackageEnquiry/{id}', [PackageEnquiryController::class, 'deletePackageEnquiry'])->name('admin.managepackageenquiry.deletePackageEnquiry');
    //Package Enquiry
    //Manage Enquiries

    //Manage Reviews
    Route::get('/managereviews', [ReviewsController::class, 'index'])->name('admin.managereviews');
    Route::get('/managereviews/data', [ReviewsController::class, 'getData'])->name('admin.managereviews.data');
    Route::match(['get', 'post'], '/addreviews', [ReviewsController::class, 'addreviews'])->name('admin.managereviews.addreviews');
    Route::match(['get', 'post'], '/editreviews/{id}', [ReviewsController::class, 'editreviews'])->name('admin.managereviews.editreviews');
    Route::post('/activereviews/{id}', [ReviewsController::class, 'activereviews'])->name('admin.managereviews.activereviews');
    Route::post('/deletereviews/{id}', [ReviewsController::class, 'deletereviews'])->name('admin.managereviews.deletereviews');
    Route::post('/managereviews/viewpop', [ReviewsController::class, 'viewPop'])->name('admin.managereviews.viewPop');
    //Manage Reviews

    //Manage Faqs

    //Common faqs
    Route::get('/commonfaqs', [CommonFaqController::class, 'index'])->name('admin.commonfaqs');
    Route::get('/commonfaqs/data', [CommonFaqController::class, 'getData'])->name('admin.commonfaqs.data');
    Route::match(['get', 'post'], '/addcommonfaqs', [CommonFaqController::class, 'addcommonfaqs'])->name('admin.commonfaqs.addcommonfaqs');
    Route::match(['get', 'post'], '/editcommonfaqs/{id}', [CommonFaqController::class, 'editcommonfaqs'])->name('admin.commonfaqs.editcommonfaqs');
    Route::post('/activecommonfaqs/{id}', [CommonFaqController::class, 'activecommonfaqs'])->name('admin.commonfaqs.activecommonfaqs');
    Route::post('/deletecommonfaqs/{id}', [CommonFaqController::class, 'deletecommonfaqs'])->name('admin.commonfaqs.deletecommonfaqs');
    //Common faqs
    
    //Package faqs
    Route::match(['get', 'post'], '/packagefaqs', [PackageFaqController::class, 'index'])->name('admin.packagefaqs');
    Route::get('/packagefaqs/data', [PackageFaqController::class, 'getData'])->name('admin.packagefaqs.data');
    Route::match(['get', 'post'], '/addpackagefaqs', [PackageFaqController::class, 'addpackagefaqs'])->name('admin.packagefaqs.addpackagefaqs');
    Route::match(['get', 'post'], '/editpackagefaqs/{id}', [PackageFaqController::class, 'editpackagefaqs'])->name('admin.packagefaqs.editpackagefaqs');
    Route::post('/activepackagefaqs/{id}', [PackageFaqController::class, 'activepackagefaqs'])->name('admin.packagefaqs.activepackagefaqs');
    Route::post('/deletepackagefaqs/{id}', [PackageFaqController::class, 'deletepackagefaqs'])->name('admin.packagefaqs.deletepackagefaqs');
    //Package faqs
    //Manage Faqs

    //Manage CMS
    Route::match(['get', 'post'], '/managecms/{id}', [ManageCmsController::class, 'index'])->name('admin.managecms');
    //Manage CMS

    //Manage Footer Links
    Route::match(['get', 'post'], '/footerlinks', [FooterLinksController::class, 'index'])->name('admin.footerlinks');
    Route::get('/footerlinks/data', [FooterLinksController::class, 'getData'])->name('admin.footerlinks.data');
    Route::match(['get', 'post'], '/addfooterlinks', [FooterLinksController::class, 'addfooterlinks'])->name('admin.footerlinks.addfooterlinks');
    Route::match(['get', 'post'], '/editfooterlinks/{id}', [FooterLinksController::class, 'editfooterlinks'])->name('admin.footerlinks.editfooterlinks');
    Route::post('/activefooterlinks/{id}', [FooterLinksController::class, 'activefooterlinks'])->name('admin.footerlinks.activefooterlinks');
    Route::post('/deletefooterlinks/{id}', [FooterLinksController::class, 'deletefooterlinks'])->name('admin.footerlinks.deletefooterlinks');
    //Manage Footer Links


    //Manage Follow Enquiries
    // Sources
    Route::match(['get', 'post'], '/sources', [SourcesController::class, 'index'])->name('admin.sources');
    Route::match(['get', 'post'], '/addSources', [SourcesController::class, 'addSources'])->name('admin.sources.addSources');
    Route::post('/deleteSources/{id}', [SourcesController::class, 'deleteSources'])->name('admin.sources.deleteSources');
    Route::post('/activeSources/{id}', [SourcesController::class, 'activeSources'])->name('admin.sources.activeSources');
    Route::get('/sources/edit/{id}', [SourcesController::class, 'editSources'])->name('admin.sources.editSources');
    Route::post('/sources/update', [SourcesController::class, 'updateSources'])->name('admin.sources.updateSources');
    // Sources

    // Sources
    Route::match(['get', 'post'], '/sources', [SourcesController::class, 'index'])->name('admin.sources');
    Route::match(['get', 'post'], '/addSources', [SourcesController::class, 'addSources'])->name('admin.sources.addSources');
    Route::post('/deleteSources/{id}', [SourcesController::class, 'deleteSources'])->name('admin.sources.deleteSources');
    Route::post('/activeSources/{id}', [SourcesController::class, 'activeSources'])->name('admin.sources.activeSources');
    Route::get('/sources/edit/{id}', [SourcesController::class, 'editSources'])->name('admin.sources.editSources');
    Route::post('/sources/update', [SourcesController::class, 'updateSources'])->name('admin.sources.updateSources');
    // Sources

    // Status List
    Route::match(['get', 'post'], '/statuslist', [StatusListController::class, 'index'])->name('admin.statuslist');
    Route::match(['get', 'post'], '/addStatusList', [StatusListController::class, 'addStatusList'])->name('admin.statuslist.addStatusList');
    Route::post('/deleteStatusList/{id}', [StatusListController::class, 'deleteStatusList'])->name('admin.statuslist.deleteStatusList');
    Route::post('/activestatuslist/{id}', [StatusListController::class, 'activeStatusList'])->name('admin.statuslist.activeStatusList');
    Route::get('/statuslist/edit/{id}', [StatusListController::class, 'editStatusList'])->name('admin.statuslist.editStatusList');
    Route::post('/statuslist/update', [StatusListController::class, 'updateStatusList'])->name('admin.statuslist.updateStatusList');
    // Status List
    // Enquiries Entry
    Route::match(['get', 'post'], '/enquiries-entry', [EnquiriesEntryController::class, 'index'])->name('admin.manageenquiriesentry');
    Route::match(['get', 'post'], '/addEnquiriesEntry', [EnquiriesEntryController::class, 'addEnquiriesEntry'])->name('admin.manageenquiriesentry.addEnquiriesEntry');
    Route::match(['get', 'post'], '/editEnquiriesEntry/{id}', [EnquiriesEntryController::class, 'editEnquiriesEntry'])->name('admin.manageenquiriesentry.editEnquiriesEntry');
    Route::post('/deleteEnquiriesEntry/{id}', [EnquiriesEntryController::class, 'deleteEnquiriesEntry'])->name('admin.manageenquiriesentry.deleteEnquiriesEntry');
    Route::get('/viewEnquiriesEntry/{id}', [EnquiriesEntryController::class, 'viewEnquiriesEntry'])->name('admin.manageenquiriesentry.viewEnquiriesEntry');
    // Enquiries Entry
    
    // Enquiries Report
    Route::match(['get', 'post'], '/enquiries-report', [EnquiriesReportController::class, 'index'])->name('admin.manageenquiriesreport');
    Route::match(['get', 'post'], '/addEnquiriesReport', [EnquiriesReportController::class, 'addEnquiriesReport'])->name('admin.manageenquiriesreport.addEnquiriesReport');
    Route::match(['get', 'post'], '/editEnquiriesReport/{id}', [EnquiriesReportController::class, 'editEnquiriesReport'])->name('admin.manageenquiriesreport.editEnquiriesReport');
    Route::get('/assignEnquiriesReport/{id}', [EnquiriesReportController::class, 'assignEnquiriesReport'])->name('admin.manageenquiriesreport.assignEnquiriesReport');
    Route::post('/update-assign-to', [EnquiriesReportController::class, 'updateAssignTo'])->name('admin.manageenquiriesreport.updateAssignTo');
    Route::get('/viewEnquiriesReport/{id}', [EnquiriesReportController::class, 'viewEnquiriesReport'])->name('admin.manageenquiriesreport.viewEnquiriesReport');
    Route::get('export-enquiriesCsv', [EnquiriesReportController::class, 'exportEnquiriesCsv'])->name('admin.exportEnquiriesCsv');
    Route::get('export-enquiriesExcel', [EnquiriesReportController::class, 'exportEnquiriesExcel'])->name('admin.exportEnquiriesExcel');

    // Enquiries Report


    //Manage Follow Enquiries

    //Manage Blogs

    //BLogs
    Route::match(['get', 'post'], '/manageblogs', [ManageBlogsController::class, 'index'])->name('admin.manageblogs');
    Route::get('/manageblogs/data', [ManageBlogsController::class, 'getData'])->name('admin.manageblogs.data');
    Route::match(['get', 'post'], '/addmanageblogs', [ManageBlogsController::class, 'addmanageblogs'])->name('admin.manageblogs.addmanageblogs');
    Route::match(['get', 'post'], '/editmanageblogs/{id}', [ManageBlogsController::class, 'editmanageblogs'])->name('admin.manageblogs.editmanageblogs');
    Route::post('/activemanageblogs/{id}', [ManageBlogsController::class, 'activemanageblogs'])->name('admin.manageblogs.activemanageblogs');
    Route::post('/deletemanageblogs/{id}', [ManageBlogsController::class, 'deletemanageblogs'])->name('admin.manageblogs.deletemanageblogs');
    //BLogs

    //BlogsComments
    Route::match(['get', 'post'], '/manageblogscomments', [ManageBlogsCommentsController::class, 'index'])->name('admin.manageblogscomments');
    Route::get('/manageblogscomments/data', [ManageBlogsCommentsController::class, 'getData'])->name('admin.manageblogscomments.data');
    Route::match(['get', 'post'], '/editmanageblogscomments/{id}', [ManageBlogsCommentsController::class, 'editmanageblogscomments'])->name('admin.manageblogscomments.editmanageblogscomments');
    Route::post('/activemanageblogscomments/{id}', [ManageBlogsCommentsController::class, 'activemanageblogscomments'])->name('admin.manageblogscomments.activemanageblogscomments');
    Route::post('/deletemanageblogscomments/{id}', [ManageBlogsCommentsController::class, 'deletemanageblogscomments'])->name('admin.manageblogscomments.deletemanageblogscomments');
    //BlogsComments
    
    //Manage Blogs


    //Generate pdf or word doc
    Route::match(['get', 'post'], '/generatePackageDoc', [PackagePdfController::class, 'index'])->name('admin.generatePackageDoc');
    
    //Generate pdf or word doc
});
/********  ADMIN ROUTING    ********/
