<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Supplier;
use App\Models\Usertype;
use App\Models\UserTranslation;
use App\Models\UserCreationLog;
use App\Models\Language;
use App\Models\Country;
use App\Models\Region;
use App\Models\Seed;
use App\Models\MasterAdmin;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\File;
use App\Models\SupplierTranslate;
use Illuminate\Support\Facades\App;




use Stichoza\GoogleTranslate\GoogleTranslate;


class SupplierController extends Controller
{
  
// public function create(Request $request)
// {
//     // 🌎 Language
//     $lang = session('lang', 'en');
//     if ($request->has('lang')) {
//         $lang = $request->lang;
//         session(['lang' => $lang]);
//     }
//     App::setLocale($lang);

//     // Countries
//     $countries = Country::orderBy('name')->get();

//     // Regions (no language filter)
//     $regions = Region::orderBy('name', 'asc')->get();

//     return view('admin.supplier.create_supplier', compact('countries', 'regions', 'lang'));
// }



    

// public function store(Request $request)
// {
//     $request->validate([
//         'company_name' => 'required|string|max:255',
//         'manager_name' => 'required|string|max:255',
//         'position' => 'required|string|max:255',
//         'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
//         'city' => 'required|string|max:255',
//         'region' => 'required|array',
//         'region.*' => 'exists:regions,id',
//         'address' => 'required|string|max:255',
//         'phone' => 'required|string|max:20',
//         'mobile' => 'required|string|max:20',
//         'email' => 'required|email|max:255|unique:suppliers,email',
//         'state_entity_registration' => 'nullable|string|max:255',
//         'employer_identification_number' => 'nullable|string|max:255',
//         'status_id' => 'nullable|integer',
//         'latitude' => 'nullable|string|max:255',
//         'longitude' => 'nullable|string|max:255',
//         'country_id' => 'required|integer',
//     ]);

//     // Upload image
//     if ($request->hasFile('image')) {
//         $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
//         $request->image->move(public_path('uploads/supplier'), $imageName);
//     } else {
//         $imageName = null;
//     }

//     // Set default status_id = 1 if not provided
//     $statusId = $request->status_id ?? 1;

//     // Save supplier
//     Supplier::create([
//         'company_name' => $request->company_name,
//         'manager_name' => $request->manager_name,
//         'position' => $request->position,
//         'image' => $imageName,
//         'city' => $request->city,
//         'region' => json_encode($request->region),
//         'address' => $request->address,
//         'phone' => $request->phone,
//         'mobile' => $request->mobile,
//         'email' => $request->email,
//         'state_entity_registration' => $request->state_entity_registration,
//         'employer_identification_number' => $request->employer_identification_number,
//         'status_id' => $statusId,
//         'latitude' => $request->latitude,
//         'longitude' => $request->longitude,
//         'name' => $request->manager_name,
//         'username' => $request->email,
//         'password' => Hash::make('123456'),
//         'usertype_id' => 2,
//         'country_id' => $request->country_id,
//         'language_id' => 1,
//         'created_at' => now(),
//         'updated_at' => now(),
//     ]);

//     return redirect()->back()->with('success', __('messages.supplier_created'));
// }

public function create(Request $request)
{
    // Language setup
    $lang = session('lang', 'en');

    if ($request->has('lang')) {
        $lang = $request->lang;
        session(['lang' => $lang]);
    }

    App::setLocale($lang);

    // Get countries
    $countries = Country::orderBy('name')->get();

    // Get regions
    $regions = Region::orderBy('name', 'asc')->get();

    return view('admin.supplier.create_supplier', compact('countries','regions','lang'));
}



public function store(Request $request)
{
    // Validation
    $request->validate([

        'company_name' => 'required|string|max:255',
        'manager_name' => 'required|string|max:255',
        'position' => 'required|string|max:255',

        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',

        'city' => 'required|string|max:255',

        'region' => 'required|exists:regions,id',

        'address' => 'required|string|max:255',

        'phone' => 'required|string|max:20',
        'mobile' => 'required|string|max:20',

        'email' => 'required|email|max:255|unique:suppliers,email',

        'state_entity_registration' => 'nullable|string|max:255',

        'employer_identification_number' => 'nullable|string|max:255',

        'latitude' => 'nullable|numeric|between:-90,90',
        'longitude' => 'nullable|numeric|between:-180,180',

        'country_id' => 'required|exists:countries,id',

        'status_id' => 'nullable|integer',

    ]);


    // Image Upload
    $imageName = null;

    if ($request->hasFile('image')) {

        $imageName = time().'_'.uniqid().'.'.$request->image->extension();

        $request->image->move(public_path('uploads/supplier'), $imageName);

    }


    // Default status
    $statusId = $request->status_id ?? 1;


    // Create Supplier
    Supplier::create([

        'company_name' => $request->company_name,

        'manager_name' => $request->manager_name,

        'position' => $request->position,

        'image' => $imageName,

        'city' => $request->city,

        'region' => $request->region,

        'address' => $request->address,

        'phone' => $request->phone,

        'mobile' => $request->mobile,

        'email' => $request->email,

        'state_entity_registration' => $request->state_entity_registration,

        'employer_identification_number' => $request->employer_identification_number,

        'status_id' => $statusId,

        'latitude' => $request->latitude ?: null,

        'longitude' => $request->longitude ?: null,

        'name' => $request->manager_name,

        'password' => Hash::make('123456'),

        'usertype_id' => 2,

        'country_id' => $request->country_id,

        'language_id' => 1,

        'created_by' => auth()->id(),

        'created_at' => now(),

        'updated_at' => now()

    ]);


    return redirect()->back()->with('success', __('supplier.supplier_created'));
}


public function index(Request $request)
{
    // 🌎 Language
    $lang = session('lang', 'en');
    if ($request->has('lang')) {
        $lang = $request->lang;
        session(['lang' => $lang]);
    }
    App::setLocale($lang);

    $query = Supplier::query();

    // Country filter
    if ($request->has('country') && !empty($request->country)) {
        $query->where('country_id', $request->country);
    }

    // AJAX request handling
    if ($request->ajax()) {
        $suppliers = $query->orderBy('id', 'desc')->paginate(10);
        return view('admin.supplier_list_data', compact('suppliers'))->render();
    }

    $suppliers = $query->orderBy('id', 'desc')->paginate(10);

    // Countries list for dropdown
    $countries = Country::orderBy('name')->get();

    return view('admin.supplier.supplier_list', compact('suppliers', 'countries', 'lang'));
}




public function edit(Request $request, $id)
{
    // 🌎 Language
    $lang = session('lang', 'en');
    if ($request->has('lang')) {
        $lang = $request->lang;
        session(['lang' => $lang]);
    }
    App::setLocale($lang);

    // Fetch supplier
    $supplier = Supplier::findOrFail($id);

    // Fetch regions, countries, and statuses
    $regions = Region::all();
    $countries = Country::all();
    $statuses = DB::table('status')->get(); // Fetch all statuses

    return view('admin.supplier.edit_supplier', compact('supplier', 'regions', 'countries', 'statuses', 'lang'));
}
public function editCountry(Request $request, $id)
{
    // 🌎 Language Setup
    $lang = session('lang', 'en');
    if ($request->has('lang')) {
        $lang = $request->lang;
        session(['lang' => $lang]);
    }
    App::setLocale($lang);

    // ✅ Fetch Supplier
    $supplier = Supplier::findOrFail($id);

    // Fetch regions, countries, and statuses
    $regions = Region::all();
    $countries = Country::all();
    $statuses = DB::table('status')->get(); // Fetch all statuses

    return view('admin.supplier.edit_supplier_country', compact(
        'supplier',
        'regions',
        'countries',
        'statuses'
    ));
}


public function viewSupplier($id, Request $request)
{
    // 🌎 Language
    $lang = session('lang', 'en');
    if ($request->has('lang')) {
        $lang = $request->lang;
        session(['lang' => $lang]);
    }
    App::setLocale($lang);

    $supplier = Supplier::findOrFail($id);

    // Fetch regions, countries, and statuses
    $regions = Region::all();
    $countries = Country::all();
    $statuses = DB::table('status')->get();

    return view('admin.supplier.supplier_view', compact('supplier', 'regions', 'countries', 'statuses', 'lang'));
}


public function viewSuppliercountry($id)
{
    $supplier = Supplier::findOrFail($id);
    return view('admin.supplier.supplier_view', compact('supplier'));
}

public function updateCountry(Request $request, $id)
{
    $supplier = Supplier::findOrFail($id);

    $request->validate([
        'company_name' => 'required|string|max:255',
        'manager_name' => 'required|string|max:255',
        'position' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'region' => 'required|array',
        'region.*' => 'exists:regions,id',
        'address' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'mobile' => 'required|string|max:20',
        'email' => 'required|email|max:255|unique:suppliers,email,' . $id,
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'state_entity_registration' => 'nullable|string|max:255',
        'employer_identification_number' => 'nullable|string|max:255',
        'latitude' => 'nullable|string|max:255',
        'longitude' => 'nullable|string|max:255',
        'status_id' => 'nullable|integer|exists:status,id',
    ]);

    // Handle image upload
    if ($request->hasFile('image')) {
        if (!empty($supplier->image) && file_exists(public_path('uploads/supplier/'.$supplier->image))) {
            @unlink(public_path('uploads/supplier/'.$supplier->image));
        }
        $imageName = time().'_'.uniqid().'.'.$request->image->extension();
        $request->image->move(public_path('uploads/supplier'), $imageName);
    } else {
        $imageName = $supplier->image;
    }

    // Update supplier
    $supplier->update([
        'company_name' => $request->company_name,
        'manager_name' => $request->manager_name,
        'position' => $request->position,
        'city' => $request->city,
        'region' => json_encode($request->region),
        'address' => $request->address,
        'phone' => $request->phone,
        'mobile' => $request->mobile,
        'email' => $request->email,
        'image' => $imageName,
        'employer_identification_number' => $request->employer_identification_number,
        'state_entity_registration' => $request->state_entity_registration,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'status_id' => $request->status_id ?? $supplier->status_id ?? 1,
    ]);
return redirect()->route('supplier.countryList')
        ->with('success', 'Supplier country updated successfully!');

}


public function update(Request $request, $id)
{
    $supplier = Supplier::findOrFail($id);

    $request->validate([
        'company_name' => 'required|string|max:255',
        'manager_name' => 'required|string|max:255',
        'position' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'region' => 'required|array',
        'region.*' => 'exists:regions,id',
        'address' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'mobile' => 'required|string|max:20',
        'email' => 'required|email|max:255|unique:suppliers,email,' . $id,
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'state_entity_registration' => 'nullable|string|max:255',
        'employer_identification_number' => 'nullable|string|max:255',
        'latitude' => 'nullable|string|max:255',
        'longitude' => 'nullable|string|max:255',
        'status_id' => 'nullable|integer|exists:status,id',
    ]);

    // Handle image upload
    if ($request->hasFile('image')) {
        if (!empty($supplier->image) && file_exists(public_path('uploads/supplier/'.$supplier->image))) {
            @unlink(public_path('uploads/supplier/'.$supplier->image));
        }
        $imageName = time().'_'.uniqid().'.'.$request->image->extension();
        $request->image->move(public_path('uploads/supplier'), $imageName);
    } else {
        $imageName = $supplier->image;
    }

    // ✅ Update supplier
    $supplier->update([
        'company_name' => $request->company_name,
        'manager_name' => $request->manager_name,
        'position' => $request->position,
        'city' => $request->city,
        'region' => json_encode($request->region),
        'address' => $request->address,
        'phone' => $request->phone,
        'mobile' => $request->mobile,
        'email' => $request->email,
        'image' => $imageName,
        'employer_identification_number' => $request->employer_identification_number,
        'state_entity_registration' => $request->state_entity_registration,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'status_id' => $request->status_id ?? $supplier->status_id ?? 1, // assign ID, not object
    ]);

    // return redirect()->route('admin.list-suppliers')
    //     ->with('success', 'Supplier updated successfully!');
    return redirect('admin/suppliers')
    ->with('success', 'Supplier updated successfully!');

}









