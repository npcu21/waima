<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\UserTypeController;
use App\Http\Controllers\Api\CountryApiController;
use App\Http\Controllers\Api\LanguageApiController;
use App\Http\Controllers\Api\AnnouncementController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Api\FcmApiController;
use App\Http\Controllers\Api\AgentController;
use App\Http\Controllers\Api\AnimalFeedApiController;
use App\Http\Controllers\Api\SeedFormApiController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\SeedApiController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\BioStimulantApiController;
use App\Http\Controllers\Api\SyntheticPesticideApiController;
use App\Http\Controllers\Api\OrganicAmendmentApiController;
use App\Http\Controllers\Api\VeterinaryProductApiController;
use App\Http\Controllers\Api\MineralFertilizerApiController;
use App\Http\Controllers\Api\FormStructureController;
use App\Http\Controllers\Api\InorganicSoilConditionerApiController;
use App\Http\Controllers\Api\CommonProductApiController;
use App\Http\Controllers\Api\OnboardingContentApiController;
use App\Http\Controllers\Api\TermsConditionController;
use App\Http\Controllers\Api\FarmerEnquiryController;
use App\Http\Controllers\Api\PriceHistoryController;
use App\Http\Controllers\Api\EnquiryMessageController;

use Illuminate\Http\Request;


Route::prefix('users')->group(function () {

    Route::post('/register', [UserApiController::class, 'store']);

    Route::post('/register/verify-otp', [UserApiController::class, 'verifyRegistrationOtp']);

    // User login
    Route::post('/login', [UserApiController::class, 'login']);

    // List all users
    Route::get('/', [UserApiController::class, 'list']);

    // ================= Forgot Password via OTP =================
    // Step 1: Send OTP to email
    Route::post('/forgot-password', [UserApiController::class, 'forgotPassword']);

    // Step 2: Verify OTP
    Route::post('/forgot-password/verify-otp', [UserApiController::class, 'verifyOtp']);

    // Step 3: Reset password
    Route::post('/forgot-password/reset', [UserApiController::class, 'resetPasswordWithOtp']);

    // ================= Email Verification (optional if OTP used) =================
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return response()->json(['status' => true, 'message' => 'Email verified successfully!']);
    })->middleware(['auth:sanctum', 'signed'])->name('verification.verify');

    Route::post('/email/resend', function (Request $request) {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['status' => true, 'message' => 'Already verified']);
        }
        $request->user()->sendEmailVerificationNotification();
        return response()->json(['status' => true, 'message' => 'Verification link sent!']);
    })->middleware(['auth:sanctum'])->name('verification.send');
});
Route::post('/change-language', [UserApiController::class, 'changeLanguage']);
Route::get('/languages/{id?}', [UserApiController::class, 'getLanguages']);


// ==================== USER TYPES ====================
Route::prefix('usertypes')->group(function () {
    // List user types
    Route::get('/', [UserTypeController::class, 'index']);

    // Create new user type
    Route::post('/', [UserTypeController::class, 'store']);
});

// ==================== COUNTRIES ====================
Route::get('/countries', [CountryApiController::class, 'index']);

// ==================== LANGUAGES ====================
Route::prefix('languages')->group(function () {
    // List all languages
    Route::get('/', [LanguageApiController::class, 'list']);
});

// ==================== ANNOUNCEMENTS ====================
Route::get('/announcements', [AnnouncementController::class, 'index']);        // List all
Route::get('/announcements/{id}', [AnnouncementController::class, 'show']);
   // Single
Route::post('/announcement', [AnnouncementController::class, 'store']);
Route::put('/announcement/{id}', [AnnouncementController::class, 'update']);
Route::delete('/announcement/{id}', [AnnouncementController::class, 'destroy']);
Route::get('/allannouncements', [AnnouncementController::class, 'allAnnouncements']);




Route::get('/suppliers', [SupplierController::class, 'index']);
Route::get('/suppliers/{id}', [SupplierController::class, 'show']);
Route::post('/suppliers', [SupplierController::class, 'store']);
Route::put('/suppliers/{id}', [SupplierController::class, 'update']);
Route::delete('/suppliers/{id}', [SupplierController::class, 'destroy']);
Route::get('/statuses', [SupplierController::class, 'getStatuses']); // status api
Route::post('/suppliers', [SupplierController::class, 'distance']);




