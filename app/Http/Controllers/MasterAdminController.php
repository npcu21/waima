<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterAdmin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Admin\UserController; // Dashboard Controller
use App\Models\Country;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;  // ✅ Add this line
use Illuminate\Support\Facades\Schema; // ← Add this
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class MasterAdminController extends Controller
{
 
public function showRegisterForm(Request $request)
{
    // 🌎 Language handling (same as your view function)
    $lang = session('lang', 'en');

    if ($request->has('lang')) {
        $lang = $request->lang;
        session(['lang' => $lang]);
    }

    App::setLocale($lang);

    // Fetch all countries
    $countries = \DB::table('countries')->orderBy('name', 'asc')->get();

    // Pass country + lang to the registration view
    return view('masteradmin.register', compact('countries', 'lang'));
}
public function adminRegister(Request $request)
{
    // 🌎 Language handling (same as your view function)
    $lang = session('lang', 'en');

    if ($request->has('lang')) {
        $lang = $request->lang;
        session(['lang' => $lang]);
    }

    App::setLocale($lang);

    // Fetch all countries
    $countries = \DB::table('countries')->orderBy('name', 'asc')->get();

    // Pass country + lang to the registration view
    return view('masteradmin.register_admin', compact('countries', 'lang'));
}



//  public function index()
//     {
//         // Master Admin ke saath country ka naam bhi le aayenge
//         $admins = MasterAdmin::with('country')->get();

//         // View me data pass karo
//         return view('masteradmin.list', compact('admins'));
//     } transate    

public function index(Request $request)
{
    // 🌍 Language Handling
    $lang = session('lang', 'en');

    if ($request->has('lang')) {
        $lang = $request->lang;
        session(['lang' => $lang]);
    }

    App::setLocale($lang);

    // Master Admin with country
    $admins = MasterAdmin::with('country')->get();

    return view('masteradmin.list', compact('admins', 'lang'));
}


public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:master_admin,email',
        'phone' => 'required|string|max:20',
        'password' => 'required|min:6|confirmed',
        // 'country_id' removed from required
    ]);

    MasterAdmin::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => Hash::make($request->password),
        'country_id' => $request->country_id ?? null, // optional now
    ]);

    return redirect()->route('masteradmin.login.form')
                     ->with('message', 'Registration successful! Please login.');
}
public function registerAdmin(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:master_admin,email',
        'phone' => 'required|string|max:20',
        'password' => 'required|min:6|confirmed',
    ]);

    MasterAdmin::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => Hash::make($request->password),
        'country_id' => $request->country_id ?? null,
    ]);

    return redirect('admin')        // 👈 direct URL redirect
           ->with('message', 'Registration successful!');
}



public function edit(Request $request, $id)
{
    // 🌎 Language handling
    $lang = session('lang', 'en');

    if ($request->has('lang')) {
        $lang = $request->lang;
        session(['lang' => $lang]);
    }

    App::setLocale($lang);

    // Fetch the admin
    $admin = MasterAdmin::findOrFail($id);

    // Fetch countries for dropdown
    $countries = \DB::table('countries')->orderBy('name', 'asc')->get();

    // Pass admin + countries + lang to view
    return view('masteradmin.edit', compact('admin', 'countries', 'lang'));
}



public function update(Request $request, $id)
{
    // Find the admin or fail
    $admin = MasterAdmin::findOrFail($id);

    // Validate input
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:master_admin,email,' . $id,
        'phone' => 'required|string|max:20',
        'password' => 'nullable|min:6|confirmed', // optional password
        'country_id' => 'nullable|exists:countries,id', // optional country
    ]);

    // Update fields
    $admin->name = $request->name;
    $admin->email = $request->email;
    $admin->phone = $request->phone;
    $admin->country_id = $request->country_id ?? null; // optional

    // Update password only if provided
    if ($request->filled('password')) {
        $admin->password = Hash::make($request->password);
    }

    // Save changes
    $admin->save();

    return redirect()->route('masteradmin.list')
                     ->with('message', 'Master Admin updated successfully.');
}

public function destroy($id)
{
    // Find the admin or fail
    $admin = MasterAdmin::findOrFail($id);

    // Delete the admin
    $admin->delete();

    // Redirect back with success message
    return redirect()->route('masteradmin.list')
                     ->with('message', 'Master Admin deleted successfully.');
}

   
    public function showLoginForm()
{
    if (Session::has('masteradmin_id')) {
        return redirect()->action([UserController::class, 'dashboard']);
    }

    $countries = Country::all(); // fetch all countries
    return view('masteradmin.login', compact('countries'));
}



public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Find admin by email
    $admin = MasterAdmin::where('email', $request->email)->first();

    // Check credentials
    if (!$admin || !Hash::check($request->password, $admin->password)) {
        return back()->with('error', 'Invalid credentials')->withInput();
    }

    // Save session
    Session::put('masteradmin_id', $admin->id);

    // Check if country_id exists
    if ($admin->country_id) {
        // Country-Admin
        Session::put('userType', 'Country-Admin');
        Session::put('country_id', $admin->country_id);

        return redirect()->route('countryadmin.dashboard')
                         ->with('message', 'Login successful as Country-Admin!');
    } else {
        // Regional-Admin
        Session::put('userType', 'Regional-Admin');
        Session::forget('country_id');

        return redirect()->action([UserController::class, 'dashboard'])
                         ->with('message', 'Login successful as Regional-Admin!');
    }
}


    // Logout
    public function logout()
    {
        Session::forget('masteradmin_id');
        Session::forget('userType');
        return redirect()->route('masteradmin.login.form')
                         ->with('message', 'Logged out successfully!');
    }
