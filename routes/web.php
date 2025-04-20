<?php
use Illuminate\Support\Facades\Route;
/********  ADMIN ROUTING    ********/
use App\Http\Controllers\Admin\ManageUser\LoginController;
use App\Http\Controllers\Admin\ManageUser\ManageUserController;
use App\Http\Controllers\Admin\ManageVehicles\VehicleTypeController;
use App\Http\Controllers\Admin\ManageVehicles\VehiclePriceController;
use App\Http\Controllers\Admin\ManageHotels\HotelTypeController;
use App\Http\Controllers\Admin\ManageHotels\SeasonTypeController;
use App\Http\Controllers\Admin\ManageHotels\HotelController;
use App\Http\Controllers\Admin\ManageLocation\StateController;
use App\Http\Controllers\Admin\ManageLocation\DestinationTypeController;
use App\Http\Controllers\Admin\ManageLocation\DestinationController;
use App\Http\Controllers\Admin\ManageLocation\PlacesController;
use App\Http\Controllers\Admin\ManageMenus\MenutagController;
use App\Http\Controllers\Admin\ManageMenus\CategoryController;
use App\Http\Controllers\Admin\ManageMenus\CategoryTagsController;
use App\Http\Controllers\Admin\ManagePackages\PackageDurationsController;
use App\Http\Controllers\Admin\ManagePackages\TourPackagesController;
use App\Http\Controllers\Admin\ManagePackages\PackagesTypeController;
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
use App\Http\Controllers\Website\Destination\DestinationsController;
use App\Http\Controllers\Website\Blogs\BlogsController;
use App\Http\Controllers\Website\Home\HomeController;
use App\Http\Controllers\Website\Contact\ContactController;
use App\Http\Controllers\Website\Footer\FooterController;
use App\Http\Controllers\Website\Tour\TourController;
use App\Http\Controllers\Website\Places\PlaceController;
use App\Http\Controllers\Website\Faqs\FaqsController;
use App\Http\Controllers\Website\CommonFooterLinks\CommonfooterlinksController;
use App\Http\Controllers\Website\ContactUs\ContactusController;
use App\Http\Controllers\Website\AboutUs\AboutusController;
use App\Http\Controllers\Website\FooterQuickLinks\FooterquicklinksController;
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
Route::view('/bookingDownload', 'website.bookingDownload');
Route::view('/tourlisting', 'website.tourlisting');
Route::view('/tourdetails', 'website.tourdetails');
Route::get('/blog', [BlogsController::class, 'index'])->name('website.bloglisting');
Route::get('blog/{slug}', [BlogsController::class, 'blogdetails'])->name('website.blogdetails');
Route::match(['get', 'post'], 'blog-comments', [BlogsController::class, 'blogComments'])->name('website.blogComments');
Route::get('/search-blog-recent', [BlogsController::class, 'searchRecentBlog'])->name('website.blogsearch');

//HomePage
Route::get('/blogsHome', [HomeController::class, 'blogsHome'])->name('website.blogsHome');
Route::get('/popularTour', [HomeController::class, 'popularTour'])->name('website.popularTour');
Route::get('/destinationPlaces', [HomeController::class, 'destinationPlaces'])->name('website.destinationPlaces');
Route::get('/clientReviews', [HomeController::class, 'clientReviews'])->name('website.clientReviews');
//HomePage

//Tour Routing
Route::get('/coorg-tour-packages', [TourController::class, 'allTourPackages'])->name('website.allTourPackages');
Route::get('/place-package/{slug}', [TourController::class, 'allTourPlacePackages'])->name('website.allTourPlacePackages');
Route::get('tour/{slug}', [TourController::class, 'tourDetails'])->name('website.tourDetails');
Route::post('/submit-inquiry', [TourController::class, 'submitInquiry'])->name('website.packageinquiry');

Route::get('/getVehicles', [PackagePdfController::class, 'getVehicles'])->name('admin.generatePackageDoc.getVehicles');
Route::get('/getAccommodationWeb', [PackagePdfController::class, 'getAccommodationWeb'])->name('admin.generatePackageDoc.getAccommodationWeb');
Route::get('/getPackagePrice', [PackagePdfController::class, 'getPackagePrice'])->name('admin.generatePackageDoc.getPackagePrice');
//Tour Routing

//Destination Routing
Route::get('destinations/{slug}', [DestinationsController::class, 'index'])->name('website.destinationdetails');
Route::post('/get-places', [DestinationsController::class, 'getPlaces'])->name('website.places');
Route::get('/get-popular-tours', [DestinationsController::class, 'popularTourData'])->name('website.popularTourData');
//Destination Routing

