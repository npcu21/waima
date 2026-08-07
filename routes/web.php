<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail; // add this
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\AgentController;

// ----------------- TEST EMAIL ROUTE -----------------
Route::get('/test-email', function () {
    Mail::raw('Test email from Laravel', function ($message) {
        $message->to('lokeshpandey9456@gmail.com') // your email
                ->subject('Test Email');
    });

    return "Email sent!";
});

// ----------------- HOME -----------------
Route::get('/', function () {
    return view('term');
});

// ==================== ADMIN ====================


Route::prefix('admin')->group(function(){

    Route::get('/create-user', [UserController::class,'create'])->name('admin.create_user');
    Route::post('/create-user', [UserController::class,'store'])->name('admin.store_user');

    Route::get('/login', [UserController::class,'showLoginForm'])->name('admin.login');
    Route::post('/login', [UserController::class,'login'])->name('admin.login.submit');

    Route::get('/dashboard', [UserController::class,'dashboard'])->name('admin.dashboard');

    Route::get('/users', [UserController::class, 'index'])->name('admin.list_users');

    Route::get('/user/{id}/edit', [UserController::class,'edit'])->name('admin.edit_user');
    Route::post('/user/{id}/update', [UserController::class,'update'])->name('admin.update_user');

    Route::delete('/user/{id}', [UserController::class,'destroy'])->name('admin.delete_user');

    Route::get('/user/{id}/send-ar', [UserController::class,'sendAR'])->name('admin.send_ar');

    Route::get('/logout', [UserController::class,'logout'])->name('admin.logout');
});


Route::get('admin/product-overview', [UserController::class, 'productOverview'])
     ->name('admin.product.overview');
Route::get('admin/product-overview-country', [UserController::class, 'productOverviewCountry'])
     ->name('admin.product.overview.country');

//      Route::prefix('masteradmin')->group(function() {
//     // Dashboard route
//     Route::get('/dashboard', [UserController::class, 'dashboard'])
//         ->name('masteradmin.dashboard');

//     // Show data route
//     Route::get('/show-data/{table}', [UserController::class, 'showData'])
//         ->name('masteradmin.showData');
// });
Route::prefix('masteradmin')->group(function() {
    // Dashboard route - optional table parameter
    Route::get('/dashboard/{table?}', [UserController::class, 'dashboard'])
        ->name('masteradmin.dashboard');
});
Route::get('/admin/products/all', [UserController::class, 'productAll'])->name('admin.products.all');
Route::get('/masteradmincountry/view-record/{table}/{id}', 
    [UserController::class, 'countryViewRecord']
)->name('masteradmincountry.view.record');
Route::get('/masteradmin/view-record/{table}/{id}', [UserController::class, 'viewRecord'])->name('masteradmin.view.record');
Route::get('/admin/privacy-policies/{language_id?}', [UserController::class, 'adminPrivacyPolicies']);
Route::get('/admin/terms-conditions/{language_id?}', [UserController::class, 'adminTermsConditions']);
// web.php
Route::post('admin/users/{id}/approve', [UserController::class, 'approve'])->name('admin.user.approve');
Route::post('admin/users/{id}/reject', [UserController::class, 'reject'])->name('admin.user.reject');

Route::get('/admin/country/farmer/add', [UserController::class, 'createCountryFarmer'])
     ->name('admin.country.farmer.add');

Route::post('/admin/country/farmer/store', [UserController::class, 'storecountryfmaer'])
     ->name('admin.country.farmer.store');
     Route::get('/admin/country/users', [UserController::class, 'countryUsers'])
    ->name('admin.country.users');


    Route::get('admin/country/approve/{id}', [UserController::class, 'approvecountry'])
    ->name('admin.country.approve');

// Reject user
Route::get('admin/country/reject/{id}', [UserController::class, 'rejectcountry'])
    ->name('admin.country.reject');
Route::get('/products-all-country', [UserController::class, 'allProductWithCountry'])->name('products.all.country');

// routes/web.php