    // Delete supplier
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);

        // ✅ Delete image file if exists
        if ($supplier->image && file_exists(public_path('uploads/supplier/' . $supplier->image))) {
            unlink(public_path('uploads/supplier/' . $supplier->image));
        }

        $supplier->delete();
return redirect()->route('admin.supplier.list-suppliers')
                 ->with('success', 'Supplier deleted successfully!');    }

    
// Delete supplier
public function destroyCountry($id)
{
    $supplier = Supplier::findOrFail($id);

    // ✅ Delete image file if exists
    if ($supplier->image && file_exists(public_path('uploads/supplier/' . $supplier->image))) {
        unlink(public_path('uploads/supplier/' . $supplier->image));
    }

    $supplier->delete();

    // Redirect directly to full URL after deletion
    return redirect('https://fivoflow.com/wclm/public/supplier/list')
           ->with('success', 'Supplier deleted successfully!');
}


// Supplier List
public function supplierList()
{
    $suppliers = Supplier::orderBy('id', 'desc')->paginate(10);
    return view('admin.supplier.supplier_liststus', compact('suppliers'));
}

// Approve Supplier
public function approveSupplier($id)
{
    $supplier = Supplier::find($id);
    if (!$supplier) {
        return redirect()->back()->with('error', 'Supplier not found!');
    }

    $supplier->status_id = 2; // Approved
    $supplier->save();

    return redirect()->back()->with('success', 'Supplier approved successfully!');
}
public function approveSuppliercountry($id)
{
    $supplier = Supplier::find($id);
    if (!$supplier) {
        return redirect()->back()->with('error', 'Supplier not found!');
    }

    $supplier->status_id = 2; // Approved
    $supplier->save();

    return redirect()->back()->with('success', 'Supplier approved successfully!');
}