public function forgot()
{
    return view('masteradmin.forgot');
}


     public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $admin = MasterAdmin::where('email', $request->email)->first();

        if (!$admin) {
            return back()->with('error', 'Email not found');
        }

        $token = Str::random(60);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );

        $resetLink = url("/masteradmin/reset-password/$token?email=" . urlencode($request->email));

        // SEND EMAIL
        Mail::raw("Click the link to reset your password: $resetLink", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Master Admin Password Reset');
        });

        return back()->with('message', 'Reset link sent to your email');
    }

    // SHOW RESET PAGE
    public function showResetPage($token, Request $request)
    {
        return view('masteradmin.reset', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    // UPDATE PASSWORD
    public function updatePassword(Request $request)
    {
        $request->validate(['password' => 'required|min:6']);

        $record = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$record) {
            return back()->with('error', 'Invalid token');
        }

        MasterAdmin::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('masteradmin.login')->with('message', 'Password updated successfully!');
    }


    public function countryDashboard(Request $request)
{
    // ✅ Login check
    $admin_id = session('masteradmin_id');
    if (!$admin_id) {
        return redirect()->route('masteradmin.login.form')
            ->with('error', __('dashboard.please_login_first'));
    }

    $user = MasterAdmin::findOrFail($admin_id);

    // 🌎 Language
    $lang = session('lang', 'en');
    if ($request->has('lang')) {
        $lang = $request->lang;
        session(['lang' => $lang]);
    }
    App::setLocale($lang);

    // 🔒 FIXED COUNTRY (logged-in admin)
    $selectedCountry = $user->country_id;

    // ================= FILTERS =================
    $selectedCategory = $request->get('category');
    $search           = $request->get('search');

    // ================= COUNTRIES =================
    $countries = DB::table('countries')->pluck('name', 'id')->toArray();

    // ================= CATEGORY → TABLE MAP =================
    $tablesToShow = [
        'veterinary_products' => [
            'slug' => 'veterinary_products',
            'name' => 'Veterinary Products',
            'columns' => ['id','product_name','supplier_id','created_at','updated_at','retail_price','status_id','parent_id']
        ],
        'synthetic_pesticides' => [
            'slug' => 'synthetic_pesticides',
            'name' => 'Synthetic Pesticides',
            'columns' => ['id','trade_name','supplier_id','created_at','updated_at','retail_price','status_id','parent_id']
        ],
        'organic_amendments' => [
            'slug' => 'organic_amendments',
            'name' => 'Organic Amendments',
            'columns' => ['id','trade_name','supplier_id','created_at','updated_at','retail_price','status_id','parent_id']
        ],
        'seed_forms' => [
            'slug' => 'seeds',
            'name' => 'Seeds',
            'columns' => ['id','cropName','supplier_id','created_at','updated_at','retailPrice','status_id','parent_id']
        ],
        'mineral_fertilizers' => [
            'slug' => 'mineral_fertilizers',
            'name' => 'Mineral Fertilizers',
            'columns' => ['id','trade_name','supplier_id','created_at','updated_at','fertilizer_retail_price','status_id','parent_id']
        ],
        'bio_stimulants' => [
            'slug' => 'bio_stimulants',
            'name' => 'Biostimulants',
            'columns' => ['id','trade_name','supplier_id','created_at','updated_at','retail_price','status_id','parent_id']
        ],
        'animal_feeds' => [
            'slug' => 'animal_feeds',
            'name' => 'Animal Feed',
            'columns' => ['id','Typeoffeed','supplier_id','created_at','updated_at','afretailPrice','status_id','parent_id']
        ],
        'inorganic_soil_conditioners' => [
            'slug' => 'inorganic_soil_conditioners',
            'name' => 'Inorganic Soil Conditioners',
            'columns' => ['id','trade_name','supplier_id','created_at','updated_at','retail_price','status_id','parent_id']
        ],
    ];

    // ================= CATEGORY COUNTS =================
    $counts = [];

    foreach ($tablesToShow as $tableName => $info) {

        if (!Schema::hasTable($tableName)) {
            $counts[] = [
                'name'  => $info['name'],
                'slug'  => $info['slug'],
                'count' => 0
            ];
            continue;
        }

        $q = DB::table($tableName)
            ->leftJoin('suppliers', "$tableName.supplier_id", '=', 'suppliers.id')
            ->where('suppliers.country_id', $selectedCountry)
            ->where("$tableName.status_id", '>', 0)
            ->where("$tableName.status_id", '!=', 4);

        // ✅ Parent / Child logic (same as admin dashboard)
        if (Schema::hasColumn($tableName, 'parent_id')) {
            $q->where(function ($subQ) use ($tableName) {
                $subQ->whereNotNull("$tableName.parent_id")
                     ->orWhereNotIn("$tableName.id", function ($sub) use ($tableName) {
                         $sub->select('parent_id')
                             ->from($tableName)
                             ->whereNotNull('parent_id');
                     });
            });
        }

        $counts[] = [
            'name'  => $info['name'],   // ✅ FIXED
            'slug'  => $info['slug'],
            'count' => $q->count(),
        ];
    }

    // ✅ dropdownCounts FIX (blade expects this)
    $dropdownCounts = $counts;

    // ================= FETCH DATA =================
    $combinedData = collect();

    foreach ($tablesToShow as $tableName => $info) {

        if (!Schema::hasTable($tableName)) continue;
        if ($selectedCategory && $info['slug'] !== $selectedCategory) continue;

        $availableColumns = array_intersect(
            $info['columns'],
            Schema::getColumnListing($tableName)
        );

        $selectColumns = [];
        foreach ($availableColumns as $col) {
            $selectColumns[] = ($col === 'id')
                ? "$tableName.id as table_id"
                : "$tableName.$col";
        }

        $query = DB::table($tableName)
            ->select($selectColumns)
            ->leftJoin('suppliers', "$tableName.supplier_id", '=', 'suppliers.id')
            ->where('suppliers.country_id', $selectedCountry)
            ->where("$tableName.status_id", '>', 0)
            ->where("$tableName.status_id", '!=', 4)
            ->addSelect('suppliers.name as supplier_name');

        // ✅ Parent / Child logic
        if (in_array('parent_id', $availableColumns)) {
            $query->where(function ($q) use ($tableName) {
                $q->whereNotNull("$tableName.parent_id")
                  ->orWhereNotIn("$tableName.id", function ($sub) use ($tableName) {
                      $sub->select('parent_id')
                          ->from($tableName)
                          ->whereNotNull('parent_id');
                  });
            });
        }

        // 🔍 Search
        if ($search) {
            $query->where(function ($q) use ($availableColumns, $search, $tableName) {
                foreach ($availableColumns as $col) {
                    $q->orWhere("$tableName.$col", 'LIKE', "%{$search}%");
                }
            });
        }

        $data = $query->orderByDesc("$tableName.id")
            ->limit(10)
            ->get()
            ->map(function ($item) use ($info, $tableName) {
                $item->id = $item->table_id;
                $item->seed = $info['name'];
                $item->category_slug = $info['slug'];
                $item->table_name = $tableName;
                return $item;
            });

        $combinedData = $combinedData->merge($data);
    }

    $combinedData = $combinedData->sortByDesc('id')->values();

    return view('countryadmin.dashboard', compact(
        'user',
        'counts',
        'dropdownCounts',
        'combinedData',
        'selectedCategory',
        'selectedCountry',
        'countries',
        'lang'
    ));
}

//     public function countryDashboard(Request $request)
// {
//     // ✅ Login check
//     $admin_id = session('masteradmin_id');
//     if (!$admin_id) {
//         return redirect()->route('masteradmin.login.form')
//             ->with('error', __('dashboard.please_login_first'));
//     }

//     $user = MasterAdmin::findOrFail($admin_id);

//     // 🌎 Language Setup
//     $lang = session('lang', 'en');
//     if ($request->has('lang')) {
//         $lang = $request->lang;
//         session(['lang' => $lang]);
//     }
//     App::setLocale($lang);

//     // 🔒 FIXED COUNTRY
//     $selectedCountry = $user->country_id;

//     // ================= FILTERS =================
//     $selectedCategory = $request->get('category');
//     $search           = $request->get('search');
//     $statusFilter     = $request->get('status');
//     $yieldFilter      = $request->get('yield');

//     // ================= COUNTRIES =================
//     $countries = DB::table('countries')->pluck('name', 'id')->toArray();

//     // ================= CATEGORY → TABLE MAP =================
//     $categories = [
//         'seeds'                       => 'seed_forms',
//         'animal_feeds'                => 'animal_feeds',
//         'bio_stimulants'              => 'bio_stimulants',
//         'inorganic_soil_conditioners' => 'inorganic_soil_conditioners',
//         'mineral_fertilizers'         => 'mineral_fertilizers',
//         'organic_amendments'          => 'organic_amendments',
//         'synthetic_pesticides'        => 'synthetic_pesticides',
//         'veterinary_products'         => 'veterinary_products',
//     ];

//     // ================= CATEGORY COUNTS (STATUS 0 HIDDEN) =================
//     $counts = [];

//     foreach ($categories as $slug => $tableName) {

//         if (!Schema::hasTable($tableName)) {
//             $counts[] = [
//                 'name' => Str::title(str_replace('_',' ',$slug)),
//                 'slug' => $slug,
//                 'count' => 0
//             ];
//             continue;
//         }

//         $q = DB::table($tableName)
//             ->leftJoin('suppliers', "$tableName.supplier_id", '=', 'suppliers.id')
//             ->where('suppliers.country_id', $selectedCountry);

//         if (Schema::hasColumn($tableName, 'status_id')) {
//             $q->where("$tableName.status_id", '!=', 0)
//               ->where("$tableName.status_id", '!=', 4);
//         }

//         $counts[] = [
//             'name'  => Str::title(str_replace('_',' ',$slug)),
//             'slug'  => $slug,
//             'count' => $q->count(),
//         ];
//     }

//     $dropdownCounts = $counts;

//     // ================= TABLE CONFIG =================
//     $tablesToShow = [
//         'veterinary_products' => [
//             'slug' => 'veterinary_products',
//             'name' => 'Veterinary Products',
//             'columns' => ['id','product_name','supplier_id','updated_at','created_at','retail_price','status_id']
//         ],
//         'synthetic_pesticides' => [
//             'slug' => 'synthetic_pesticides',
//             'name' => 'Synthetic Pesticides',
//             'columns' => ['id','trade_name','supplier_id','updated_at','created_at','retail_price','status_id']
//         ],
//         'organic_amendments' => [
//             'slug' => 'organic_amendments',
//             'name' => 'Organic Amendments',
//             'columns' => ['id','trade_name','supplier_id','updated_at','created_at','retail_price','status_id']
//         ],
//         'seed_forms' => [
//             'slug' => 'seeds',
//             'name' => 'Seeds',
//             'columns' => ['id','cropName','supplier_id','updated_at','created_at','retailPrice','status_id']
//         ],
//         'mineral_fertilizers' => [
//             'slug' => 'mineral_fertilizers',
//             'name' => 'Mineral Fertilizers',
//             'columns' => ['id','trade_name','supplier_id','updated_at','created_at','fertilizer_retail_price','status_id']
//         ],
//         'biostimulants' => [
//             'slug' => 'biostimulants',
//             'name' => 'Biostimulants',
//             'columns' => ['id','trade_name','supplier_id','updated_at','created_at','retail_price','status_id']
//         ],
//         'animal_feeds' => [
//             'slug' => 'animal_feeds',
//             'name' => 'Animal Feed',
//             'columns' => ['id','Typeoffeed','supplier_id','updated_at','created_at','afretailPrice','status_id']
//         ],
//         'inorganic_soil_conditioners' => [
//             'slug' => 'inorganic_soil_conditioners',
//             'name' => 'Inorganic Soil Conditioners',
//             'columns' => ['id','trade_name','supplier_id','updated_at','created_at','retail_price','status_id']
//         ],
//     ];

//     // ================= FETCH DATA (STATUS 0 HIDDEN) =================
//     $combinedData = collect();

//     foreach ($tablesToShow as $tableName => $info) {

//         if (!Schema::hasTable($tableName)) continue;
//         if ($selectedCategory && $info['slug'] !== $selectedCategory) continue;

//         $availableColumns = array_intersect(
//             $info['columns'],
//             Schema::getColumnListing($tableName)
//         );

//         $selectColumns = [];
//         foreach ($availableColumns as $col) {
//             $selectColumns[] = ($col === 'id')
//                 ? "$tableName.id as table_id"
//                 : "$tableName.$col";
//         }

//         $query = DB::table($tableName)->select($selectColumns);

//         if (in_array('supplier_id', $availableColumns)) {
//             $query->leftJoin('suppliers', "$tableName.supplier_id", '=', 'suppliers.id')
//                 ->where('suppliers.country_id', $selectedCountry)
//                 ->addSelect('suppliers.name as supplier_name');
//         }

//         if (in_array('status_id', $availableColumns)) {
//             $query->where("$tableName.status_id", '!=', 0)
//                   ->where("$tableName.status_id", '!=', 4);
//         }

//         if ($search) {
//             $query->where(function ($q) use ($availableColumns, $search, $tableName) {
//                 foreach ($availableColumns as $col) {
//                     $q->orWhere("$tableName.$col", 'LIKE', "%{$search}%");
//                 }
//             });
//         }

//         if ($yieldFilter && $tableName === 'seed_forms' && in_array('yield', $availableColumns)) {
//             $query->where("$tableName.yield", 'LIKE', "%{$yieldFilter}%");
//         }

//         $data = $query->orderByDesc("$tableName.id")
//             ->limit(10)
//             ->get()
//             ->map(function ($item) use ($info, $tableName) {
//                 $item->id = $item->table_id;
//                 $item->seed = $info['name'];
//                 $item->category_slug = $info['slug'];
//                 $item->table_name = $tableName;
//                 return $item;
//             });

//         $combinedData = $combinedData->merge($data);
//     }

//     $combinedData = $combinedData->sortByDesc('id')->values();

//     return view('countryadmin.dashboard', compact(
//         'user',
//         'counts',
//         'dropdownCounts',
//         'combinedData',
//         'selectedCategory',
//         'selectedCountry',
//         'countries',
//         'lang'
//     ));
// }

//     public function countryDashboard(Request $request)
// {
//     // ✅ Login check
//     $admin_id = session('masteradmin_id');
//     if (!$admin_id) {
//         return redirect()->route('masteradmin.login.form')
//             ->with('error', __('dashboard.please_login_first'));
//     }

//     $user = MasterAdmin::findOrFail($admin_id);

//     // 🌎 Language Setup
//     $lang = session('lang', 'en');
//     if ($request->has('lang')) {
//         $lang = $request->lang;
//         session(['lang' => $lang]);
//     }
//     App::setLocale($lang);

//     // 🔒 FIXED COUNTRY
//     $selectedCountry = $user->country_id;

//     // ================= FILTERS =================
//     $selectedCategory = $request->get('category'); // slug
//     $search           = $request->get('search');
//     $statusFilter     = $request->get('status');
//     $yieldFilter      = $request->get('yield');

//     // ================= COUNTRIES =================
//     $countries = DB::table('countries')->pluck('name', 'id')->toArray();

//     // ================= CATEGORY → TABLE MAP =================
//     $categories = [
//         'seeds'                       => 'seed_forms',
//         'animal_feeds'                => 'animal_feeds',
//         'bio_stimulants'              => 'bio_stimulants',
//         'inorganic_soil_conditioners' => 'inorganic_soil_conditioners',
//         'mineral_fertilizers'         => 'mineral_fertilizers',
//         'organic_amendments'          => 'organic_amendments',
//         'synthetic_pesticides'        => 'synthetic_pesticides',
//         'veterinary_products'         => 'veterinary_products',
//     ];

//     // ================= CATEGORY COUNTS =================
//     $counts = [];

//     foreach ($categories as $slug => $tableName) {

//         if (!Schema::hasTable($tableName)) {
//             $counts[] = ['name' => Str::title(str_replace('_',' ',$slug)), 'slug' => $slug, 'count' => 0];
//             continue;
//         }

//         $q = DB::table($tableName)
//             ->leftJoin('suppliers', "$tableName.supplier_id", '=', 'suppliers.id')
//             ->where('suppliers.country_id', $selectedCountry);

//         if (Schema::hasColumn($tableName, 'status_id')) {
//             $q->where("$tableName.status_id", '!=', 4);
//         }

//         $counts[] = [
//             'name'  => Str::title(str_replace('_',' ',$slug)),
//             'slug'  => $slug,
//             'count' => $q->count(),
//         ];
//     }

//     // ================= DROPDOWN COUNTS (BLADE SAFE) =================
//     $dropdownCounts = $counts;

//     // ================= TABLE CONFIG =================
//        $tablesToShow = [
//         'veterinary_products' => [
//             'slug' => 'veterinary_products',
//             'name' => 'Veterinary Products',
//             'columns' => ['id','product_name','supplier_id','updated_at','created_at','retail_price','status_id']
//         ],
//         'synthetic_pesticides' => [
//             'slug' => 'synthetic_pesticides',
//             'name' => 'Synthetic Pesticides',
//             'columns' => ['id','trade_name','supplier_id','updated_at','created_at','retail_price','status_id']
//         ],
//         'organic_amendments' => [
//             'slug' => 'organic_amendments',
//             'name' => 'Organic Amendments',
//             'columns' => ['id','trade_name','supplier_id','updated_at','created_at','retail_price','status_id']
//         ],
//         'seed_forms' => [
//             'slug' => 'seeds',
//             'name' => 'Seeds',
//             'columns' => ['id','cropName','supplier_id','updated_at','created_at','retailPrice','status_id']
//         ],
//         'mineral_fertilizers' => [
//             'slug' => 'mineral_fertilizers',
//             'name' => 'Mineral Fertilizers',
//             'columns' => ['id','trade_name','supplier_id','updated_at','created_at','fertilizer_retail_price','status_id']
//         ],
//         'biostimulants' => [
//             'slug' => 'biostimulants',
//             'name' => 'Biostimulants',
//             'columns' => ['id','trade_name','supplier_id','updated_at','created_at','retail_price','status_id']
//         ],
//         'animal_feeds' => [
//             'slug' => 'animal_feeds',
//             'name' => 'Animal Feed',
//             'columns' => ['id','Typeoffeed','supplier_id','updated_at','created_at','afretailPrice','status_id']
//         ],
//         'inorganic_soil_conditioners' => [
//             'slug' => 'inorganic_soil_conditioners',
//             'name' => 'Inorganic Soil Conditioners',
//             'columns' => ['id','trade_name','supplier_id','updated_at','created_at','retail_price','status_id']
//         ],
//     ];

//     // ================= FETCH DATA =================
//     $combinedData = collect();

//     foreach ($tablesToShow as $tableName => $info) {

//         if (!Schema::hasTable($tableName)) continue;

//         if ($selectedCategory && $info['slug'] !== $selectedCategory) continue;

//         $availableColumns = array_intersect(
//             $info['columns'],
//             Schema::getColumnListing($tableName)
//         );

//         $selectColumns = [];
//         foreach ($availableColumns as $col) {
//             $selectColumns[] = ($col === 'id')
//                 ? "$tableName.id as table_id"
//                 : "$tableName.$col";
//         }

//         $query = DB::table($tableName)->select($selectColumns);

//         if (in_array('supplier_id', $availableColumns)) {
//             $query->leftJoin('suppliers', "$tableName.supplier_id", '=', 'suppliers.id')
//                 ->where('suppliers.country_id', $selectedCountry)
//                 ->addSelect('suppliers.name as supplier_name');
//         }

//         if (in_array('status_id', $availableColumns)) {
//             $query->where("$tableName.status_id", '!=', 4);
//         }

//         if ($search) {
//             $query->where(function ($q) use ($availableColumns, $search, $tableName) {
//                 foreach ($availableColumns as $col) {
//                     $q->orWhere("$tableName.$col", 'LIKE', "%{$search}%");
//                 }
//             });
//         }

//         if ($yieldFilter && $tableName === 'seed_forms' && in_array('yield', $availableColumns)) {
//             $query->where("$tableName.yield", 'LIKE', "%{$yieldFilter}%");
//         }

//         $data = $query->orderByDesc("$tableName.id")
//             ->limit(10)
//             ->get()
//             ->map(function ($item) use ($info, $tableName) {
//                 $item->id = $item->table_id;

//                 // 🔥 REQUIRED BY BLADE
//                 $item->seed = $info['name'];

//                 $item->category_slug = $info['slug'];
//                 $item->table_name = $tableName;
//                 return $item;
//             });

//         $combinedData = $combinedData->merge($data);
//     }

//     $combinedData = $combinedData->sortByDesc('id')->values();

//     // ================= RETURN VIEW =================
//     return view('countryadmin.dashboard', compact(
//         'user',
//         'counts',
//         'dropdownCounts',
//         'combinedData',
//         'selectedCategory',
//         'selectedCountry',
//         'countries',
//         'lang'
//     ));
// }

public function countryDashboarddd(Request $request)
{
    // ✅ Get Admin ID from session
    $admin_id = session('masteradmin_id'); 
    if (!$admin_id) {
        return redirect()->route('masteradmin.login.form')
                         ->with('error', __('dashboard.please_login_first'));
    }

    $user = MasterAdmin::find($admin_id);

    // 🌎 Language Setup
    $lang = session('lang', 'en');
    if ($request->has('lang')) {
        $lang = $request->lang;
        session(['lang' => $lang]);
    }
    App::setLocale($lang);
    $langId = $lang === 'fr' ? 2 : 1;

    // Filters
    $selectedCategory = $request->get('category');
    $search           = $request->get('search');
    $minPrice         = $request->get('min_price');
    $maxPrice         = $request->get('max_price');
    $yieldFilter      = $request->get('yield');
    $statusFilter     = $request->get('status');

    // ✅ Country fixed (logged-in admin)
    $selectedCountry = $user->country_id;

    // Seed Items (counts)
    $seedItems = DB::table('seed')
        ->where('language_id', $langId)
        ->get(['id', 'name']);

    $countries = DB::table('countries')->pluck('name', 'id')->toArray();

    // Table Map
    $tableMap = [
        'Seeds' => 'seed_forms',
        'Animal Feed' => 'animal_feeds',
        'Biostimulants' => 'bio_stimulants',
        'Inorganic Soil Conditioners' => 'inorganic_soil_conditioners',
        'Mineral Fertilizers' => 'mineral_fertilizers',
        'Organic Amendments' => 'organic_amendments',
        'Synthetic Pesticides' => 'synthetic_pesticides',
        'Veterinary Products' => 'veterinary_products',
    ];

    // ✅ Counts (country based, show 0 if no products)
    $counts = [];
    foreach ($seedItems as $seed) {
        $tableName = $tableMap[$seed->name] ?? null;

        if ($tableName && Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'supplier_id')) {
            $supplierIds = DB::table('suppliers')
                ->where('country_id', $selectedCountry)
                ->pluck('id')
                ->toArray();

            if (!empty($supplierIds)) {
                $count = DB::table($tableName)
                    ->whereIn('supplier_id', $supplierIds)
                    ->where('status_id', '!=', 4)
                    ->count();
            } else {
                $count = 0; // No suppliers in this country
            }
        } else {
            $count = 0;
        }

        $counts[] = [
            'name' => $seed->name,
            'count' => $count,
        ];
    }

    // ✅ SAME tables as MASTER dashboard
    $tablesToShow = [
        'veterinary_products' => [
            'name' => 'Veterinary Products',
            'columns' => ['id','product_name','supplier_id','updated_at','created_at','retail_price','status_id']
        ],
        'synthetic_pesticides' => [
            'name' => 'Synthetic Pesticides',
            'columns' => ['id','trade_name','supplier_id','updated_at','created_at','retail_price','status_id']
        ],
        'organic_amendments' => [
            'name' => 'Organic Amendments',
            'columns' => ['id','trade_name','supplier_id','updated_at','created_at','retail_price','status_id']
        ],
        'seed_forms' => [
            'name' => 'Seeds',
            'columns' => ['id','cropName','supplier_id','updated_at','created_at','retailPrice','status_id']
        ],
        'mineral_fertilizers' => [
            'name' => 'Mineral Fertilizers',
            'columns' => ['id','trade_name','supplier_id','updated_at','created_at','fertilizer_retail_price','status_id']
        ],
        'bio_stimulants' => [
            'name' => 'Biostimulants',
            'columns' => ['id','trade_name','supplier_id','updated_at','created_at','retail_price','status_id']
        ],
        'animal_feeds' => [
            'name' => 'Animal Feed',
            'columns' => ['id','Typeoffeed','supplier_id','updated_at','created_at','afretailPrice','status_id']
        ],
        'inorganic_soil_conditioners' => [
            'name' => 'Inorganic Soil Conditioners',
            'columns' => ['id','trade_name','supplier_id','updated_at','created_at','retail_price','status_id']
        ],
    ];

    $combinedData = collect();

    foreach ($tablesToShow as $tableName => $info) {
        if (!Schema::hasTable($tableName)) continue;

        if ($selectedCategory && Str::slug($info['name'], '_') !== $selectedCategory) continue;

        $availableColumns = array_intersect($info['columns'], Schema::getColumnListing($tableName));

        // ✅ id → table_id (Blade compatible)
        $selectColumns = [];
        foreach ($availableColumns as $col) {
            $selectColumns[] = ($col === 'id') ? "$tableName.id as table_id" : "$tableName.$col";
        }

        $query = DB::table($tableName)->select($selectColumns);

        // supplier + country join
        if (in_array('supplier_id', $availableColumns)) {
            $query->leftJoin('suppliers', "$tableName.supplier_id", '=', 'suppliers.id')
                  ->leftJoin('countries', 'suppliers.country_id', '=', 'countries.id')
                  ->addSelect(
                      'suppliers.name as supplier_name',
                      'suppliers.country_id',
                      'countries.name as country_name'
                  )
                  ->where('suppliers.country_id', $selectedCountry);
        }

        // status != 4
        if (in_array('status_id', $availableColumns)) {
            $query->where("$tableName.status_id", '!=', 4);
        }

        // search filter
        if ($search) {
            $query->where(function ($q) use ($availableColumns, $tableName, $search) {
                foreach ($availableColumns as $col) {
                    $q->orWhere("$tableName.$col", 'LIKE', "%$search%");
                }
            });
        }

        // price filter
        if ($minPrice || $maxPrice) {
            $priceColumns = [
                'wholesale_price','semiwholesale_price','retail_price',
                'wholesalePrice','semiwholesalePrice','retailPrice',
                'fertilizer_retail_price','afretailPrice'
            ];

            $query->where(function ($q) use ($priceColumns, $availableColumns, $tableName, $minPrice, $maxPrice) {
                foreach ($priceColumns as $pcol) {
                    if (!in_array($pcol, $availableColumns)) continue;
                    if ($minPrice) $q->orWhere("$tableName.$pcol", '>=', $minPrice);
                    if ($maxPrice) $q->orWhere("$tableName.$pcol", '<=', $maxPrice);
                }
            });
        }

        // status filter
        if ($statusFilter && in_array('status_id', $availableColumns)) {
            $query->where("$tableName.status_id", $statusFilter);
        }

        // yield filter (only seeds)
        if ($yieldFilter && $tableName === 'seed_forms' && in_array('yield', $availableColumns)) {
            $query->where("$tableName.yield", 'LIKE', "%$yieldFilter%");
        }

        $data = $query->orderByDesc("$tableName.id")
            ->take(10)
            ->get()
            ->map(function ($item) use ($info, $tableName) {
                $item->seed = $info['name'];
                $item->table_name = $tableName;
                return $item;
            });

        $combinedData = $combinedData->merge($data);
    }

    $combinedData = $combinedData->sortByDesc('table_id')->values();
    $dropdownCounts = $counts;

    return view('countryadmin.dashboard', compact(
        'user',
        'counts',
        'dropdownCounts',
        'combinedData',
        'selectedCategory',
        'selectedCountry',
        'countries',
        'lang'
    ));
}



