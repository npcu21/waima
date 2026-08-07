<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Type;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterAdmin;

class AnnouncementController extends Controller
{
    public function index()
    {
        $usertypes = Type::all();
        return view('admin.dashboard', compact('usertypes'));
    }



public function create(Request $request)
{
    // ✅ User types
    $usertypes = Type::all();

    // ✅ Countries (not required)
    $countries = \App\Models\Country::all();

    // ✅ Language from dashboard session
    $interfaceLang = session('lang', 'en');
    app()->setLocale($interfaceLang);

    // ✅ Prepare userType names per language
    $userTypeNames = [];
    foreach ($usertypes as $type) {
        $userTypeNames[$interfaceLang][$type->id] = $type->{'name_type_'.$interfaceLang} ?? $type->name_type;
    }

    return view('admin.create_announcement', compact('usertypes', 'interfaceLang', 'userTypeNames', 'countries'));
}


public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',

        // ✅ multiple user type
        'user_type_id' => 'required|array',

        'status' => 'required|string',
        'language_id' => 'required|string',
        'country_id' => 'nullable|integer',
        'image' => 'nullable|image|max:2048',

        'currency' => 'nullable|array',
        'roles' => 'nullable|array',
    ]);

    $imagePath = null;

    if ($request->hasFile('image')) {

        $uploadPath = public_path('uploads/announcements');

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $imageName = time().'_'.uniqid().'.'.$request->image->extension();

        $request->image->move($uploadPath,$imageName);

        $imagePath = 'uploads/announcements/'.$imageName;
    }

    Announcement::create([
        'title' => $request->title,
        'description' => $request->description,

        // ✅ save multiple user types
        'user_type_id' => json_encode($request->user_type_id),

        'status' => $request->status,
        'language_id' => $request->language_id,
        'created_by' => Auth::id(),

        'country_id' => $request->country_id,

        // multiple select fields
        'currency' => $request->currency ? json_encode($request->currency) : null,
        'roles' => $request->roles ? json_encode($request->roles) : null,

        'image' => $imagePath,
    ]);

    return redirect()->back()->with('success', 'Announcement created successfully!');
}
// public function create(Request $request)
// {
//     // ✅ User types
//     $usertypes = Type::all();

//     // ✅ Countries (not required)
//     $countries = \App\Models\Country::all();

//     // ✅ Language from dashboard session
//     $interfaceLang = session('lang', 'en'); // default English
//     app()->setLocale($interfaceLang);

//     // ✅ Prepare userType names per language
//     $userTypeNames = [];
//     foreach ($usertypes as $type) {
//         $userTypeNames[$interfaceLang][$type->id] = $type->{'name_type_'.$interfaceLang} ?? $type->name_type;
//     }

//     return view('admin.create_announcement', compact('usertypes', 'interfaceLang', 'userTypeNames', 'countries'));
// }


// public function store(Request $request)
// {
//     $request->validate([
//         'title' => 'required|string|max:255',
//         'description' => 'required|string',
//         'user_type_id' => 'required|integer',
//         'status' => 'required|string',
//         'language_id' => 'required|string',
//         'country_id' => 'nullable|integer',
//         'image' => 'nullable|image|max:2048',

//         // new fields
//         'currency' => 'nullable|array',
//         'roles' => 'nullable|array',
//     ]);

//     $imagePath = null;

//     if ($request->hasFile('image')) {

//         $uploadPath = public_path('uploads/announcements');

//         if (!file_exists($uploadPath)) {
//             mkdir($uploadPath, 0777, true);
//         }

//         $imageName = time().'_'.uniqid().'.'.$request->image->extension();

//         $request->image->move($uploadPath,$imageName);

//         $imagePath = 'uploads/announcements/'.$imageName;
//     }

//     Announcement::create([
//         'title' => $request->title,
//         'description' => $request->description,
//         'user_type_id' => $request->user_type_id,
//         'status' => $request->status,
//         'language_id' => $request->language_id,
//         'created_by' => Auth::id(),

//         // optional country
//         'country_id' => $request->country_id,

//         // multiple select fields
//         'currency' => $request->currency ? json_encode($request->currency) : null,
//         'roles' => $request->roles ? json_encode($request->roles) : null,

//         'image' => $imagePath,
//     ]);