// Edit country farmer
// Edit country farmer
Route::get('admin/country/farmer/edit/{id}', 
    [UserController::class, 'editCountryUser'])
    ->name('admin.country.farmer.edit');

// Update country farmer
Route::post('admin/country/farmer/update/{id}', 
    [UserController::class, 'updateCountryUser'])
    ->name('admin.country.farmer.update');
// web.php (ya aapke admin routes file me)
Route::delete('admin/country/{id}', [UserController::class, 'destroyCountry'])->name('admin.delete.country');
Route::get('admin/country/farmer/view/{id}', 
    [UserController::class, 'viewcountry'])
    ->name('admin.country.farmer.view');



use App\Http\Controllers\SeedController;

// Seed list
Route::get('/seeds', [SeedController::class, 'index'])->name('seeds.index');

// Seed create form
Route::get('/seed/create', [SeedController::class, 'create'])->name('seed.create');

// Seed store
Route::post('/seed/store', [SeedController::class, 'store'])->name('seed.store');




Route::post('/translate-form', [UserController::class, 'translateForm'])->name('translate.form');


// ================= ANNOUNCEMENTS =================
Route::get('/admin/announcement/create', [AnnouncementController::class, 'create'])->name('admin.create-announcement');
Route::post('/admin/announcement/store', [AnnouncementController::class, 'store'])->name('admin.store-announcement');
Route::get('/admin/announcement/list', [AnnouncementController::class, 'list'])->name('admin.list-announcements');
Route::get('/admin/announcement/edit/{id}', [AnnouncementController::class, 'edit'])->name('admin.edit-announcement');
Route::put('/admin/announcement/update/{id}', [AnnouncementController::class, 'update'])->name('admin.update-announcement');
Route::delete('/admin/announcement/delete/{id}', [AnnouncementController::class, 'destroy'])->name('admin.delete-announcement');
Route::get('admin/announcement/createcountry', [AnnouncementController::class, 'countrycreate'])
    ->name('admin.announcement.createcountry');
Route::post('admin/announcement/countrystore', [AnnouncementController::class, 'countrystore'])
    ->name('admin.announcement.countrystore');
Route::get('admin/announcements/country', 
    [AnnouncementController::class, 'listByCountry']
)->name('admin.announcement.countrylist');
Route::get('admin/announcement/{id}/editcountry', [AnnouncementController::class, 'countryedit'])
     ->name('admin.announcement.countryedit');

Route::put('admin/announcement/{id}/updatecountry', [AnnouncementController::class, 'updatecountry'])
     ->name('admin.announcement.updatecountry');

Route::delete('admin/announcement/{id}/deletcountry', [AnnouncementController::class, 'deletcountry'])
     ->name('admin.announcement.deletcountry');
    



// ================= SUPPLIERS =================
Route::get('/admin/supplier/create', [SupplierController::class, 'create'])->name('admin.create-supplier');
Route::post('/admin/supplier/store', [SupplierController::class, 'store'])->name('admin.store-supplier');
Route::get('/admin/suppliers', [SupplierController::class, 'index'])->name('admin.list-suppliers');
Route::get('/admin/supplier/{id}/view', [SupplierController::class, 'viewSupplier'])->name('admin.supplier.view');

Route::get('/admin/supplier/edit/{id}', [SupplierController::class, 'edit'])->name('admin.edit-supplier');
Route::put('/admin/supplier/update/{id}', [SupplierController::class, 'update'])->name('admin.update-supplier');
Route::get('/admin/suppliers', [SupplierController::class, 'index'])
    ->name('admin.supplier.list-suppliers');
    Route::get('/admin/supplier/edit/{id}', [SupplierController::class, 'edit'])
    ->name('admin.edit_supplier');
    Route::post('/supplier/country-store', [SupplierController::class, 'countryStore'])->name('supplier.countryStore');