// public function countryDashboard(Request $request)
// {
//     // ✅ Get Admin ID from session
//     $admin_id = session('masteradmin_id'); 
//     if (!$admin_id) {
//         return redirect()->route('masteradmin.login.form')
//                          ->with('error', __('dashboard.please_login_first'));
//     }

//     $user = MasterAdmin::find($admin_id);

//     // 🌎 Language Setup
//     $lang = session('lang', 'en');
//     if ($request->has('lang')) {
//         $lang = $request->lang;
//         session(['lang' => $lang]);
//     }
//     App::setLocale($lang);
//     $langId = $lang === 'fr' ? 2 : 1;

//     // Filters
//     $selectedCategory = $request->get('category');
//     $search           = $request->get('search');
//     $minPrice         = $request->get('min_price');
//     $maxPrice         = $request->get('max_price');
//     $yieldFilter      = $request->get('yield');
//     $statusFilter     = $request->get('status');

//     // ✅ Country fixed (logged-in admin)
//     $selectedCountry = $user->country_id;

//     // Seed Items (counts)
//     $seedItems = DB::table('seed')
//         ->where('language_id', $langId)
//         ->get(['id', 'name']);

//     $countries = DB::table('countries')->pluck('name', 'id')->toArray();

//     // Table Map
//     $tableMap = [
//         'Seeds' => 'seed_forms',
//         'Animal Feed' => 'animal_feeds',
//         'Biostimulants' => 'bio_stimulants',
//         'Inorganic Soil Conditioners' => 'inorganic_soil_conditioners',
//         'Mineral Fertilizers' => 'mineral_fertilizers',
//         'Organic Amendments' => 'organic_amendments',
//         'Synthetic Pesticides' => 'synthetic_pesticides',
//         'Veterinary Products' => 'veterinary_products',
//     ];