//     return redirect()->back()->with('success', 'Announcement created successfully!');
// }
// public function store(Request $request)
// {
//     $request->validate([
//         'title' => 'required|string|max:255',
//         'description' => 'required|string',
//         'user_type_id' => 'required|integer',
//         'status' => 'required|string',
//         'language_id' => 'required|string',
//         'country_id' => 'nullable|integer', // optional
//         'image' => 'nullable|image|max:2048', // any image type
//     ]);

//     $imagePath = null;

//     if ($request->hasFile('image')) {
//         $uploadPath = public_path('uploads/announcements');

//         if (!file_exists($uploadPath)) {
//             mkdir($uploadPath, 0777, true);
//         }

//         $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
//         $request->image->move($uploadPath, $imageName);

//         $imagePath = 'uploads/announcements/' . $imageName;
//     }

//     Announcement::create([
//         'title' => $request->title,
//         'description' => $request->description,
//         'user_type_id' => $request->user_type_id,
//         'status' => $request->status,
//         'language_id' => $request->language_id,
//         'created_by' => Auth::id(),
//         'currency' => $request->currency,
//         'country_id' => $request->country_id, // save optional country
//         'image' => $imagePath,
//     ]);

//     return redirect()->back()->with('success', 'Announcement created successfully!');
// }





   

public function list(Request $request)
{
    // ✅ Get language from session (default English)
    $interfaceLang = session('lang', 'en'); 
    app()->setLocale($interfaceLang);

    // ✅ Get selected country from request
    $selectedCountry = $request->input('country_id');

    // ✅ Prepare query for announcements
    $query = Announcement::query();

    // ✅ Filter by country if selected
    if ($selectedCountry) {
        $query->where('country_id', $selectedCountry);
    }

    // ✅ Fetch announcements with relationships
    $announcements = $query->latest()->get();

    // ✅ Prepare UserType names per language
    $userTypeNames = [];
    $userTypes = Type::all();
    foreach ($userTypes as $type) {
        $userTypeNames[$type->id] = $type->{'name_type_'.$interfaceLang} ?? $type->name_type;
    }

    // ✅ Fetch countries for dropdown
    $countries = \App\Models\Country::all();

    return view('admin.list_announcements', compact('announcements', 'interfaceLang', 'userTypeNames', 'countries', 'selectedCountry'));
}


public function view($id)
{
    $announcement = Announcement::findOrFail($id);

    // User type names for display
    $interfaceLang = session('lang', 'en');
    $userTypeName = $announcement->userType ? ($announcement->userType->{'name_type_'.$interfaceLang} ?? $announcement->userType->name_type) : '-';

    return view('admin.annocument.view_announcement', compact('announcement', 'userTypeName'));
}



public function edit($id, Request $request)
{
    // Find the announcement
    $announcement = Announcement::findOrFail($id);

    // Get all user types
    $usertypes = Type::all();

    // ✅ Use the dashboard language from session (default to English)
    $selectedLang = session('lang', 'en');
    app()->setLocale($selectedLang);

    // Prepare user type names per selected language
    $userTypeNames = [];
    foreach ($usertypes as $type) {
        $userTypeNames[$selectedLang][$type->id] = $type->{'name_type_'.$selectedLang} ?? $type->name_type;
    }

    return view('admin.edit_announcement', compact('announcement', 'usertypes', 'selectedLang', 'userTypeNames'));
}



    public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'user_type_id' => 'required|exists:usertype,id', // ✅ fixed
        'status' => 'required|string',
        'language_id' => 'nullable|string',
    ]);

    $announcement = Announcement::findOrFail($id);
    $announcement->update([
        'title' => $request->title,
        'description' => $request->description,
        'user_type_id' => $request->user_type_id,
        'status' => $request->status,
        'language_id' => $request->language_id ?? 'en',
    ]);

    return redirect()->back()->with('success', 'dashboard.announcement_updated');
}


    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();

        return redirect()->back()->with('success', 'Announcement deleted successfully!');
    }


// public function countrycreate(Request $request)
// {
//     // Logged-in user ki country_id
//     $loggedCountryId = auth()->user()->country_id ?? null;

//     // Language
//     $interfaceLang = session('lang', 'en');
//     app()->setLocale($interfaceLang);

//     // User Types
//     $usertypes = Type::all();