Route::get('/supplier/addcountry', [SupplierController::class, 'showAddCountryForm'])->name('supplier.addCountry');
Route::get('/supplier/list', [SupplierController::class, 'countrySuppliersList'])->name('supplier.countryList');
Route::delete('/admin/supplier/delete/{id}', [SupplierController::class, 'destroy'])
    ->name('admin.supplier.delete-supplier');

  // Country Edit Form
Route::get('/supplier/edit-country/{id}', [SupplierController::class, 'editCountry'])->name('supplier.edit.country');
Route::post('/supplier/update-country/{id}', [SupplierController::class, 'updateCountry'])
    ->name('supplier.update.country');

Route::get('supplier/delete/{id}', [SupplierController::class, 'destroyCountry'])->name('supplier.delete');



// Approve supplier
Route::get('supplier/approve/{id}', [SupplierController::class, 'approveSuppliercountry'])
    ->name('supplier.approve');

// Reject supplier
Route::post('supplier/reject/{id}', [SupplierController::class, 'rejectSuppliercountry'])
    ->name('supplier.reject');
// View Supplier Details
// Web.php (Admin Routes)
Route::get('admin/supplier/view/{id}', [SupplierController::class, 'viewSupplierCountry'])
     ->name('admin.supplier.view_supplier_country');





// ================= AGENTS =================
Route::get('/admin/agent/create', [AgentController::class, 'create'])->name('admin.create-agent');
Route::post('/admin/agent/store', [AgentController::class, 'store'])->name('admin.store-agent');
Route::get('/admin/agents', [AgentController::class, 'index'])->name('admin.list-agents');
Route::get('/admin/agent/edit/{id}', [AgentController::class, 'edit'])->name('admin.edit-agent');
Route::put('/admin/agent/update/{id}', [AgentController::class, 'update'])->name('admin.update-agent');
Route::delete('/admin/agent/delete/{id}', [AgentController::class, 'destroy'])->name('admin.delete-agent');
Route::get('admin/get-regions/{countryId}', [AgentController::class, 'getRegions']);
Route::get('/country/agent/create', [AgentController::class, 'countryAgentCreate'])->name('country.agent.create');


// Store agent for Country Admin
Route::post('/country/agent/store', [AgentController::class, 'countryAgent'])->name('country.agent.store');

// Fetch regions (optional country)
Route::get('/country/agent/get-regions/{countryId?}', [AgentController::class, 'getRegions'])->name('country.agent.get-regions');
Route::get('/agents/country', [AgentController::class, 'countryAgentList'])
    ->name('agents.country.list');



use App\Http\Controllers\Admin\ProductController;

Route::prefix('admin')->group(function () {

    // ==================== PRODUCT ROUTES ====================
    Route::get('/products', [ProductController::class, 'productIndex'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'productCreate'])->name('products.create');
    Route::post('/products/store', [ProductController::class, 'productStore'])->name('products.store');
    Route::delete('/products/{id}', [ProductController::class, 'productDestroy'])->name('products.destroy');

    // ==================== MINERAL FERTILIZER ROUTES ====================
    Route::get('/fertilizers', [ProductController::class, 'fertilizerIndex'])->name('fertilizers.index');
    Route::get('/fertilizers/create', [ProductController::class, 'fertilizerCreate'])->name('fertilizers.create');
    Route::post('/fertilizers/store', [ProductController::class, 'fertilizerStore'])->name('fertilizers.store');
    Route::delete('/fertilizers/{id}', [ProductController::class, 'fertilizerDestroy'])->name('fertilizers.destroy');

});

// use App\Http\Controllers\Admin\AgricultureController;

// Route::prefix('admin')->group(function () {
//     Route::get('/agriculture/form', [AgricultureController::class, 'createForm'])->name('admin.agriculture.form');
//     Route::post('/agriculture/form', [AgricultureController::class, 'storeForm'])->name('admin.agriculture.form.store');
// });
use App\Http\Controllers\Admin\AgricultureController;

Route::prefix('admin')->group(function () {
    Route::get('/products/form', [AgricultureController::class, 'createForm'])->name('admin.products.form');
    Route::post('/products/form', [AgricultureController::class, 'storeForm'])->name('admin.products.form.store');
});