Route::get('/agents', [AgentController::class, 'index']);          // List all agents
Route::get('/agents/{id}', [AgentController::class, 'show']);      // Get single agent
Route::post('/agents', [AgentController::class, 'store']);        // Create agent
Route::put('/agents/{id}', [AgentController::class, 'update']);   // Update agent
Route::delete('/agents/{id}', [AgentController::class, 'destroy']); // Delete agent






// ✅ DO NOT add extra prefix like "api" again
Route::get('animal-feeds', [AnimalFeedApiController::class, 'index']);
Route::post('animal-feeds', [AnimalFeedApiController::class, 'store']);
Route::get('animal-feeds/{id}', [AnimalFeedApiController::class, 'show']);




Route::get('seed-forms', [SeedFormApiController::class, 'index']);
Route::get('seed-forms/{id}', [SeedFormApiController::class, 'show']);
Route::post('seed-forms', [SeedFormApiController::class, 'store']);






Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');



Route::get('/seeds', [SeedApiController::class, 'index']);
Route::get('/seed-forms', [SeedApiController::class, 'seedForms']);
Route::get('/seeds/category-count', [SeedApiController::class, 'categoryCount'])->name('seeds.category.count');


Route::get('/veterinary-products', [VeterinaryProductApiController::class, 'index']);
Route::get('/veterinary-products/{id}', [VeterinaryProductApiController::class, 'show']);
Route::post('/veterinary-products', [VeterinaryProductApiController::class, 'store']);


Route::get('mineral-fertilizers', [MineralFertilizerApiController::class, 'index']);
Route::get('mineral-fertilizers/{id}', [MineralFertilizerApiController::class, 'show']);
Route::post('mineral-fertilizers', [MineralFertilizerApiController::class, 'store']);



Route::get('/organic-amendments', [OrganicAmendmentApiController::class, 'index']);
Route::get('/organic-amendments/{id}', [OrganicAmendmentApiController::class, 'show']);
Route::post('/organic-amendments', [OrganicAmendmentApiController::class, 'store']);



Route::get('/forms/{product_id}', [FormStructureController::class, 'getFormByProduct']);
Route::get('/forms/{product_id}', [FormStructureController::class, 'getFormBySeed']);

// Get form by Seed (optional, if you want both)
Route::get('/forms-seed/{seed_id}', [FormStructureController::class, 'getFormBySeed']);


// Get all Bio-Stimulants
Route::get('/bio-stimulants', [BioStimulantApiController::class, 'index']);

// Get single Bio-Stimulant by ID
Route::get('/bio-stimulants/{id}', [BioStimulantApiController::class, 'show']);

// Create new Bio-Stimulant
Route::post('/bio-stimulants', [BioStimulantApiController::class, 'store']);




// ✅ Get all
Route::get('/synthetic-pesticides', [SyntheticPesticideApiController::class, 'index']);

// ✅ Get one
Route::get('/synthetic-pesticides/{id}', [SyntheticPesticideApiController::class, 'show']);

// ✅ Store (important)
Route::post('/synthetic-pesticides', [SyntheticPesticideApiController::class, 'store']);


// List all conditioners
Route::get('inorganic-soil-conditioners', [InorganicSoilConditionerApiController::class, 'index']);

// Show a single conditioner
Route::get('inorganic-soil-conditioners/{id}', [InorganicSoilConditionerApiController::class, 'show']);

// Create a new conditioner
Route::post('inorganic-soil-conditioners', [InorganicSoilConditionerApiController::class, 'store']);







Route::post('/common/store', [CommonProductApiController::class, 'store']);


Route::get('/seed/{id?}', [CommonProductApiController::class, 'getSeedForms']);