//     // Counts (country based)
//     $counts = [];
//     foreach ($seedItems as $seed) {
//         $tableName = $tableMap[$seed->name] ?? null;

//         if ($tableName && Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'supplier_id')) {
//             $supplierIds = DB::table('suppliers')
//                 ->where('country_id', $selectedCountry)
//                 ->pluck('id')
//                 ->toArray();

//             $count = DB::table($tableName)
//                 ->when(!empty($supplierIds), fn($q) => $q->whereIn('supplier_id', $supplierIds))
//                 ->where('status_id', '!=', 4)
//                 ->count();
//         } else {
//             $count = 0;
//         }

//         $counts[] = [
//             'name' => $seed->name,
//             'count' => $count,
//         ];
//     }

//     // ✅ SAME tables as MASTER dashboard
//     $tablesToShow = [
//         'veterinary_products' => [
//             'name' => 'Veterinary Products',
//             'columns' => ['id','product_name','supplier_id','updated_at','retail_price','status_id','created_at']
//         ],
//         'synthetic_pesticides' => [
//             'name' => 'Synthetic Pesticides',
//             'columns' => ['id','trade_name','supplier_id','updated_at','created_at','retail_price','status_id']
//         ],
//         'organic_amendments' => [
//             'name' => 'Organic Amendments',
//             'columns' => ['id','trade_name','supplier_id','updated_at','created_at','retail_price','status_id']
//         ],
//         'seed_forms' => [
//             'name' => 'Seeds',
//             'columns' => ['id','cropName','supplier_id','updated_at','created_at','retailPrice','status_id']
//         ],
//         'mineral_fertilizers' => [
//             'name' => 'Mineral Fertilizers',
//             'columns' => ['id','supplier_id','updated_at','created_at','fertilizer_retail_price','status_id']
//         ],
//         'bio_stimulants' => [
//             'name' => 'Biostimulants',
//             'columns' => ['id','trade_name','supplier_id','updated_at','created_at','retail_price','status_id']
//         ],
//         'animal_feeds' => [
//             'name' => 'Animal Feed',
//             'columns' => ['id','Typeoffeed','supplier_id','updated_at','created_at','afretailPrice','status_id']
//         ],
//         'inorganic_soil_conditioners' => [
//             'name' => 'Inorganic Soil Conditioners',
//             'columns' => ['id','trade_name','supplier_id','updated_at','created_at','retail_price','status_id']
//         ],
//     ];
//     $combinedData = collect();