use App\Http\Controllers\OrganicAmendmentController;   // Not under Admin

// Form Selector Page (Central page with dropdown)
// Route::get('/admin/products/form-selector', function () {
//     return view('admin.products.form_selector');
// })->name('form.selector');

use App\Http\Controllers\SeedFormController;

Route::prefix('admin/products')->group(function () {
    Route::get('seedform', [SeedFormController::class, 'create'])->name('seedform.create'); // Show form
    Route::post('seedform', [SeedFormController::class, 'store'])->name('seedform.store'); // Handle POST
});
Route::get('/seed-forms', [SeedFormController::class, 'index'])
    ->name('seed-forms.index');
    Route::get('/admin/seed/form', [SeedFormController::class, 'seedform'])->name('seed.form');
Route::get('/products/suggestions', [SeedFormController::class, 'getProductSuggestions'])
    ->name('products.suggestions');

    // routes/web.php
Route::get('/products/animalfeed-suggestions', [AnimalFeedController::class, 'suggestions']);
// use App\Http\Controllers\AnimalFeedController;

// Route::post('/animalfeed/store', [AnimalFeedController::class, 'store'])->name('animalfeed.store');
// use App\Http\Controllers\AnimalFeedController;

// // Show the page with dropdown + forms
// Route::get('/admin/products/form-selector', [AnimalFeedController::class, 'create'])->name('form.selector');

// Route::get('/animalfeed/create', [AnimalFeedController::class, 'create'])->name('animalfeed.create');
// Route::get('/animal-feeds', [AnimalFeedController::class, 'index'])->name('animal-feeds.index');

// // Store form data
// Route::post('/animalfeed/store', [AnimalFeedController::class, 'store'])->name('animalfeed.store');
use App\Http\Controllers\AnimalFeedController;
Route::get('/admin/products/get-form-fields/{product_id}', 
    [AnimalFeedController::class, 'getFormFields']
)->name('get.form.fields');

Route::get('/admin/products/form-selector', 
    [AnimalFeedController::class, 'create']
)->name('form.selector');
Route::get('admin/products/get-form-fields/{id}', [ProductController::class, 'getFormFields']);
Route::get('admin/products/get-suppliers', [ProductController::class, 'getSuppliers']);
Route::get('admin/products/get-agents', [ProductController::class, 'getAgents']);

// Route::get('/admin/products/form-selector', [AnimalFeedController::class, 'create'])->name('form.selector');
Route::post('/animalfeed/store', [AnimalFeedController::class, 'store'])->name('animalfeed.store');
Route::get('/animal-feeds', [AnimalFeedController::class, 'index'])->name('animal-feeds.index');
Route::get('/admin/products/animalfeed', [AnimalFeedController::class, 'animalFeedForm'])->name('animalfeed.form');



use App\Http\Controllers\MineralFertilizerController;

Route::prefix('admin/products')->group(function () {
    
    Route::get('mineral', [MineralFertilizerController::class, 'create'])->name('mineral.create');
    Route::post('mineral', [MineralFertilizerController::class, 'store'])->name('mineral.store');
});
Route::get('/mineral-fertilizers', [MineralFertilizerController::class, 'index'])
    ->name('mineral-fertilizers.index');
    Route::get('/admin/products/mineral-fertilizer', [MineralFertilizerController::class, 'minerformcreate'])
     ->name('mineral.form');



// Organic Amendment Routes
Route::get('/admin/products/organic-amendment', [OrganicAmendmentController::class, 'create'])->name('organic.create');
Route::post('/admin/products/organic-amendment', [OrganicAmendmentController::class, 'store'])->name('organic.store');
Route::get('/organic-amendments', [OrganicAmendmentController::class, 'index'])
    ->name('organic-amendments.index');
Route::get('organic/form', [OrganicAmendmentController::class, 'organicForm'])->name('organic.form');


use App\Http\Controllers\BioStimulantController;