// Reject Supplier with message
public function rejectSuppliercountry(Request $request, $id)
{
    $request->validate([
        'reject_message' => 'required|string|max:255',
    ]);

    $supplier = Supplier::find($id);
    if (!$supplier) {
        return redirect()->back()->with('error', 'Supplier not found!');
    }

    $supplier->status_id = 3; // Rejected
    $supplier->reject_message = $request->reject_message;
    $supplier->save();

    return redirect()->back()->with('error', 'Supplier rejected successfully!');
}
public function rejectSupplier(Request $request, $id)
{
    $request->validate([
        'reject_message' => 'required|string|max:255',
    ]);

    $supplier = Supplier::find($id);
    if (!$supplier) {
        return redirect()->back()->with('error', 'Supplier not found!');
    }

    $supplier->status_id = 3; // Rejected
    $supplier->reject_message = $request->reject_message;
    $supplier->save();

    return redirect()->back()->with('error', 'Supplier rejected successfully!');
}

public function showAddCountryForm(Request $request) {
    // 🌎 Language Setup
    $lang = session('lang', 'en');
    if ($request->has('lang')) {
        $lang = $request->lang;
        session(['lang' => $lang]);
    }
    App::setLocale($lang);

    // ✅ Fetch regions for dropdown
    $regions = Region::all();

    return view('admin.supplier.addcountry', compact('regions'));
}