//Place routing
Route::get('coorg/{slug}', [PlaceController::class, 'index'])->name('website.neardestination');
Route::get('/get-popular-tours-places', [PlaceController::class, 'popularTourDataPlaces'])->name('website.popularTourDataPlaces');
Route::get('/get-popular-places-data', [PlaceController::class, 'allPlacesDataAsPerDestination'])->name('website.allPlacesDataAsPerDestination');
Route::get('/popular-tour-places', [PlaceController::class, 'popularTourPlaces'])->name('website.popularTourPlaces');
//Place routing

//Faq
Route::get('/Faqs/{slug}', [FaqsController::class, 'index'])->name('website.faqs');
//Faq

//Common footer links
Route::get('/privacy-policy', [CommonfooterlinksController::class, 'index'])->name('website.privacy-policy');
Route::get('/booking-policy', [CommonfooterlinksController::class, 'bookingpolicy'])->name('website.booking-policy');
Route::get('/term-condition', [CommonfooterlinksController::class, 'termsConditions'])->name('website.term-condition');
//Common footer links

//contact us
Route::get('/contact-us', [ContactusController::class, 'index'])->name('website.contactus');
Route::match(['get', 'post'], 'addContacUs', [ContactusController::class, 'addContacUs'])->name('website.addContacUs');
//contact us

//about us
Route::get('/about-us', [AboutusController::class, 'index'])->name('website.about-us');
//about us

//Footer
Route::match(['get', 'post'], '/footer', [FooterController::class, 'index'])->name('website.footer');
//Footer

//FooterQuickLinks
Route::get('/coorg-packages/{slug}', [FooterquicklinksController::class, 'allTourPackages'])->name('website.allTourPackagesFooter');
//FooterQuickLinks
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

    //Package Type
    Route::match(['get', 'post'], '/package-type', [PackagesTypeController::class, 'index'])->name('admin.packageType');
    Route::match(['get', 'post'], '/addPackageType', [PackagesTypeController::class, 'addPackageType'])->name('admin.packageType.addPackageType');
    Route::post('/deletePackageType/{id}', [PackagesTypeController::class, 'deletePackageType'])->name('admin.packageType.deletePackageType');
    Route::post('/activePackageType/{id}', [PackagesTypeController::class, 'activePackageType'])->name('admin.packageType.activePackageType');
    Route::get('/packageType/edit/{id}', [PackagesTypeController::class, 'editPackageType'])->name('admin.packageType.editPackageType');
    Route::post('/packageType/update', [PackagesTypeController::class, 'updatePackageType'])->name('admin.packageType.updatePackageType');
    //Package Type

    // Tour Package
    Route::match(['get', 'post'], '/tour-packages', [TourPackagesController::class, 'index'])->name('admin.managetourpackages');
    Route::match(['get', 'post'], '/addTourPackages', [TourPackagesController::class, 'addTourPackages'])->name('admin.managetourpackages.addTourPackages');
    Route::match(['get', 'post'], '/editTourPackages/{id}', [TourPackagesController::class, 'editTourPackages'])->name('admin.managetourpackages.editTourPackages');
    Route::post('/deleteTourPackages/{id}', [TourPackagesController::class, 'deleteTourPackages'])->name('admin.managetourpackages.deleteTourPackages');
    Route::post('/activeTourPackages/{id}', [TourPackagesController::class, 'activeTourPackages'])->name('admin.managetourpackages.activeTourPackages');
    Route::post('/showTourPackages/{id}', [TourPackagesController::class, 'showTourPackages'])->name('admin.managetourpackages.showTourPackages');
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
    Route::get('/getPackageMaxCapacity/{id}', [PackagePdfController::class, 'getPackageMaxCapacity'])->name('admin.generatePackageDoc.getPackageMaxCapacity');
    Route::get('/getPackageItineraries/{id}', [PackagePdfController::class, 'getPackageItineraries'])->name('admin.generatePackageDoc.getPackageItineraries');
    Route::get('/getPackageAccommodations/{id}', [PackagePdfController::class, 'getPackageAccommodations'])->name('admin.generatePackageDoc.getPackageAccommodations');
    Route::get('/getAccommodation', [PackagePdfController::class, 'getAccommodation'])->name('admin.generatePackageDoc.getAccommodation');
    Route::match(['get', 'post'], '/generatePDF', [PackagePdfController::class, 'generatePDF'])->name('admin.generatePackageDoc.generatePDF');
    Route::match(['get', 'post'], '/generateDoc', [PackagePdfController::class, 'generateDoc'])->name('admin.generatePackageDoc.generateDoc');
    
    //Generate pdf or word doc
});

/********  ADMIN ROUTING    ********/