// Bio-Stimulants Routes
Route::get('/bio-stimulants', [BioStimulantController::class, 'index'])->name('bio-stimulants.index');
Route::get('/admin/products/bio-stimulants', [BioStimulantController::class, 'create'])->name('bio_stimulants.create');
Route::post('/admin/products/bio-stimulants', [BioStimulantController::class, 'store'])->name('bio_stimulants.store');
Route::get('/admin/products/biostimulants', [BioStimulantsController::class, 'bioStimulantsForm'])
     ->name('biostimulants.form');
use App\Http\Controllers\InorganicSoilConditionerController;
Route::get('admin/products/inorganic-form', [InorganicSoilConditionerController::class, 'inorganicForm']);

Route::get('inorganic-soil-conditioners/create', [InorganicSoilConditionerController::class, 'create'])->name('inorganic_soil_conditioners.create');
Route::post('inorganic-soil-conditioners/store', [InorganicSoilConditionerController::class, 'store'])->name('inorganic_soil_conditioners.store');
Route::get('/inorganic-soil-conditioners', [InorganicSoilConditionerController::class, 'index'])
    ->name('inorganic-soil-conditioners.index');
use App\Http\Controllers\SyntheticPesticideController;

Route::get('/synthetic-pesticides/create', [SyntheticPesticideController::class, 'create'])->name('synthetic_pesticides.create');
Route::post('/synthetic-pesticides', [SyntheticPesticideController::class, 'store'])->name('synthetic_pesticides.store');
Route::get('/synthetic-pesticides', [SyntheticPesticideController::class, 'index'])
    ->name('synthetic-pesticides.index');
Route::get('/admin/products/syntheticcrete', 
    [App\Http\Controllers\SyntheticPesticideController::class, 'createform']
)->name('syntheticcrete.form');

use App\Http\Controllers\VeterinaryProductController;

Route::get('/veterinary-products/create', [VeterinaryProductController::class, 'create'])->name('veterinary_products.create');
Route::post('/veterinary-products', [VeterinaryProductController::class, 'store'])->name('veterinary_products.store');
Route::get('/veterinary-products', [VeterinaryProductController::class, 'index'])
    ->name('veterinary-products.index');
    



    use App\Http\Controllers\ImageController;

Route::get('/images/create', [ImageController::class, 'create'])->name('images.create');
Route::post('/images/store', [ImageController::class, 'store'])->name('images.store');
Route::get('/images', [ImageController::class, 'index'])->name('images.index');


use App\Http\Controllers\MainController;

// Form page
Route::get('/products/form-selector', [MainController::class, 'formSelector'])->name('products.form.selector');

// AJAX routes
Route::get('/products/get-suppliers', [MainController::class, 'getSuppliers'])->name('products.get.suppliers');
Route::get('/products/get-agents', [MainController::class, 'getAgents'])->name('products.get.agents');




use App\Http\Controllers\MasterAdminController;



// ---------------------------
// Master Admin Register Routes
// ---------------------------
Route::get('/masteradmin/register', [MasterAdminController::class, 'showRegisterForm'])
     ->name('masteradmin.register.form');

Route::post('/masteradmin/register', [MasterAdminController::class, 'register'])
     ->name('masteradmin.register');

Route::get('/masteradmin/register-admin', [MasterAdminController::class, 'adminRegister'])
     ->name('masteradmin.register.admin');

Route::post('/masteradmin/register-admin', [MasterAdminController::class, 'registerAdmin'])
     ->name('masteradmin.register.admin.store');


// ---------------------------
// Master Admin Login Form (New Route /admin)
Route::get('/admin', [MasterAdminController::class, 'showLoginForm'])
    ->name('masteradmin.login.form');

// Login Submit
Route::post('/admin', [MasterAdminController::class, 'login'])
    ->name('masteradmin.login');

// Logout
Route::get('/masteradmin/logout', [MasterAdminController::class, 'logout'])
    ->name('masteradmin.logout');




    Route::get('/masteradmin/forgot-password', [MasterAdminController::class, 'forgot'])->name('masteradmin.forgot');