//     // Logged user ki country (Safe Fetch)
//     $selectedCountry = \App\Models\Country::find($loggedCountryId);

//     // UserType names by language
//     $userTypeNames = [];
//     foreach ($usertypes as $type) {
//         $userTypeNames[$interfaceLang][$type->id] =
//             $type->{'name_type_'.$interfaceLang} ?? $type->name_type;
//     }

//     return view('admin.annocument.createcountry', compact(
//         'usertypes',
//         'interfaceLang',
//         'userTypeNames',
//         'selectedCountry'
//     ));
// }





// public function countrystore(Request $request)
// {
//     $request->validate([
//         'title' => 'required|string|max:255',
//         'description' => 'required|string',
//         'user_type_id' => 'required|integer',
//         'status' => 'required|string',
//         'language_id' => 'required|string',
//         'country_id' => 'required|integer',
//         'image' => 'nullable|image|max:2048',
//     ]);

//     $imagePath = null;

//     if ($request->hasFile('image')) {
//         $uploadPath = public_path('uploads/announcements');

//         if (!file_exists($uploadPath)) {
//             mkdir($uploadPath, 0777, true);
//         }

//         $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
//         $request->image->move($uploadPath, $imageName);

//         $imagePath = 'uploads/announcements/' . $imageName;
//     }

//     Announcement::create([
//         'title' => $request->title,
//         'description' => $request->description,
//         'user_type_id' => $request->user_type_id,
//         'status' => $request->status,
//         'language_id' => $request->language_id,
//         'created_by' => Auth::id(),
//         'country_id' => $request->country_id,
//         'image' => $imagePath,
//     ]);

//     return redirect()->back()->with('success', 'Announcement created successfully!');
// }




// public function countrycreate(Request $request)
// {
//     // Logged-in user ki country
//     $selectedCountry = \App\Models\Country::find(auth()->user()->country_id);

//     // User types
//     $usertypes = Type::all();

//     // Language
//     $interfaceLang = session('lang', 'en');
//     app()->setLocale($interfaceLang);

//     // UserType language wise text
//     $userTypeNames = [];
//     foreach ($usertypes as $type) {
//         $userTypeNames[$interfaceLang][$type->id] =
//             $type->{'name_type_'.$interfaceLang} ?? $type->name_type;
//     }

//     return view('admin.annocument.createcountry', compact(
//         'usertypes',
//         'interfaceLang',
//         'userTypeNames',
//         'selectedCountry' // 💥 IMPORTANT
//     ));
// }

public function countrycreate(Request $request)
{
    // -----------------------------------------
    // 1️⃣ MASTER ADMIN LOGIN CHECK (same logic)
    // -----------------------------------------
    $admin_id = session('masteradmin_id'); 

    if (!$admin_id) {
        return redirect()->route('masteradmin.login.form')
                         ->with('error', __('dashboard.please_login_first'));
    }

    $user = MasterAdmin::find($admin_id); // <-- same user as dashboard


    // -----------------------------------------
    // 2️⃣ LANGUAGE (same as dashboard)
    // -----------------------------------------
    $interfaceLang = session('lang', 'en');

    if ($request->has('lang')) {
        $interfaceLang = $request->lang;
        session(['lang' => $interfaceLang]);
    }

    app()->setLocale($interfaceLang);


    // -----------------------------------------
    // 3️⃣ SELECTED COUNTRY (same logic)
    // -----------------------------------------
    $selectedCountry = null;

    if ($user->country_id) {
        $selectedCountry = \App\Models\Country::find($user->country_id);
    }


    // -----------------------------------------
    // 4️⃣ USER TYPES
    // -----------------------------------------
    $usertypes = Type::all();

    // language-wise labels
    $userTypeNames = [];
    foreach ($usertypes as $type) {
        $userTypeNames[$interfaceLang][$type->id] =
            $type->{'name_type_'.$interfaceLang} ?? $type->name_type;
    }


    // -----------------------------------------
    // 5️⃣ RETURN VIEW
    // -----------------------------------------
    return view('admin.annocument.createcountry', compact(
        'selectedCountry',
        'usertypes',
        'userTypeNames',
        'interfaceLang'
    ));
}


    // Store Announcement
    public function countrystore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'user_type_id' => 'required|integer',
            'status' => 'required|string',
            'language_id' => 'required|string',
            'country_id' => 'required|integer',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $uploadPath = public_path('uploads/announcements');
            if (!file_exists($uploadPath)) mkdir($uploadPath, 0777, true);

            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move($uploadPath, $imageName);

            $imagePath = 'uploads/announcements/' . $imageName;
        }

        Announcement::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_type_id' => $request->user_type_id,
            'status' => $request->status,
            'language_id' => $request->language_id,
            'created_by' => Auth::id(),
            'country_id' => $request->country_id,
            'image' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Announcement created successfully!');
    }