//     foreach ($tablesToShow as $tableName => $info) {
//         if (!Schema::hasTable($tableName)) continue;

//         if ($selectedCategory && Str::slug($info['name'], '_') !== $selectedCategory) continue;

//         $availableColumns = array_intersect($info['columns'], Schema::getColumnListing($tableName));

//         // ✅ id → table_id (Blade compatible)
//         $selectColumns = [];
//         foreach ($availableColumns as $col) {
//             $selectColumns[] = ($col === 'id')
//                 ? "$tableName.id as table_id"
//                 : "$tableName.$col";
//         }

//         $query = DB::table($tableName)->select($selectColumns);

//         // supplier + country join
//         if (in_array('supplier_id', $availableColumns)) {
//             $query->leftJoin('suppliers', "$tableName.supplier_id", '=', 'suppliers.id')
//                   ->leftJoin('countries', 'suppliers.country_id', '=', 'countries.id')
//                   ->addSelect(
//                       'suppliers.name as supplier_name',
//                       'suppliers.country_id',
//                       'countries.name as country_name'
//                   )
//                   ->where('suppliers.country_id', $selectedCountry);
//         }

//         // status != 4
//         if (in_array('status_id', $availableColumns)) {
//             $query->where("$tableName.status_id", '!=', 4);
//         }