Route::post('/masteradmin/send-reset-link', [MasterAdminController::class, 'sendResetLink'])->name('masteradmin.sendResetLink');

Route::get('/masteradmin/reset-password/{token}', [MasterAdminController::class, 'showResetPage'])->name('masteradmin.resetPage');
Route::post('/masteradmin/update-password', [MasterAdminController::class, 'updatePassword'])->name('masteradmin.updatePassword');


// Dashboard (only accessible after login)
Route::get('/admin/dashboard', [UserController::class, 'dashboard'])
    ->name('admin.dashboard');



use App\Http\Controllers\FormStructureController;

Route::post('/form/save', [FormStructureController::class, 'store'])->name('form.store');
Route::post('/form/load', [FormStructureController::class, 'load'])->name('form.load');


use App\Http\Controllers\CountryController;

// Admin add country form
Route::get('/admin/add-country', [CountryController::class, 'create'])->name('countries.create');

// Form submit
Route::post('/admin/add-country', [CountryController::class, 'store'])->name('countries.store');

use App\Http\Controllers\DocumentController;

// Show Add Document form
Route::get('/admin/documents/create', [DocumentController::class, 'create'])->name('documents.create');

// Store uploaded document
Route::post('/admin/documents/store', [DocumentController::class, 'store'])->name('documents.store');

// Optional: List all uploaded documents
Route::get('/admin/documents', [DocumentController::class, 'index'])->name('documents.index');

// Optional: Download a document
Route::get('/admin/documents/download/{id}', [DocumentController::class, 'download'])->name('documents.download');

// Optional: Delete a document
Route::delete('/admin/documents/{id}', [DocumentController::class, 'destroy'])->name('documents.destroy');



Route::get('/country-admin/dashboard', [MasterAdminController::class, 'countryDashboard'])
     ->name('countryadmin.dashboard');














// country controller 
Route::post('masteradmin/login', [MasterAdminController::class, 'login'])->name('masteradmin.login');

// Country Admin dashboard route
Route::get('country-admin/dashboard', [MasterAdminController::class, 'countryDashboard'])
     ->name('countryadmin.dashboard');
     Route::post('admin/agent/status', [AgentController::class, 'updateStatus'])->name('admin.update-agent-status');


use App\Http\Controllers\DynamicFormController;

// Dynamic Form routes without admin prefix
Route::get('dynamic', [DynamicFormController::class, 'index'])->name('dynamic.index');
Route::get('dynamic/edit/{id}', [DynamicFormController::class, 'edit'])->name('dynamic.edit');
Route::post('dynamic/update/{id}', [DynamicFormController::class, 'update'])->name('dynamic.update');
Route::post('dynamic/update-all/{seedId}', [DynamicFormController::class, 'updateAll'])->name('dynamic.updateAll');




// Supplier List
Route::get('admin/suppliers/status', [SupplierController::class, 'supplierList'])
    ->name('admin.suppliers.status');

// Approve supplier
Route::get('admin/supplier/approve/{id}', [SupplierController::class, 'approveSupplier'])
    ->name('admin.supplier.approve');

// Reject supplier (POST)
Route::post('admin/supplier/reject/{id}', [SupplierController::class, 'rejectSupplier'])
    ->name('admin.supplier.reject');
Route::get('/admin/agents', [AgentController::class, 'agentStatus'])->name('admin.agent.status');
Route::post('/admin/agent/approve/{id}', [AgentController::class, 'approveAgent'])->name('admin.agent.approve');
Route::post('/admin/agent/reject/{id}', [AgentController::class, 'rejectAgent'])
     ->name('admin.agent.reject');
Route::get('/admin/view-agent/{id}', [AgentController::class, 'viewAgent'])
     ->name('admin.view-agent');

Route::get('admin/agent/edit-country/{id}', [AgentController::class, 'editCountry'])
     ->name('admin.agent.edit_country');
Route::post('agents/country/update/{id}', [AgentController::class, 'updateCountry'])
     ->name('admin.agent.update_country');