Route::get('/animal-feeds', [CommonProductApiController::class, 'getAnimalFeeds']);
Route::get('/bio-stimulants', [CommonProductApiController::class, 'getBioStimulants']);
Route::get('/inorganic-soil-conditioners', [CommonProductApiController::class, 'getInorganicSoilConditioners']);
Route::get('/mineral-fertilizers', [CommonProductApiController::class, 'getMineralFertilizers']);
Route::get('/organic-amendments', [CommonProductApiController::class, 'getOrganicAmendments']);
Route::get('/synthetic-pesticides', [CommonProductApiController::class, 'getSyntheticPesticides']);
Route::get('/veterinary-products', [CommonProductApiController::class, 'getVeterinaryProducts']);
Route::get('/all-forms', [CommonProductApiController::class, 'getAllFormData']);
Route::get('/all-forms/{id}', [CommonProductApiController::class, 'getFormDataById']);
Route::get('/forms', [CommonProductApiController::class, 'searchAllForms']);


Route::match(['put', 'post'], 'product/update-status', [CommonProductApiController::class, 'updateProductStatus']);



Route::get('all-forms/supplier/{supplier_id}', [CommonProductApiController::class, 'getAllFormsBySupplier']);
Route::get('all-forms/agent/{agent_id}', [CommonProductApiController::class, 'getAllFormsByAgent']);

Route::get('/supplier/forms/{supplier_id}', [CommonProductApiController::class, 'getSupplierForms']);



Route::post('/onboarding/store', [OnboardingContentApiController::class, 'store']);
Route::post('/onboarding/list', [OnboardingContentApiController::class, 'get']);   // POST with 



Route::prefix('v1')->group(function () {
    Route::get('terms', [TermsConditionController::class, 'index']);            // list (optional ?language_id=2)
    Route::post('terms', [TermsConditionController::class, 'store']);           // create
    Route::get('terms/{id}', [TermsConditionController::class, 'show']);       // single
    Route::post('terms/{id}', [TermsConditionController::class, 'update']);    // update (or use put)
    Route::delete('terms/{id}', [TermsConditionController::class, 'destroy']); // delete


     // ✅ Privacy Policy
    Route::get('privacy', [TermsConditionController::class, 'indexPrivacy']);
    Route::post('privacy', [TermsConditionController::class, 'storePrivacy']);
    Route::get('privacy/{id}', [TermsConditionController::class, 'showPrivacy']);
    Route::post('privacy/{id}', [TermsConditionController::class, 'updatePrivacy']);
    Route::delete('privacy/{id}', [TermsConditionController::class, 'deletePrivacy']);
});


// Normal POST route (no auth required)
Route::post('/farmer-enquiry', [FarmerEnquiryController::class, 'store']);


Route::get('/farmer-enquiries/total', [FarmerEnquiryController::class, 'totalEnquiriesWithProducts']);


Route::get('/farmer-enquiry/supplier-total', [FarmerEnquiryController::class, 'supplierTotalProducts']);
Route::get('/farmer-enquiries', [FarmerEnquiryController::class, 'farmerEnquiryList']);
// Farmer submits enquiry
Route::post('/farmer/enquiry', [FarmerEnquiryController::class, 'store']);
// Farmer views all his enquiries (with supplier reply)
Route::get('/farmer/enquiries', [FarmerEnquiryController::class, 'farmerEnquiryList']);
// Supplier views enquiries assigned to him
Route::get('/supplier/enquiries', [FarmerEnquiryController::class, 'supplierEnquiryList']);
Route::get('supplier-enquiry-list', [FarmerEnquiryController::class, 'supplierEnquiryList']);
// Supplier marks enquiry as seen
Route::post('/supplier/enquiry/{id}/seen', [FarmerEnquiryController::class, 'markAsSeen']);
Route::post('/close-chat', [FarmerEnquiryController::class, 'closeChat']);
// Supplier replies to an enquiry
Route::post('/supplier/enquiry/{id}/reply', [FarmerEnquiryController::class, 'replyEnquiry']);


Route::post('/supplier/enquiry/{id}/reply', [FarmerEnquiryController::class, 'replyEnquiry']);

Route::post('/supplier/enquiry/{id}/reply', [FarmerEnquiryController::class, 'supplierReply']);
Route::get('/farmer/enquiry/{id}/conversation', [FarmerEnquiryController::class, 'getConversation']);
// Route::get('/farmerdocument', [FarmerEnquiryController::class, 'farmerdocument']);