//         // search
//         if ($search) {
//             $query->where(function ($q) use ($availableColumns, $tableName, $search) {
//                 foreach ($availableColumns as $col) {
//                     $q->orWhere("$tableName.$col", 'LIKE', "%$search%");
//                 }
//             });
//         }

//         // price filter
//         if ($minPrice || $maxPrice) {
//             $priceColumns = [
//                 'wholesale_price','semiwholesale_price','retail_price',
//                 'wholesalePrice','semiwholesalePrice','retailPrice',
//                 'fertilizer_retail_price','afretailPrice'
//             ];

//             $query->where(function ($q) use ($priceColumns, $availableColumns, $tableName, $minPrice, $maxPrice) {
//                 foreach ($priceColumns as $pcol) {
//                     if (!in_array($pcol, $availableColumns)) continue;
//                     if ($minPrice) $q->orWhere("$tableName.$pcol", '>=', $minPrice);
//                     if ($maxPrice) $q->orWhere("$tableName.$pcol", '<=', $maxPrice);
//                 }
//             });
//         }

//         // status filter
//         if ($statusFilter && in_array('status_id', $availableColumns)) {
//             $query->where("$tableName.status_id", $statusFilter);
//         }

//         // yield (only seeds)
//         if ($yieldFilter && $tableName === 'seed_forms' && in_array('yield', $availableColumns)) {
//             $query->where("$tableName.yield", 'LIKE', "%$yieldFilter%");
//         }

//         $data = $query->orderByDesc("$tableName.id")
//             ->take(10)
//             ->get()
//             ->map(function ($item) use ($info, $tableName) {
//                 $item->seed = $info['name'];
//                 $item->table_name = $tableName;
//                 return $item;
//             });