Route::delete('agents/country/delete/{id}', 
    [AgentController::class, 'destroycountry']
)->name('agents.country.delete');


// Show form
Route::get('/region/create', [CountryController::class, 'regioncreate'])->name('region.create');

// Store region
Route::post('/region/store', [CountryController::class, 'regionstore'])->name('region.store');
Route::get('/region/list', [CountryController::class, 'regionListView'])->name('region.list');

// Edit region form
Route::get('/region/edit/{id}', [CountryController::class, 'regionEdit'])->name('region.edit');

// Delete region
Route::delete('/region/delete/{id}', [CountryController::class, 'regionDelete'])->name('region.delete');
Route::put('/region/update/{id}', [CountryController::class, 'regionUpdate'])->name('region.update');
Route::get('/country/create', [CountryController::class, 'create'])->name('country.create');
Route::post('/country/store', [CountryController::class, 'store'])->name('country.store');

// List countries
Route::get('/country/list', [CountryController::class, 'list'])->name('country.list');

// Edit country
Route::get('/country/edit/{id}', [CountryController::class, 'edit'])->name('country.edit');
Route::put('/country/update/{id}', [CountryController::class, 'update'])->name('country.update');

// Delete country
Route::delete('/country/delete/{id}', [CountryController::class, 'delete'])->name('country.delete');

Route::post('admin/agents/{id}/approve', [AgentController::class, 'approveAgent'])->name('admin.approve-agent');
Route::post('admin/agents/{id}/reject', [AgentController::class, 'rejectAgent'])->name('admin.reject-agent');



Route::post('admin/record/{id}/status', [UserController::class, 'updateStatus'])->name('admin.record.updateStatus');
Route::post('admin/{table}/{id}/status', [UserController::class, 'updateStatus'])
    ->name('admin.record.updateStatus');

Route::post('/admin/update-status/{table}/{id}', [UserController::class, 'updateStatus'])
    ->name('admin.updateStatus');
    // Route::get('/view-record/{table}/{id}', [UserController::class, 'viewRecord'])->name('view.record');
        // Route::get('/view-record/{table}/{id}', [UserController::class, 'countryViewRecord'])->name('view.record');


    Route::post('admin/{table}/{id}/status', [UserController::class, 'updateStatus'])
    ->name('admin.record.updateStatus');


    // Delete record route
Route::delete('admin/delete/{table}/{id}', [UserController::class, 'deleteRecord'])
    ->name('admin.delete');


    Route::get('admin/edit/{table}/{id}', [UserController::class, 'editRecord'])->name('record.edit');
Route::post('admin/update/{table}/{id}', [UserController::class, 'updateRecord'])->name('record.update');
Route::get('country/edit/{table}/{id}', [UserController::class, 'editRecordCountry'])
    ->name('country.edit.record');
Route::post('country/update/{table}/{id}', [UserController::class, 'updateRecordCountry'])
    ->name('country.update.record');
Route::get('country/delete/{table}/{id}', [UserController::class, 'deleteRecordCountry'])
    ->name('country.delete.record');


Route::post('country/status/update/{table}/{id}', 
    [UserController::class, 'updateStatusCountry']
)->name('country.status.update');






Route::delete('masteradmin/delete/{id}', [MasterAdminController::class, 'destroy'])->name('masteradmin.delete');


Route::get('/masteradmin/list', [MasterAdminController::class, 'index'])->name('masteradmin.list');
Route::get('masteradmin/edit/{id}', [MasterAdminController::class, 'edit'])
    ->name('masteradmin.edit');

// Update Submit
Route::put('masteradmin/update/{id}', [MasterAdminController::class, 'update'])
    ->name('masteradmin.update');
use App\Http\Controllers\PriceHistoryController;

Route::get('/price-chart', [PriceHistoryController::class, 'index'])->name('chart.index');
Route::post('/price-chart', [PriceHistoryController::class, 'filter'])->name('chart.filter');
Route::get('/admin/products-map', [UserController::class, 'productMap'])->name('products.map');