//     public function listByCountry()
// {
//     // 🔐 Check admin login
//     $admin_id = session('masteradmin_id');

//     if (!$admin_id) {
//         return redirect()->route('masteradmin.login.form')
//                          ->with('error', __('dashboard.please_login_first'));
//     }

//     // 🔍 Logged Admin
//     $admin = \App\Models\MasterAdmin::find($admin_id);

//     if (!$admin || !$admin->country_id) {
//         return back()->with('error', 'No country assigned to this admin');
//     }

//     // 🌍 Load only announcements of this admin's country
//     $announcements = \App\Models\Announcement::with(['userType', 'country'])
//                      ->where('country_id', $admin->country_id)
//                      ->orderBy('id', 'DESC')
//                      ->get();

//     // 🌐 Load language
//     $interfaceLang = session('lang', 'en');
//     app()->setLocale($interfaceLang);

//     return view('admin.annocument.listcountry', compact(
//         'announcements',
//         'interfaceLang'
//     ));
// }

public function listByCountry()
{
    // 🔐 Check admin login
    $admin_id = session('masteradmin_id');

    if (!$admin_id) {
        return redirect()->route('masteradmin.login.form')
                         ->with('error', __('dashboard.please_login_first'));
    }

    // 🔍 Logged Admin
    $admin = \App\Models\MasterAdmin::find($admin_id);

    if (!$admin || !$admin->country_id) {
        return back()->with('error', 'No country assigned to this admin');
    }

    // 🌍 Load only announcements of this admin's country
    $announcements = \App\Models\Announcement::with(['userType', 'country'])
                     ->where('country_id', $admin->country_id)
                     ->orderBy('id', 'DESC')
                     ->get();

    // 🌐 Load language
    $interfaceLang = session('lang', 'en');
    app()->setLocale($interfaceLang);

    return view('admin.annocument.listcountry', compact(
        'announcements',
        'interfaceLang'
    ));
}

    
// Edit function
public function countryedit($id)
{
    $announcement = \App\Models\Announcement::findOrFail($id);

    // Admin country check
    $admin_id = session('masteradmin_id');
    $admin = \App\Models\MasterAdmin::find($admin_id);
    if ($announcement->country_id != $admin->country_id) {
        return back()->with('error', 'You do not have permission to edit this announcement.');
    }

    $usertypes = \App\Models\Usertype::all();
    $countries = \App\Models\Country::all();

    return view('admin.annocument.editcountry', compact('announcement','usertypes','countries'));
}

// Update function
public function updatecountry(Request $request, $id)
{
    $announcement = \App\Models\Announcement::findOrFail($id);

    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'user_type_id' => 'required|integer',
        'status' => 'required|string',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120', // 5MB
    ]);

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads/announcements'), $filename);
        $announcement->image = $filename;
    }

    $announcement->update($request->only(['title','description','user_type_id','status']));

    return redirect()->route('admin.announcement.countrylist')
                     ->with('success', 'Announcement updated successfully.');
}

// Delete function
public function deletcountry($id)
{
    $announcement = \App\Models\Announcement::findOrFail($id);

    // Admin country check
    $admin_id = session('masteradmin_id');
    $admin = \App\Models\MasterAdmin::find($admin_id);
    if ($announcement->country_id != $admin->country_id) {
        return back()->with('error', 'You do not have permission to delete this announcement.');
    }

    // Delete image if exists
    if ($announcement->image && file_exists(public_path('uploads/announcements/'.$announcement->image))) {
        unlink(public_path('uploads/announcements/'.$announcement->image));
    }

    $announcement->delete();

    return redirect()->route('admin.announcement.countrylist')
                     ->with('success', 'Announcement deleted successfully.');
}


}