//         $combinedData = $combinedData->merge($data);
//     }

//     $combinedData = $combinedData->sortByDesc('table_id')->values();
//     $dropdownCounts = $counts;

//     return view('countryadmin.dashboard', compact(
//         'user',
//         'counts',
//         'dropdownCounts',
//         'combinedData',
//         'selectedCategory',
//         'selectedCountry',
//         'countries',
//         'lang'
//     ));
// }


// public function countryDashboard(Request $request)
// {
//     // ✅ Get Admin ID from session
//     $admin_id = session('masteradmin_id'); 
//     if (!$admin_id) {
//         return redirect()->route('masteradmin.login.form')
//                          ->with('error', __('dashboard.please_login_first'));
//     }

//     $user = MasterAdmin::find($admin_id);

//     // 🌎 Language Setup
//     $lang = session('lang', 'en');
//     if ($request->has('lang')) {
//         $lang = $request->lang;
//         session(['lang' => $lang]);
//     }
//     App::setLocale($lang);

//     $langId = $lang === 'fr' ? 2 : 1;

//     // Filters
//     $selectedCategory = $request->get('category');  // category slug
//     $search           = $request->get('search');    // search text
//     $minPrice         = $request->get('min_price');
//     $maxPrice         = $request->get('max_price');
//     $yieldFilter      = $request->get('yield');
//     $statusFilter     = $request->get('status');

//     // COUNTRY FILTER: always use logged-in user's country
//     $selectedCountry = $user->country_id;

//     // Seed Items (for counts dropdown)
//     $seedItems = DB::table('seed')
//         ->where('language_id', $langId)
//         ->get(['id', 'name']);

//     // Countries List (for dropdowns, optional)
//     $countries = DB::table('countries')->pluck('name','id')->toArray();

//     // Table Map
//     $tableMap = [
//         'Seeds' => 'seed_forms',
//         'Animal Feed' => 'animal_feeds',
//         'Biostimulants' => 'bio_stimulants',
//         'Inorganic Soil Conditioners' => 'inorganic_soil_conditioners',
//         'Mineral Fertilizers' => 'mineral_fertilizers',
//         'Organic Amendments' => 'organic_amendments',
//         'Synthetic Pesticides' => 'synthetic_pesticides',
//         'Veterinary Products' => 'veterinary_products',
//     ];

//     // Count per category (exclude status_id = 4)
//     $counts = [];
//     foreach ($seedItems as $seed) {
//         $tableName = $tableMap[$seed->name] ?? null;
//         if ($tableName && Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'supplier_id')) {
//             // Only count products from this country
//             $supplierIds = DB::table('suppliers')
//                              ->where('country_id', $selectedCountry)
//                              ->pluck('id')
//                              ->toArray();

//             $count = DB::table($tableName)
//                        ->when(!empty($supplierIds), fn($q) => $q->whereIn('supplier_id', $supplierIds))
//                        ->where('status_id', '!=', 4)
//                        ->count();
//         } else {
//             $count = 0;
//         }
//         $counts[] = [
//             'name' => $seed->name,
//             'count' => $count,
//         ];
//     }

//     // Tables To Show (with columns)
//     $tablesToShow = [
//          'veterinary_products' => [
//             'name' => 'Veterinary Products',
//             'columns' => ['product_name','manufacturing_lab','registration_number','route_of_administration','wholesale_price','semiwholesale_price','retail_price','status_id']
//         ],
//         'synthetic_pesticides' => [
//             'name' => 'Synthetic Pesticides',
//             'columns' => ['trade_name','active_ingredient','registration_number','other_function','wholesale_price','semiwholesale_price','retail_price','status_id']
//         ],
//         'organic_amendments' => [
//             'name' => 'Organic Amendments',
//             'columns' => ['organic_type','trade_name','bio_label','cn_ratio','wholesale_price','semiwholesale_price','retail_price','status_id']
//         ],
//         'seed_forms' => [
//             'name' => 'Seeds',
//             'columns' => ['cropName','verityName','registrationNumber','fruitColor','wholesalePrice','semiwholesalePrice','retailPrice','status_id']
//         ],
//         'mineral_fertilizers' => [
//             'name' => 'Mineral Fertilizers',
//             'columns' => ['trade_name','fertilizer_registration','mo','application_rate','fertilizer_wholesale_price','fertilizer_semiwholesale_price','fertilizer_retail_price','status_id']
//         ],
//         'bio_stimulants' => [
//             'name' => 'Biostimulants',
//             'columns' => ['physical_form','biostimulant_product','p2','wholesale_price','semiwholesale_price','retail_price','k2','status_id']
//         ],
//         'animal_feeds' => [
//             'name' => 'Animal Feed',
//             'columns' => ['Typeoffeed','afrm','afEnergy','title','afWholesalePrice','afsemiwholesalePrice','afretailPrice','status_id']
//         ],
//         'inorganic_soil_conditioners' => [
//             'name' => 'Inorganic Soil Conditioners',
//             'columns' => ['trade_name','raw_material','function','other','wholesale_price','semiwholesale_price','retail_price','status_id']
//         ],
//     ];

//     // Fetch Final Data (exclude status_id = 4)
//     $combinedData = collect();

//     foreach ($tablesToShow as $tableName => $info) {
//         if (!Schema::hasTable($tableName)) continue;

//         // Category filter
//         if ($selectedCategory && Str::slug($info['name'], '_') !== $selectedCategory) continue;

//         $availableColumns = array_intersect($info['columns'], Schema::getColumnListing($tableName));
//         $query = DB::table($tableName)->select(array_merge(['id'], $availableColumns));

//         // Exclude status 4
//         if (in_array('status_id', $availableColumns)) {
//             $query->where('status_id', '!=', 4);
//         }

//         // Country filter
//         if (Schema::hasColumn($tableName, 'supplier_id')) {
//             $supplierIds = DB::table('suppliers')
//                               ->where('country_id', $selectedCountry)
//                               ->pluck('id')
//                               ->toArray();

//             if (!empty($supplierIds)) {
//                 $query->whereIn('supplier_id', $supplierIds);
//             } else {
//                 $query->whereRaw('0=1');
//             }
//         }

//         // Search filter
//         if ($search) {
//             $query->where(function($q) use ($availableColumns, $search) {
//                 foreach ($availableColumns as $col) {
//                     $q->orWhere($col,'LIKE',"%$search%");
//                 }
//             });
//         }

//         // Price filter
//         if ($minPrice || $maxPrice) {
//             $query->where(function($q) use ($availableColumns, $minPrice, $maxPrice) {
//                 $priceColumns = [
//                     'wholesale_price','semiwholesale_price','retail_price',
//                     'wholesalePrice','semiwholesalePrice','retailPrice',
//                     'fertilizer_wholesale_price','fertilizer_semiwholesale_price','fertilizer_retail_price',
//                     'afWholesalePrice','afsemiwholesalePrice','afretailPrice',
//                 ];
//                 foreach ($priceColumns as $pcol) {
//                     if (!in_array($pcol, $availableColumns)) continue;
//                     if ($minPrice) $q->orWhere($pcol, '>=', $minPrice);
//                     if ($maxPrice) $q->orWhere($pcol, '<=', $maxPrice);
//                 }
//             });
//         }