use App\Http\Controllers\FcmController;

Route::get('/test-fcm', [FcmController::class, 'sendNotification']);


// routes/web.php
// routes/web.php

use App\Http\Controllers\LanguageController;

// List all languages
Route::get('/languages', [LanguageController::class, 'index'])->name('languages.index');

// Show form to add new language
Route::get('/languages/create', [LanguageController::class, 'create'])->name('languages.create');

// Store new language
Route::post('/languages/store', [LanguageController::class, 'store'])->name('languages.store');

// Show form to edit language
Route::get('/languages/edit/{id}', [LanguageController::class, 'edit'])->name('languages.edit');

// Update language
Route::put('/languages/update/{id}', [LanguageController::class, 'update'])->name('languages.update');

// Delete language
Route::delete('/languages/delete/{id}', [LanguageController::class, 'destroy'])->name('languages.destroy');



use Google\Auth\ApplicationDefaultCredentials;

Route::get('/test-creds', function () {
    $creds = ApplicationDefaultCredentials::getCredentials();
    dd($creds); // Ye credentials dump kar ke show karega
});
Route::get('/admin/users/{id}/view', [UserController::class, 'view'])->name('admin.user.view');

Route::get('admin/announcement/view/{id}', [App\Http\Controllers\Admin\AnnouncementController::class, 'view'])
    ->name('admin.view-announcement');


Route::get('masteradmin/upload/{table}/{id}', [MasterAdminController::class, 'uploadRecord'])->name('masteradmin.upload.record');
Route::post('masteradmin/upload/{table}/{id}', [MasterAdminController::class, 'uploadFile'])->name('masteradmin.upload.file');

// Country-specific upload form
Route::get('country-admin/upload/{table}/{id}', [MasterAdminController::class, 'countryUploadRecord'])
     ->name('countryadmin.upload.record');

// Handle uploaded file
Route::post('country-admin/upload/{table}/{id}', [MasterAdminController::class, 'countryUploadFile'])
     ->name('countryadmin.upload.file');




Route::get('/get-countries', function () {
    return \App\Models\Country::select('id','name')->get();
});


use App\Http\Controllers\NotificationController;

Route::get('/notifications/count', [NotificationController::class, 'count']);
Route::get('/notifications/list', [NotificationController::class, 'list']);
Route::post('/notifications/mark-read/{id}', [NotificationController::class, 'markRead']);



// Approve agent in country list
Route::get('admin/agent/approve/{id}', [AgentController::class, 'approveAgentcountry'])
     ->name('admin.agent.approve_country');



Route::get('products/get-suppliers', [AnimalFeedController::class, 'getSuppliers']);
Route::get('products/get-agents', [AnimalFeedController::class, 'getAgents']);
Route::get('get-countries', [AnimalFeedController::class, 'getCountries']);

Route::get('/products/country/create', [AnimalFeedController::class, 'createCountryForm'])
    ->name('products.country.create');
Route::get('/products/get-country-suppliers', [AnimalFeedController::class, 'getCountrySuppliers'])
    ->name('products.get.country.suppliers');
Route::get('/products/get-country-agents', [AnimalFeedController::class, 'getCountryAgents'])
    ->name('products.get.country.agents');
Route::get('/products/get-country-list', [AnimalFeedController::class, 'getCountryList'])
    ->name('products.get.country.list');

Route::prefix('country-admin')->group(function () {
    Route::get('/country-form-selector', function () {
        return view('admin.products.country_form_selector');
    })->name('countryadmin.country.form.selector');
});

Route::get('admin/products/export', [UserController::class, 'export'])
     ->name('admin.products.export');

Route::post('admin/products/import', [UserController::class, 'importExcel'])
     ->name('admin.products.import');

use App\Http\Controllers\QrScanController;

Route::get('{type}/{id}', [QrScanController::class, 'show'])
     ->where('id', '[0-9]+');

     Route::get('/admin/products/all-testing', [UserController::class, 'productAllTesting'])
    ->name('admin.products.all.testing');