public function countryStore(Request $request)
{
    $request->validate([
        'company_name' => 'required|string|max:255',
        'manager_name' => 'required|string|max:255',
        'position' => 'required|string|max:255',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'city' => 'required|string|max:255',
        'region' => 'required|array',
        'region.*' => 'exists:regions,id',
        'address' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'mobile' => 'required|string|max:20',
        'email' => 'required|email|max:255|unique:suppliers,email',
        'state_entity_registration' => 'nullable|string|max:255',
        'employer_identification_number' => 'nullable|string|max:255',
        'status_id' => 'nullable|integer',
        'latitude' => 'nullable|string|max:255',
        'longitude' => 'nullable|string|max:255',
    ]);

    // 🔹 Upload image
    if ($request->hasFile('image')) {
        $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads/supplier'), $imageName);
    } else {
        $imageName = null;
    }

    $statusId = $request->status_id ?? 1;

    // 🔹 Get country_id from logged-in user or session
    $countryId = session('country_id') ?? 1; // default 1 agar session me nahi ho
    $languageId = session('language_id') ?? 1; // default language id

    // 🔹 Save supplier
    Supplier::create([
        'company_name' => $request->company_name,
        'manager_name' => $request->manager_name,
        'position' => $request->position,
        'image' => $imageName,
        'city' => $request->city,
        'region' => json_encode($request->region),
        'address' => $request->address,
        'phone' => $request->phone,
        'mobile' => $request->mobile,
        'email' => $request->email,
        'state_entity_registration' => $request->state_entity_registration,
        'employer_identification_number' => $request->employer_identification_number,
        'status_id' => $statusId,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'name' => $request->manager_name,
        'username' => $request->email,
        'password' => Hash::make('123456'),
        'usertype_id' => 2,
        'country_id' => $countryId, // ✅ Automatically set from login/session
        'language_id' => $languageId,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->back()->with('success', __('supplier.supplier_created'));
}



public function countrySuppliersList(Request $request)
{
    // 🌎 Language Setup
    $lang = session('lang', 'en');
    if ($request->has('lang')) {
        $lang = $request->lang;
        session(['lang' => $lang]);
    }
    App::setLocale($lang);

    // ✅ Get Country from session
    $countryId = session('country_id');

    if (!$countryId) {
        return redirect()->route('masteradmin.login.form')
                         ->with('error', __('dashboard.please_login_first'));
    }

    // Paginate suppliers (10 per page)
    $suppliers = Supplier::where('country_id', $countryId)
                         ->orderBy('id', 'desc')
                         ->paginate(10);

    return view('admin.supplier.list', compact('suppliers'));
}





}