//         // Status filter
//         if (!empty($statusFilter) && in_array('status_id', $availableColumns)) {
//             $query->where('status_id', $statusFilter);
//         }

//         // Yield filter (only seed_forms)
//         if ($yieldFilter && $tableName === 'seed_forms' && in_array('yield', $availableColumns)) {
//             $query->where('yield', 'LIKE', "%{$yieldFilter}%");
//         }

//         $data = $query->orderByDesc('id')->take(10)->get()->map(function($item) use ($info, $tableName) {
//             $item->seed = $info['name'];
//             $item->table_name = $tableName;
//             return $item;
//         });

//         $combinedData = $combinedData->merge($data);
//     }

//     $combinedData = $combinedData->sortByDesc('id')->values();
// $dropdownCounts = $counts; // add this

// return view('countryadmin.dashboard', compact(
//     'user',
//     'counts',
//     'dropdownCounts', // now available for the Blade
//     'combinedData',
//     'selectedCategory',
//     'selectedCountry',
//     'countries',
//     'lang'
// ));
// }



    public function uploadRecord($table, $id)
{
    $record = DB::table($table)->where('id', $id)->first();

    if (!$record) {
        abort(404, 'Record not found');
    }

    $tableNames = [
    'seed_forms'            => 'Seeds',
    'animal_feeds'          => 'Animal Feed',
    'bio_stimulants'        => 'Biostimulants',
    'inorganic_soil_conditioners' => 'Inorganic Soil Conditioners',
    'mineral_fertilizers'   => 'Mineral Fertilizers',
    'organic_amendments'    => 'Organic Amendments',
    'synthetic_pesticides'  => 'Synthetic Pesticides',
    'veterinary_products'   => 'Veterinary Products',
];

$displayName = $tableNames[$table] ?? $table;

return view('admin.upload', compact('record', 'table', 'displayName'));
}

// Handle uploaded file and insert into allcomplementary
public function uploadFile(Request $request, $table, $id)
{
    // ✅ Validate file and title
    $request->validate([
        'file'  => 'required|file|max:10240', // 10MB
        'title' => 'required|string|max:255', // new title field
    ]);

    // Ensure folder exists: public/complementryfile
    $targetFolder = public_path('complementryfile');
    if (!file_exists($targetFolder)) {
        mkdir($targetFolder, 0755, true);
    }

    // Store file with unique name
    $file = $request->file('file');
    $ext = $file->getClientOriginalExtension();
    $uniqueName = Str::random(16) . '_' . time() . '.' . $ext;
    $file->move($targetFolder, $uniqueName);

    // Relative path for database
    $relativePath = 'complementryfile/' . $uniqueName;

    // Fetch source record
    $record = DB::table($table)->where('id', $id)->first();
    if (!$record) {
        @unlink($targetFolder . DIRECTORY_SEPARATOR . $uniqueName);
        return redirect()->back()->withErrors('Source record not found.');
    }

    // Determine product_id and country_id
    $productId = $record->product_id ?? null;
    $countryId = $record->country_id ?? ($record->country ?? ($record->countryCode ?? null));

    // Insert into allcomplementary with title
    $insertData = [
        'product_id'      => $productId,
        'table_record_id' => $id,
        'table_name'      => $table,
        'title'           => $request->input('title'), // added title
        'country_id'      => $countryId,
        'file_path'       => $relativePath,
        'created_at'      => Carbon::now(),
        'updated_at'      => Carbon::now(),
    ];

    DB::table('allcomplementary')->insert($insertData);

    // Optionally update source table status_id => 2
    try {
        if (DB::getSchemaBuilder()->hasColumn($table, 'status_id')) {
            DB::table($table)->where('id', $id)->update(['status_id' => 2]);
        }
    } catch (\Exception $e) {
        // ignore
    }

    return redirect()->route('masteradmin.dashboard')
                     ->with('success', 'File uploaded and record saved successfully!');
}

  public function countryUploadRecord($table, $id)
    {
        $record = DB::table($table)->where('id', $id)->first();
        if (!$record) {
            abort(404, 'Record not found');
        }

        $tableNames = [
            'seed_forms'                     => 'Seeds',
            'animal_feeds'                   => 'Animal Feed',
            'bio_stimulants'                 => 'Biostimulants',
            'inorganic_soil_conditioners'    => 'Inorganic Soil Conditioners',
            'mineral_fertilizers'            => 'Mineral Fertilizers',
            'organic_amendments'             => 'Organic Amendments',
            'synthetic_pesticides'           => 'Synthetic Pesticides',
            'veterinary_products'            => 'Veterinary Products',
        ];

        $displayName = $tableNames[$table] ?? $table;
        $loggedInCountry = Auth::user()->country_id ?? null;

        return view('countryadmin.countryupload', compact('record', 'table', 'displayName', 'loggedInCountry'));
    }

    /**
     * Handle file upload for a country-specific record
     */
    public function countryUploadFile(Request $request, $table, $id)
    {
        $request->validate([
            'file'  => 'required|file|max:10240', // 10MB
            'title' => 'required|string|max:255',
        ]);

        $targetFolder = public_path('complementryfile');
        if (!file_exists($targetFolder)) {
            mkdir($targetFolder, 0755, true);
        }

        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();
        $uniqueName = Str::random(16) . '_' . time() . '.' . $ext;
        $file->move($targetFolder, $uniqueName);

        $relativePath = 'complementryfile/' . $uniqueName;

        $record = DB::table($table)->where('id', $id)->first();
        if (!$record) {
            @unlink($targetFolder . DIRECTORY_SEPARATOR . $uniqueName);
            return redirect()->back()->withErrors('Source record not found.');
        }

        // Country: always use logged-in user's country
        $countryId = Auth::user()->country_id ?? null;
        $productId = $record->product_id ?? null;

        DB::table('allcomplementary')->insert([
            'product_id'      => $productId,
            'table_record_id' => $id,
            'table_name'      => $table,
            'title'           => $request->input('title'),
            'country_id'      => $countryId,
            'file_path'       => $relativePath,
            'created_at'      => Carbon::now(),
            'updated_at'      => Carbon::now(),
        ]);

        try {
            if (Schema::hasColumn($table, 'status_id')) {
                DB::table($table)->where('id', $id)->update(['status_id' => 2]);
            }
        } catch (\Exception $e) {
            // ignore
        }

        // Redirect to country dashboard after upload
        return redirect()->route('countryadmin.dashboard')
                         ->with('success', 'File uploaded and record saved successfully!');
    }

}