Route::get('/farmerdocument', [FarmerEnquiryController::class, 'farmerdocument']);

Route::get('/registration-form-structure', [UserApiController::class, 'getRegistrationFormStructure']);
Route::get('/translations', [UserApiController::class, 'getAppTranslations']);
Route::get('/enquiry/{id}/conversation', [FarmerEnquiryController::class, 'getFullConversation']);
Route::get('/farmer-enquiries', [FarmerEnquiryController::class, 'farmerWithCreatedById'])
     ->name('farmer.enquiries.by.createdby');
     Route::get('/farmer-enquiries', [FarmerEnquiryController::class, 'farmerWithCreatedById'])
     ->name('api.farmer.enquiries');

     Route::get('/farmerbyuser', [FarmerEnquiryController::class, 'farmerbyuser']);

// For API
Route::get('/api/farmerbyuser', [FarmerEnquiryController::class, 'farmerbyuser']);
Route::get('/farmerbyuser/{id}', [FarmerEnquiryController::class, 'farmerbyuser']);

// Supplier sends chat message
Route::post('/farmer-enquiry/{id}/message/supplier', [FarmerEnquiryController::class, 'supplierSendMessage']);
// Farmer sends chat message
Route::post('/farmer-enquiry/{id}/message/farmer', [FarmerEnquiryController::class, 'farmerSendMessage']);

Route::get('farmer/active-products', [FarmerEnquiryController::class, 'farmerActiveProducts']);

Route::get('/price-by-date', [PriceHistoryController::class, 'getPriceHistoryByDate']);
Route::get('/country-data', [FarmerEnquiryController::class, 'getCountryData']);
Route::get('enqery-types', [FarmerEnquiryController::class, 'enqerytypeget']);
Route::get('/all-filter/{product_id?}', [CommonProductApiController::class, 'allFilter']);
Route::get('/enquiry-messages', [EnquiryMessageController::class, 'index']);
Route::get('/enquiry-messages/{id}', [EnquiryMessageController::class, 'show']);
Route::post('/send-fcm', [FcmApiController::class, 'sendNotification']);
Route::get('/all-complementary', [EnquiryMessageController::class, 'getComplementaryData']);
Route::get('/complementary/{id?}', [EnquiryMessageController::class, 'getComplementaryData']);




Route::post('/farmer-enquiry/like-toggle', [FarmerEnquiryController::class, 'toggleLike']);


Route::get('/farmer/dashboard', [DashboardController::class, 'farmerDashboard']);
Route::get('agent/dashboard', [DashboardController::class, 'agentDashboard']);


Route::get('user/liked-products/{user_id}', [FarmerEnquiryController::class, 'getLikedProducts']);


Route::get('/suppliers-by-product', [CommonProductApiController::class, 'getSuppliersByProduct']);


Route::post('/search-products', [CommonProductApiController::class, 'search']);



Route::post('/farmer/pre-order', [FarmerEnquiryController::class, 'createPreOrder']);

Route::get('/supplier/pre-orders', [FarmerEnquiryController::class, 'pendingPreOrders']);

Route::post('/supplier/pre-order-response', [FarmerEnquiryController::class, 'supplierResponse']);

Route::get('/farmer/pre-orders/{farmer_id}', [FarmerEnquiryController::class, 'farmerPreOrders'])
;Route::get('/order-status', [FarmerEnquiryController::class, 'getOrderStatus']);








/*
|--------------------------------------------------------------------------
| Farmer Product Routes (Normal Web)
|--------------------------------------------------------------------------
*/

Route::get('/products/average-price', 
    [FarmerEnquiryController::class, 'productListWithAverage']
);

// 🔹 Download CSV for multiple products (category wise)
Route::get('/products/download-csv', 
    [FarmerEnquiryController::class, 'downloadCategoryCSV']
);

Route::get('/price-trend', [FarmerEnquiryController::class, 'priceTrend']);


Route::get('price-trend-excel', [FarmerEnquiryController::class, 'priceTrendExcel']);


Route::get('/products/suggestions', [CommonProductApiController::class, 'getProductSuggestions'])
    ->name('products.suggestions');