<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usertype;
use App\Models\User;
use App\Models\UserTranslation;
use App\Models\UserCreationLog;
use App\Models\Language;
use App\Models\Country;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Seed;
use App\Models\MasterAdmin;
use App\Models\Supplier;
use App\Models\Document;

use App\Models\PrivacyPolicy;
use App\Models\TermsCondition;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema; // ← Add this
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;
use App\Imports\ProductImport;

class UserController extends Controller
{
    public function dashboard(Request $request)
{
    // ✅ Admin Session
    $admin_id = session('masteradmin_id');
    if (!$admin_id) {
        return redirect()->route('masteradmin.login.form')
            ->with('error', __('dashboard.please_login_first'));
    }

    $user = MasterAdmin::find($admin_id);

    // 🌎 Language
    $lang = session('lang', 'en');
    if ($request->has('lang')) {
        $lang = $request->lang;
        session(['lang' => $lang]);
    }
    App::setLocale($lang);

    // ================= FILTERS =================
    $selectedCategory = $request->get('category');
    $selectedCountry  = $request->get('country');
    $search           = $request->get('search');
    $statusFilter     = $request->get('status');

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
            $counts[] = ['slug' => $info['slug'], 'count' => 0];
            continue;
        }

        $q = DB::table($tableName)
            ->where('status_id', '>', 0)     // ❌ status_id = 0 hide
            ->where('status_id', '!=', 4);   // deleted

        // Parent / Child logic
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
            'slug'  => $info['slug'],
            'count' => $q->count(),
        ];
    }

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
            ->where("$tableName.status_id", '>', 0)   // ❌ status 0 hide
            ->where("$tableName.status_id", '!=', 4);

        // Supplier + Country
        if (in_array('supplier_id', $availableColumns)) {
            $query->leftJoin('suppliers', "$tableName.supplier_id", '=', 'suppliers.id')
                  ->leftJoin('countries', 'suppliers.country_id', '=', 'countries.id')
                  ->addSelect(
                      'suppliers.name as supplier_name',
                      'countries.name as country_name',
                      'suppliers.country_id'
                  );
        }

        // Parent / Child logic
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

        // Filters
        if ($selectedCountry) {
            $query->where('suppliers.country_id', $selectedCountry);
        }

        if ($search) {
            $query->where(function ($q) use ($availableColumns, $search, $tableName) {
                foreach ($availableColumns as $col) {
                    $q->orWhere("$tableName.$col", 'LIKE', "%{$search}%");
                }
            });
        }

        if ($statusFilter) {
            $query->where("$tableName.status_id", $statusFilter);
        }

        $data = $query->orderByDesc("$tableName.id")
            ->take(10)
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

    $combinedData = $combinedData->sortByDesc('table_id')->values();

    return view('admin.dashboard', compact(
        'user',
        'counts',
        'combinedData',
        'selectedCategory',
        'selectedCountry',
        'countries',
        'lang'
    ));
}




public function productAll(Request $request)
{
    // 🌎 Language
    $lang = session('lang', 'en');
    if ($request->has('lang')) {
        $lang = $request->lang;
        session(['lang' => $lang]);
    }
    App::setLocale($lang);

    // ⭐ Filters
    $minPrice  = $request->get('min_price');
    $maxPrice  = $request->get('max_price');
    $minYield  = $request->get('min_yield');
    $maxYield  = $request->get('max_yield');
    $status    = $request->get('status');
    $search    = $request->get('search');
    $category  = $request->get('category'); // slug
    $countryId = $request->get('country');

    // ================= CATEGORY → TABLE MAP =================
    $tableMap = [
        'seeds'                       => 'seed_forms',
        'animal_feeds'                => 'animal_feeds',
        'bio_stimulants'              => 'bio_stimulants',
        'inorganic_soil_conditioners' => 'inorganic_soil_conditioners',
        'mineral_fertilizers'         => 'mineral_fertilizers',
        'organic_amendments'          => 'organic_amendments',
        'synthetic_pesticides'        => 'synthetic_pesticides',
        'veterinary_products'         => 'veterinary_products',
    ];

    // ✅ Default category
    if (!$category) {
        $category = 'veterinary_products';
    }

    // ================= COUNT CARDS (SAME AS DASHBOARD) =================
    $counts = [];

    foreach ($tableMap as $slug => $table) {

        if (!Schema::hasTable($table)) {
            $counts[] = [
                'name'  => ucwords(str_replace('_', ' ', $slug)),
                'slug'  => $slug,
                'count' => 0
            ];
            continue;
        }

        $q = DB::table($table)
            ->where('status_id', '>', 0)   // ❌ status 0 hide
            ->where('status_id', '!=', 4); // deleted

        // 🔑 Parent / Child logic
        if (Schema::hasColumn($table, 'parent_id')) {
            $q->where(function ($subQ) use ($table) {
                $subQ->whereNotNull("$table.parent_id")
                     ->orWhereNotIn("$table.id", function ($sub) use ($table) {
                         $sub->select('parent_id')
                             ->from($table)
                             ->whereNotNull('parent_id');
                     });
            });
        }

        $counts[] = [
            'name'  => ucwords(str_replace('_', ' ', $slug)),
            'slug'  => $slug,
            'count' => $q->count()
        ];
    }

    // ================= SELECTED TABLE =================
    $selectedTable = $tableMap[$category] ?? null;
    $tablesToFetch = $selectedTable ? [$selectedTable] : array_values($tableMap);

    $allData = collect();

    foreach ($tablesToFetch as $table) {

        if (!Schema::hasTable($table)) continue;

        $query = DB::table($table)
            ->where('status_id', '>', 0)
            ->where('status_id', '!=', 4);

        // 🔑 Parent / Child logic (SAME AS DASHBOARD)
        if (Schema::hasColumn($table, 'parent_id')) {
            $query->where(function ($q) use ($table) {
                $q->whereNotNull("$table.parent_id")
                  ->orWhereNotIn("$table.id", function ($sub) use ($table) {
                      $sub->select('parent_id')
                          ->from($table)
                          ->whereNotNull('parent_id');
                  });
            });
        }

        // 🌍 Country filter
        if ($countryId && Schema::hasColumn($table, 'supplier_id')) {
            $supplierIds = DB::table('suppliers')
                ->where('country_id', $countryId)
                ->pluck('id')
                ->toArray();

            $supplierIds
                ? $query->whereIn('supplier_id', $supplierIds)
                : $query->whereRaw('0 = 1');
        }

        // 🔍 Search
        if ($search) {
            $query->where(function ($q) use ($table, $search) {
                foreach (Schema::getColumnListing($table) as $col) {
                    $q->orWhere($col, 'LIKE', "%{$search}%");
                }
            });
        }

        // 💰 Price
        if (Schema::hasColumn($table, 'price')) {
            if ($minPrice !== null) $query->where('price', '>=', $minPrice);
            if ($maxPrice !== null) $query->where('price', '<=', $maxPrice);
        }

        // 🌾 Yield (Seeds only)
        if ($table === 'seed_forms' && Schema::hasColumn($table, 'yield')) {
            if ($minYield !== null) $query->where('yield', '>=', $minYield);
            if ($maxYield !== null) $query->where('yield', '<=', $maxYield);
        }

        // 🟡 Status filter (optional UI filter)
        if ($status && Schema::hasColumn($table, 'status_id')) {
            $query->where('status_id', $status);
        }

        $data = $query->get()->map(function ($row) use ($table) {
            $row->table_name = $table;
            return $row;
        });

        $allData = $allData->merge($data);
    }

    // ================= PAGINATION =================
    $perPage = 10;
    $page = request()->get('page', 1);

    $pagedData = $allData
        ->slice(($page - 1) * $perPage, $perPage)
        ->values();

    $tableData = new \Illuminate\Pagination\LengthAwarePaginator(
        $pagedData,
        $allData->count(),
        $perPage,
        $page,
        ['path' => request()->url(), 'query' => request()->query()]
    );

    $countries = DB::table('suppliers')
        ->pluck('country_id')
        ->unique()
        ->toArray();

    return view('admin.products_all', compact(
        'tableData',
        'counts',
        'category',
        'countries',
        'lang'
    ));
}

// public function productAll(Request $request) 24-12-25
// {
//     // 🌎 Language
//     $lang = session('lang', 'en');
//     if ($request->has('lang')) {
//         $lang = $request->lang;
//         session(['lang' => $lang]);
//     }
//     App::setLocale($lang);

//     // ⭐ Filters
//     $minPrice  = $request->get('min_price');
//     $maxPrice  = $request->get('max_price');
//     $minYield  = $request->get('min_yield');
//     $maxYield  = $request->get('max_yield');
//     $status    = $request->get('status');
//     $search    = $request->get('search');
//     $category  = $request->get('category'); // slug
//     $countryId = $request->get('country');

//     // ================= CATEGORY → TABLE MAP =================
//     $tableMap = [
//         'seeds'                       => 'seed_forms',
//         'animal_feeds'                => 'animal_feeds',
//         'bio_stimulants'              => 'bio_stimulants',
//         'inorganic_soil_conditioners' => 'inorganic_soil_conditioners',
//         'mineral_fertilizers'         => 'mineral_fertilizers',
//         'organic_amendments'          => 'organic_amendments',
//         'synthetic_pesticides'        => 'synthetic_pesticides',
//         'veterinary_products'         => 'veterinary_products',
//     ];

//     // ✅ Default category
//     if (!$category) {
//         $category = 'veterinary_products';
//     }

//     // ================= COUNT CARDS =================
//     $counts = [];

//     foreach ($tableMap as $slug => $table) {

//         if (\Schema::hasTable($table)) {
//             $q = \DB::table($table);
//             if (\Schema::hasColumn($table, 'status_id')) {
//                 $q->where('status_id', '!=', 4);
//             }
//             $count = $q->count();
//         } else {
//             $count = 0;
//         }

//         $counts[] = [
//             'name'  => ucwords(str_replace('_', ' ', $slug)), // ✅ FIX
//             'slug'  => $slug,                                 // ✅ REAL SLUG
//             'count' => $count
//         ];
//     }

//     // ================= SELECTED TABLE =================
//     $selectedTable = $tableMap[$category] ?? null;
//     $tablesToFetch = $selectedTable ? [$selectedTable] : array_values($tableMap);

//     $allData = collect();

//     foreach ($tablesToFetch as $table) {
//         if (!\Schema::hasTable($table)) continue;

//         $query = \DB::table($table);

//         if (\Schema::hasColumn($table, 'status_id')) {
//             $query->where('status_id', '!=', 4);
//         }

//         // 🌍 Country filter
//         if ($countryId && \Schema::hasColumn($table, 'supplier_id')) {
//             $supplierIds = \DB::table('suppliers')
//                 ->where('country_id', $countryId)
//                 ->pluck('id')
//                 ->toArray();

//             $supplierIds
//                 ? $query->whereIn('supplier_id', $supplierIds)
//                 : $query->whereRaw('0 = 1');
//         }

//         // 🔍 Search
//         if ($search) {
//             $query->where(function ($q) use ($table, $search) {
//                 foreach (\Schema::getColumnListing($table) as $col) {
//                     $q->orWhere($col, 'like', "%{$search}%");
//                 }
//             });
//         }

//         // 💰 Price
//         if (\Schema::hasColumn($table, 'price')) {
//             if ($minPrice !== null) $query->where('price', '>=', $minPrice);
//             if ($maxPrice !== null) $query->where('price', '<=', $maxPrice);
//         }

//         // 🌾 Yield (Seeds only)
//         if ($table === 'seed_forms' && \Schema::hasColumn($table, 'yield')) {
//             if ($minYield !== null) $query->where('yield', '>=', $minYield);
//             if ($maxYield !== null) $query->where('yield', '<=', $maxYield);
//         }

//         // 🟡 Status filter
//         if ($status && \Schema::hasColumn($table, 'status_id')) {
//             $query->where('status_id', $status);
//         }

//         $data = $query->get()->map(function ($row) use ($table) {
//             $row->table_name = $table;
//             return $row;
//         });

//         $allData = $allData->merge($data);
//     }

//     // ================= PAGINATION =================
//     $perPage = 10;
//     $page = request()->get('page', 1);

//     $pagedData = $allData
//         ->slice(($page - 1) * $perPage, $perPage)
//         ->values();

//     $tableData = new \Illuminate\Pagination\LengthAwarePaginator(
//         $pagedData,
//         $allData->count(),
//         $perPage,
//         $page,
//         ['path' => request()->url(), 'query' => request()->query()]
//     );

//     $countries = \DB::table('suppliers')
//         ->pluck('country_id')
//         ->unique()
//         ->toArray();

//     return view('admin.products_all', compact(
//         'tableData',
//         'counts',
//         'category',
//         'countries',
//         'lang'
//     ));
// }


 

 public function create(Request $request)
{
    // 🌎 Language handling
    $lang = session('lang', 'en');
    if ($request->has('lang')) {
        $lang = $request->lang;
        session(['lang' => $lang]);
    }
    App::setLocale($lang);

    // Fetch all usertypes, countries, languages
    $usertypes = \App\Models\Usertype::all();
    $countries = \App\Models\Country::all();
    $languages = \App\Models\Language::all();

    return view('admin.farmer.create_user', compact('usertypes', 'countries', 'languages', 'lang'));
}




public function store(Request $request)
{
    $request->validate([
        // 'username' is optional
        'name'        => 'required',
        'email'       => 'required|email|unique:users,email',
        'usertype_id' => 'required',
        'country_id'  => 'required',
        'phone'       => 'required'
    ]);

    // Default language ID (for example English = 1)
    $defaultLangId = 1;

    \App\Models\User::create([
        'username'    => $request->username ?? null, // optional username
        'name'        => $request->name,
        'email'       => $request->email,
        'usertype_id' => $request->usertype_id,
        'country_id'  => $request->country_id,
        'phone'       => $request->phone,
        'language_id' => $defaultLangId, // default language saved
        'password'    => bcrypt('123456'), // default password
    ]);

    return redirect('/admin/users')->with('success', 'User created successfully! Default password: 123456');
}

public function edit($id)
{
    $user = \App\Models\User::findOrFail($id);
    $usertypes = \App\Models\Usertype::all();
    $countries = \App\Models\Country::all();

    // Default language ID (use current session lang or existing user lang)
    $lang = session('lang', 'en');
    App::setLocale($lang);
    $defaultLangId = $user->language_id ?? 1;

    return view('admin.farmer.edit_user', compact('user', 'usertypes', 'countries', 'lang', 'defaultLangId'));
}


public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->status_id = 2; // Approved
        $user->save();

        return redirect()->back()->with('success', 'User approved successfully!');
    }

    // Reject user
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reject_message' => 'required|string|max:500',
        ]);

        $user = User::findOrFail($id);
        $user->status_id = 3; // Denied
        $user->reject_message = $request->reject_message;
        $user->save();

        return redirect()->back()->with('success', 'User rejected successfully!');
    }

public function translateForm(Request $request)
{
    $langCode = $request->input('lang_code');
    $tr = new \Stichoza\GoogleTranslate\GoogleTranslate($langCode);

    // Words for form labels
    $texts = [
        'Create User', 'Username', 'Name', 'Email', 'Password',
        'User Type', 'Country', 'Language', 'Phone',
        'Select User Type', 'Select Country', 'Select Language', 'Create'
    ];

    $translations = [];
    foreach ($texts as $text) {
        $translations[$text] = $tr->translate($text);
    }

    // 👇 Translate User Types
    $userTypes = \App\Models\Usertype::pluck('type_name', 'id')->toArray();
    $translatedUserTypes = [];
    foreach ($userTypes as $id => $name) {
        $translatedUserTypes[$id] = $tr->translate($name);
    }

    // 👇 Translate Countries
    $countries = \App\Models\Country::pluck('name', 'id')->toArray();
    $translatedCountries = [];
    foreach ($countries as $id => $name) {
        $translatedCountries[$id] = $tr->translate($name);
    }

    // Include both in response
    $translations['UserTypes'] = $translatedUserTypes;
    $translations['Countries'] = $translatedCountries;

    return response()->json($translations);
}





public function showLoginForm(Request $request)
{
    // Get all user types
    $usertypes = Usertype::all();

    // Get selected language from session or default to 'en'
    $lang_code = Session::get('lang_code', 'en'); 
    $language = Language::where('lang_code', $lang_code)->first();

    // Pass language info to the view
    return view('admin.login', compact('usertypes', 'language'));
}


public function login(Request $request)
{
    $request->validate([
        'email'       => 'required|email',
        'password'    => 'required',
        'usertype_id' => 'required|exists:usertype,id',
    ]);

    // ✅ Try to find in users table first
    $user = \App\Models\User::where('email', $request->email)
                ->where('usertype_id', $request->usertype_id)
                ->first();

    // ✅ Try to find in agents table if not found in users
    $agent = null;
    if (!$user) {
        $agent = \DB::table('agents')
            ->where('email', $request->email)
            ->where('usertype_id', $request->usertype_id)
            ->first();
    }

    // ✅ Try to find in suppliers table if not found in users or agents
    $supplier = null;
    if (!$user && !$agent) {
        $supplier = \App\Models\Supplier::where('email', $request->email)
                    ->where('usertype_id', $request->usertype_id)
                    ->first();
    }

    // ✅ If found in users table
    if ($user && \Hash::check($request->password, $user->password)) {
        \Session::put('admin_id', $user->id);
        \Session::put('admin_usertype', $user->usertype_id);

        $language = \App\Models\Language::find($user->language_id);
        if ($language) {
            \Session::put('lang_code', $language->lang_code);
        }

        return redirect()->route('admin.dashboard')
            ->with('success', 'User logged in successfully!');
    }

    // ✅ If found in agents table
    if ($agent && \Hash::check($request->password, $agent->password)) {
        \Session::put('agent_id', $agent->id);
        \Session::put('agent_usertype', $agent->usertype_id);

        if (!empty($agent->language_id)) {
            $language = \App\Models\Language::find($agent->language_id);
            if ($language) {
                \Session::put('lang_code', $language->lang_code);
            }
        }

        return redirect()->route('admin.dashboard')
            ->with('success', 'Agent logged in successfully!');
    }

    // ✅ If found in suppliers table
    if ($supplier && \Hash::check($request->password, $supplier->password)) {
        \Session::put('supplier_id', $supplier->id);
        \Session::put('supplier_usertype', $supplier->usertype_id);

        if (!empty($supplier->language_id)) {
            $language = \App\Models\Language::find($supplier->language_id);
            if ($language) {
                \Session::put('lang_code', $language->lang_code);
            }
        }

        return redirect()->route('admin.dashboard')
            ->with('success', 'Supplier logged in successfully!');
    }

    // ❌ If none found
    return back()->withErrors(['email' => 'Invalid credentials or user type']);
}





public function approvecountry($id)
    {
        $user = User::findOrFail($id);
        $user->status_id = 2; // Approved
        $user->save();

        return redirect()->back()->with('success', 'User approved successfully!');
    }

    // Reject user
    public function rejectcountry(Request $request, $id)
    {
        $request->validate([
            'reject_message' => 'required|string|max:500',
        ]);

        $user = User::findOrFail($id);
        $user->status_id = 3; // Denied
        $user->reject_message = $request->reject_message;
        $user->save();

        return redirect()->back()->with('success', 'User rejected successfully!');
    }




    /**
     * Fetch translations for admin dashboard elements (optional, fallback)
     */
    private function getTranslationData($lang = 'en')
    {
        $langFolderMap = [
            'en' => resource_path('lang/er'),
            'fr' => resource_path('lang/fr'),
        ];

        $folder = $langFolderMap[$lang] ?? $langFolderMap['en'];
        $translations = [];

        if (is_dir($folder)) {
            foreach (scandir($folder) as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                    $key = pathinfo($file, PATHINFO_FILENAME);
                    $filePath = $folder . DIRECTORY_SEPARATOR . $file;

                    $translations[$key] = is_file($filePath) ? include $filePath : [];

                    if (empty($translations[$key]) && $lang != 'en') {
                        $fallbackPath = resource_path('lang/er') . DIRECTORY_SEPARATOR . $file;
                        $translations[$key] = is_file($fallbackPath) ? include $fallbackPath : [];
                    }
                }
            }
        }

        return $translations;
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

    // Fetch all countries for the filter dropdown
    $countries = \App\Models\Country::all();

    // Base query: only farmers (usertype_id = 3)
    $query = \App\Models\User::with(['usertype', 'country'])
                ->where('usertype_id', 3);

    // Apply country filter if selected
    if ($request->has('country_id') && $request->country_id != '') {
        $query->where('country_id', $request->country_id);
    }

    $users = $query->get();

    return view('admin.farmer.list_users', compact('users', 'countries', 'lang'));
}




public function view(Request $request, $id)
{
    // 🌎 Language handling
    $lang = session('lang', 'en');
    if ($request->has('lang')) {
        $lang = $request->lang;
        session(['lang' => $lang]);
    }
    App::setLocale($lang);

    // Fetch user with relations
    $user = User::with(['usertype', 'country'])->findOrFail($id);

    return view('admin.farmer.view_user', compact('user', 'lang'));
}




    
public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        // 'username' => 'required|unique:users,username,' . $user->id,
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|min:6',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $data = [
        // 'username' => $request->username,
        'name' => $request->name,
        'email' => $request->email,
        'usertype_id' => $request->usertype_id,
        'company_name' => $request->company_name,
        'manager_name' => $request->manager_name,
        'position' => $request->position,
        'city' => $request->city,
        'address' => $request->address,
        'phone' => $request->phone,
        'mobile' => $request->mobile,
        'state_entity_registration' => $request->state_entity_registration,
        'employer_identification_number' => $request->employer_identification_number,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'status_id' => $request->status_id,
        'language_id' => $request->language_id,
        'country_id' => $request->country_id,
    ];

    // ✅ If user is Agent save region JSON + country field
    if ($request->usertype_id == 1) {
        $data['country_id'] = $request->country;
        $data['region'] = json_encode($request->region);
    }

    if ($request->password) {
        $data['password'] = bcrypt($request->password);
    }

    // ✅ Upload image
    if ($request->hasFile('image')) {
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads/user_images'), $imageName);
        $data['image'] = $imageName;
    }

    $user->update($data);

    // ✅ Supplier Table Update
    if ($user->usertype_id == 2) {
        \DB::table('suppliers')->where('email', $user->email)->update([
            'company_name' => $request->company_name,
            'manager_name' => $request->manager_name,
            'position' => $request->position,
            'city' => $request->city,
            'region' => json_encode($request->region),
            'address' => $request->address,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'state_entity_registration' => $request->state_entity_registration,
            'employer_identification_number' => $request->employer_identification_number,
            'updated_at' => now(),
        ]);
    }

    if ($user->usertype_id == 1) {
        return redirect('admin/agents')->with('success', 'Agent updated successfully.');
    } elseif ($user->usertype_id == 2) {
        return redirect('admin/suppliers')->with('success', 'Supplier updated successfully.');
    }

    return redirect('admin/users')->with('success', 'User updated successfully.');
}
// Edit country farmer
public function editCountryUser($id)
{
    $user = User::findOrFail($id);
    $usertypes = Usertype::all();
    $countries = Country::all();

    // Blade file location ke hisaab se path
    return view('admin.farmer.edit_user_country', compact('user', 'usertypes', 'countries'));
}

// Update country farmer
public function updateCountryUser(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'username' => 'required|unique:users,username,' . $user->id,
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|min:6',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $data = $request->only([
        'username', 'name', 'email', 'usertype_id', 'company_name', 'manager_name', 'position',
        'city', 'address', 'phone', 'mobile', 'state_entity_registration', 
        'employer_identification_number', 'latitude', 'longitude', 'status_id', 
        'language_id', 'country_id'
    ]);

    // Password
    if ($request->password) {
        $data['password'] = bcrypt($request->password);
    }

    // Image upload
    if ($request->hasFile('image')) {
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads/user_images'), $imageName);
        $data['image'] = $imageName;
    }

    $user->update($data);

    // Supplier table update
    if ($user->usertype_id == 2) {
        \DB::table('suppliers')->where('email', $user->email)->update([
            'company_name' => $request->company_name,
            'manager_name' => $request->manager_name,
            'position' => $request->position,
            'city' => $request->city,
            'region' => json_encode($request->region ?? []),
            'address' => $request->address,
            'phone' => $request->phone,
            'mobile' => $request->mobile,
            'state_entity_registration' => $request->state_entity_registration,
            'employer_identification_number' => $request->employer_identification_number,
            'updated_at' => now(),
        ]);
    }

    return redirect('/admin/country/users')->with('success', 'User updated successfully.');
}

public function viewcountry($id)
{
    $user = User::with(['usertype', 'country'])->findOrFail($id);

    return view('admin.farmer.contryview', compact('user'));
}



 
    public function destroy($id)
{
    $user = User::findOrFail($id);
    $usertype = $user->usertype_id;  // delete se pehle type le lo

    $user->delete();

    // ✅ Redirect based on usertype
    if ($usertype == 1) {
        return redirect('admin/users')->with('success', 'User deleted successfully');
    } elseif ($usertype == 2) {
        return redirect('admin/suppliers')->with('success', 'Supplier deleted successfully');
    }

    return redirect()->back()->with('success', 'User deleted successfully');
}
    public function destroyCountry($id)
{
    $user = User::findOrFail($id);
    $usertype = $user->usertype_id;  // delete se pehle type le lo

    $user->delete();

    // ✅ Redirect based on usertype
    if ($usertype == 1) {
        return redirect('admin/users')->with('success', 'User deleted successfully');
    } elseif ($usertype == 2) {
        return redirect('admin/suppliers')->with('success', 'Supplier deleted successfully');
    }

    return redirect()->back()->with('success', 'User deleted successfully');
}


    public function sendAR($id)
    {
        if (!Session::has('admin_id')) {
            return redirect()->route('admin.login');
        }

        $user = User::findOrFail($id);
        // You can add email or report sending logic here
        return redirect()->route('admin.list_users')->with('success', 'AR sent successfully to '.$user->name);
    }

    public function logout()
    {
        Session::forget(['admin_id', 'admin_usertype']);
        return redirect()->route('admin.login');
    }

public function productOverview()
    {
        // Count data from all product tables
        $counts = [
            'seeds' => DB::table('seed_forms')->count(),
            'animal_feeds' => DB::table('animal_feeds')->count(),
            'bio_stimulants' => DB::table('bio_stimulants')->count(),
            'inorganic_soil_conditioners' => DB::table('inorganic_soil_conditioners')->count(),
            'mineral_fertilizers' => DB::table('mineral_fertilizers')->count(),
            'organic_amendments' => DB::table('organic_amendments')->count(),
            'synthetic_pesticides' => DB::table('synthetic_pesticides')->count(),
            'veterinary_products' => DB::table('veterinary_products')->count(),
        ];

        // ✅ Correct view path including 'products' folder
        return view('admin.products.product_overview', compact('counts'));
    }


public function productOverviewCountry()
{
    $adminId = session('masteradmin_id');
    $user = MasterAdmin::find($adminId);

    if (!$user) {
        return redirect()->route('masteradmin.login.form')
                         ->with('error', 'Please login first');
    }

    $countryId = $user->country_id;

    $tables = [
        'seeds' => 'seed_forms',
        'animal_feeds' => 'animal_feeds',
        'bio_stimulants' => 'bio_stimulants',
        'inorganic_soil_conditioners' => 'inorganic_soil_conditioners',
        'mineral_fertilizers' => 'mineral_fertilizers',
        'organic_amendments' => 'organic_amendments',
        'synthetic_pesticides' => 'synthetic_pesticides',
        'veterinary_products' => 'veterinary_products',
    ];

    $counts = [];

    foreach ($tables as $key => $table) {

        $counts[$key] = DB::table($table)
            ->join('suppliers', $table . '.supplier_id', '=', 'suppliers.id')
            ->where('suppliers.country_id', $countryId)
            ->count();
    }

return view('admin.products.product_overview_country', compact('counts'));
}



    public function showData($table)
{
    // ✅ Allowed tables for security
    $allowedTables = [
        'seed_forms',
        'animal_feeds',
        'bio_stimulants',
        'inorganic_soil_conditioners',
        'mineral_fertilizers',
        'organic_amendments',
        'synthetic_pesticides',
        'veterinary_products',
    ];

    if (!in_array($table, $allowedTables)) {
        abort(403, 'Unauthorized access');
    }

    // ✅ Fetch data from selected table
    $data = \DB::table($table)->get();

    // ✅ Pass table name to show title dynamically
    return view('admin.show_data', compact('data', 'table'));
}








public function viewRecord(Request $request, $table, $id)
{
    /* =========================
       ✅ LANGUAGE SETUP
    ========================= */
    $lang = session('lang', 'en');

    if ($request->has('lang')) {
        $lang = $request->lang;
        session(['lang' => $lang]);
    }

    App::setLocale($lang);

    /* =========================
       ✅ VALIDATE TABLE
    ========================= */
    if (!Schema::hasTable($table)) {
        return redirect()->back()->with('error', 'Invalid table selected.');
    }

    /* =========================
       ✅ FETCH RECORD
    ========================= */
    $record = DB::table($table)->where('id', $id)->first();

    if (!$record) {
        return redirect()->back()->with('error', 'Record not found.');
    }

    $record = (array) $record;

    /* =========================
       ✅ MAP TABLE → BLADE
    ========================= */
    $viewMap = [
        'seed_forms' => 'seed',
        'mineral_fertilizers' => 'mineral_fertilizers',
        'organic_amendments' => 'organic_amendments',
        'bio_stimulants' => 'bio_stimulants',
        'inorganic_soil_conditioners' => 'inorganic_soil_conditioners',
        'synthetic_pesticides' => 'synteci',
        'animal_feeds' => 'animal_feeds',
        'veterinary_products' => 'veterinary_products',
    ];

    $bladeFile = 'admin.dynamic_views.' . ($viewMap[$table] ?? $table);

    /* =========================
       ✅ CHECK VIEW EXISTS
    ========================= */
    if (!view()->exists($bladeFile)) {
        return "❌ Blade file not found: resources/views/admin/dynamic_views/"
            . ($viewMap[$table] ?? $table) . ".blade.php";
    }

    /* =========================
       ✅ FETCH DOCUMENTS
    ========================= */
    $documents = DB::table('allcomplementary')
        ->where('table_name', $table)
        ->where('table_record_id', $id)
        ->get()
        ->map(function ($doc) {
            $doc->file_url = url($doc->file_path);
            return $doc;
        });

    /* =========================
       ✅ STATUS (TRANSLATABLE)
    ========================= */
    $statusMapping = [
        1 => 'pending',
        2 => 'approved',
        3 => 'deny',
    ];

    $currentStatus = $statusMapping[$record['status_id']] ?? 'pending';

    /* =========================
       ✅ RETURN VIEW
    ========================= */
    return view(
        $bladeFile,
        compact('record', 'table', 'id', 'documents', 'currentStatus', 'lang')
    );
}


public function countryViewRecord($table, $id)
{
    // ✅ Validate table existence
    if (!\Schema::hasTable($table)) {
        return redirect()->back()->with('error', 'Invalid table selected.');
    }

    // ✅ Fetch the record safely
    $record = \DB::table($table)->where('id', $id)->first();
    if (!$record) {
        return redirect()->back()->with('error', 'Record not found.');
    }
    $record = (array) $record;

    // ✅ Map table names to blade files
    $viewMap = [
     'seed_forms' => 'seed_country',
        'mineral_fertilizers' => 'mineral_fertilizers_country',
        'organic_amendments' => 'organic_amendments_country',
        'bio_stimulants' => 'bio_stimulants_country',
        'inorganic_soil_conditioners' => 'inorganic_soil_conditioners_country',
        'synthetic_pesticides' => 'synteci_country',
        'animal_feeds' => 'animal_feeds_country',
        'veterinary_products' => 'veterinary_products_country',
    ];
 $bladeFile = "admin.dynamic_views_country." . ($viewMap[$table] ?? $table);

    if (!view()->exists($bladeFile)) {
        return "❌ Blade file not found: resources/views/admin/dynamic_views_country/" 
               . ($viewMap[$table] ?? $table) . ".blade.php";
    }

    // ✅ Fetch related documents with correct URL
   $documents = \DB::table('allcomplementary')
        ->where('table_name', $table)
        ->where('table_record_id', $id)
        ->get()
        ->map(function ($doc) {
            // Remove any extra folder prefix
            $doc->file_url = url($doc->file_path);
            return $doc;
        });

    // ✅ Map status_id to readable current status
    $statusMapping = [
        1 => 'Pending',
        2 => 'Approved',
        3 => 'Dined', // or 'Not Approved'
    ];

    $currentStatus = $statusMapping[$record['status_id']] ?? 'Pending';

    // ✅ Return view with record, documents, and current status
    return view($bladeFile, compact('record', 'table', 'id', 'documents', 'currentStatus'));
}


public function editRecord(Request $request, $table, $id)
{
    /* =========================
       ✅ LANGUAGE SETUP
    ========================= */
    $lang = session('lang', 'en');

    if ($request->has('lang')) {
        $lang = $request->lang;
        session(['lang' => $lang]);
    }

    App::setLocale($lang);

    /* =========================
       ✅ VALIDATE TABLE
    ========================= */
    if (!Schema::hasTable($table)) {
        return redirect()->back()->with('error', 'Invalid table selected.');
    }

    /* =========================
       ✅ FETCH RECORD
    ========================= */
    $record = DB::table($table)->where('id', $id)->first();

    if (!$record) {
        return redirect()->back()->with('error', 'Record not found.');
    }

    $record = (array) $record;

    /* =========================
       ✅ TABLE → EDIT BLADE MAP
    ========================= */
    $viewMap = [
        'seed_forms' => 'seed_edit',
        'mineral_fertilizers' => 'mineral_edit',
        'organic_amendments' => 'organic_edit',
        'bio_stimulants' => 'bio_edit',
        'inorganic_soil_conditioners' => 'inorganic_edit',
        'synthetic_pesticides' => 'synthetic_edit',
        'animal_feeds' => 'animal_edit',
        'veterinary_products' => 'veterinary_edit',
    ];

    $bladeFile = 'admin.dynamic_views.' . ($viewMap[$table] ?? $table . '_edit');

    /* =========================
       ✅ CHECK VIEW EXISTS
    ========================= */
    if (!view()->exists($bladeFile)) {
        return "❌ Edit Blade not found: resources/views/admin/dynamic_views/"
            . ($viewMap[$table] ?? $table . '_edit') . ".blade.php";
    }

    /* =========================
       ✅ RETURN VIEW
    ========================= */
    return view(
        $bladeFile,
        compact('record', 'table', 'id', 'lang')
    );
}



public function updateRecord(Request $request, $table, $id)
{
    if (!\Schema::hasTable($table)) {
        return redirect()->back()->with('error', 'Invalid table selected.');
    }

    $data = $request->except('_token');

    // 🌟 IMAGE UPLOAD HANDLING (Only for seed_forms)
    if ($table == 'seed_forms' && $request->hasFile('seed_image')) {

        $file = $request->file('seed_image');

        // Unique filename
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Upload path
        $uploadPath = public_path('uploads/seed_images/');

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $file->move($uploadPath, $filename);

        // Save path in DB
        $data['seed_image'] = 'uploads/seed_images/' . $filename;

        // Optional: Delete old image if exists
        $oldRecord = \DB::table($table)->where('id', $id)->first();
        if ($oldRecord && !empty($oldRecord->seed_image) && file_exists(public_path($oldRecord->seed_image))) {
            @unlink(public_path($oldRecord->seed_image));
        }
    }

    \DB::table($table)->where('id', $id)->update($data);

    return redirect()->back()->with('success', 'Record updated successfully!');
}


public function editRecordCountry($table, $id)
{
    if (!\Schema::hasTable($table)) {
        return redirect()->back()->with('error', 'Invalid table selected.');
    }

    $record = \DB::table($table)->where('id', $id)->first();

    if (!$record) {
        return redirect()->back()->with('error', 'Record not found.');
    }

    $record = (array) $record;

    // TABLE → BLADE mapping
    $viewMap = [
        'seed_forms' => 'seed_edit',
        'mineral_fertilizers' => 'mineral_edit',
        'organic_amendments' => 'organic_edit',
        'bio_stimulants' => 'bio_edit',
        'inorganic_soil_conditioners' => 'inorganic_edit',
        'synthetic_pesticides' => 'synthetic_edit',
        'animal_feeds' => 'animal_edit',
        'veterinary_products' => 'veterinary_edit',
    ];

    // COUNTRY folder
    $bladeFile = "admin.dynamic_views_country." . ($viewMap[$table] ?? $table . "_edit");

    if (!view()->exists($bladeFile)) {
        return "❌ Edit Blade not found: resources/views/admin/dynamic_views_country/" . ($viewMap[$table] ?? $table . "_edit") . ".blade.php";
    }

    return view($bladeFile, compact('record', 'table', 'id'));
}
public function updateRecordCountry(Request $request, $table, $id)
{
    if (!\Schema::hasTable($table)) {
        return redirect()->back()->with('error', 'Invalid table selected.');
    }

    $data = $request->except('_token');

    // 🌟 IMAGE UPLOAD HANDLING (Only for seed_forms)
    if ($table == 'seed_forms' && $request->hasFile('seed_image')) {

        $file = $request->file('seed_image');

        // Unique filename
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Upload path
        $uploadPath = public_path('uploads/seed_images/');

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $file->move($uploadPath, $filename);

        // Save path in DB
        $data['seed_image'] = 'uploads/seed_images/' . $filename;

        // Optional: Delete old image if exists
        $oldRecord = \DB::table($table)->where('id', $id)->first();
        if ($oldRecord && !empty($oldRecord->seed_image) && file_exists(public_path($oldRecord->seed_image))) {
            @unlink(public_path($oldRecord->seed_image));
        }
    }

    \DB::table($table)->where('id', $id)->update($data);

    return redirect()->back()->with('success', 'Record updated successfully!');
}

public function updateStatusCountry(Request $request, $table, $id)
{
    // Validate input
    $request->validate([
        'status' => 'required|in:approved,rejected',
        'reason' => 'required_if:status,rejected', // reason required only when rejected
    ]);

    // Map status string to status_id
    $statusMap = [
        'pending'  => 1,
        'approved' => 2,
        'rejected' => 3,
    ];

    $status = strtolower($request->status);
    $statusId = $statusMap[$status] ?? 1;

    // Map table names to model classes
    $tableToModel = [
        'animal_feeds' => \App\Models\AnimalFeed::class,
        'bio_stimulants' => \App\Models\BioStimulant::class,
        'inorganic_soil_conditioners' => \App\Models\InorganicSoilConditioner::class,
        'mineral_fertilizers' => \App\Models\MineralFertilizer::class,
        'organic_amendments' => \App\Models\OrganicAmendment::class,
        'seed_forms' => \App\Models\SeedForm::class,
        'synthetic_pesticides' => \App\Models\SyntheticPesticide::class,
        'veterinary_products' => \App\Models\VeterinaryProduct::class,
    ];

    if (!array_key_exists($table, $tableToModel)) {
        return redirect()->back()->with('error', 'Invalid table specified.');
    }

    $modelClass = $tableToModel[$table];

    // Find record
    $record = $modelClass::find($id);
    if (!$record) {
        return redirect()->back()->with('error', 'Record not found.');
    }

    // Update status
    $record->status_id = $statusId;

    // Save reject reason
    if ($statusId == 3) {
        $record->reject_reason = $request->reason;
    }

    $record->save();

    return redirect()->back()->with('success', 'Status updated successfully!');
}





public function updateStatus(Request $request, $table, $id)
{
    // Validate input
    $request->validate([
        'status' => 'required|in:approved,rejected',
        'reason' => 'required_if:status,rejected', // reason required only when rejected
    ]);

    // Map status string to status_id
    $statusMap = [
        'pending'  => 1,
        'approved' => 2,
        'rejected' => 3,
    ];

    $status = strtolower($request->status);
    $statusId = $statusMap[$status] ?? 1;

    // Map table names to model classes
    $tableToModel = [
        'animal_feeds' => \App\Models\AnimalFeed::class,
        'bio_stimulants' => \App\Models\BioStimulant::class,
        'inorganic_soil_conditioners' => \App\Models\InorganicSoilConditioner::class,
        'mineral_fertilizers' => \App\Models\MineralFertilizer::class,
        'organic_amendments' => \App\Models\OrganicAmendment::class,
        'seed_forms' => \App\Models\SeedForm::class,
        'synthetic_pesticides' => \App\Models\SyntheticPesticide::class,
        'veterinary_products' => \App\Models\VeterinaryProduct::class,
    ];

    if (!array_key_exists($table, $tableToModel)) {
        return redirect()->back()->with('error', 'Invalid table specified.');
    }

    $modelClass = $tableToModel[$table];

    // Find record
    $record = $modelClass::find($id);
    if (!$record) {
        return redirect()->back()->with('error', 'Record not found.');
    }

    // Update status
    $record->status_id = $statusId;

    // Save reject reason if rejected
    if ($statusId == 3) {
        $record->reject_reason = $request->reason;
    }

    $record->save();

    // ================= UPDATE PARENT STATUS =================
    // If this record has a parent_id, update the parent status_id to 0
    if (isset($record->parent_id) && $record->parent_id) {
        $parent = $modelClass::find($record->parent_id);
        if ($parent) {
            $parent->status_id = 0; // Set parent status to 0
            $parent->save();
        }
    }

    return redirect()->back()->with('success', 'Status updated successfully!');
}








public function deleteRecord($table, $id)
{
    // Map table names to model classes
    $tableToModel = [
        'animal_feeds' => \App\Models\AnimalFeed::class,
        'bio_stimulants' => \App\Models\BioStimulant::class,
        'inorganic_soil_conditioners' => \App\Models\InorganicSoilConditioner::class,
        'mineral_fertilizers' => \App\Models\MineralFertilizer::class,
        'organic_amendments' => \App\Models\OrganicAmendment::class,
        'seed_forms' => \App\Models\SeedForm::class,
        'synthetic_pesticides' => \App\Models\SyntheticPesticide::class,
        'veterinary_products' => \App\Models\VeterinaryProduct::class,
    ];

    // Check if table is valid
    if (!array_key_exists($table, $tableToModel)) {
        return redirect()->back()->with('error', 'Invalid table specified.');
    }

    $modelClass = $tableToModel[$table];

    // Find record
    $record = $modelClass::find($id);
    if (!$record) {
        return redirect()->back()->with('error', 'Record not found.');
    }

    // Delete the record
    $record->delete();

     return redirect('admin/products/all')->with('success', 'Record deleted successfully!');
}
public function deleteRecordCountry($table, $id)
{
    // Map table names to model classes
    $tableToModel = [
        'animal_feeds' => \App\Models\AnimalFeed::class,
        'bio_stimulants' => \App\Models\BioStimulant::class,
        'inorganic_soil_conditioners' => \App\Models\InorganicSoilConditioner::class,
        'mineral_fertilizers' => \App\Models\MineralFertilizer::class,
        'organic_amendments' => \App\Models\OrganicAmendment::class,
        'seed_forms' => \App\Models\SeedForm::class,
        'synthetic_pesticides' => \App\Models\SyntheticPesticide::class,
        'veterinary_products' => \App\Models\VeterinaryProduct::class,
    ];

    // Check if table is valid
    if (!array_key_exists($table, $tableToModel)) {
        return redirect()->back()->with('error', 'Invalid table specified.');
    }

    $modelClass = $tableToModel[$table];

    // Find record
    $record = $modelClass::find($id);
    if (!$record) {
        return redirect()->back()->with('error', 'Record not found.');
    }

    // Delete the record
    $record->delete();

    return redirect('products-all-country')->with('success', 'Record deleted successfully!');
}


 public function adminPrivacyPolicies($language_id = null)
    {
        if ($language_id) {
            $policies = PrivacyPolicy::where('language_id', $language_id)->get();
        } else {
            $policies = PrivacyPolicy::all();
        }

        return view('admin.privacy_policies', compact('policies'));
    }


    public function adminTermsConditions($language_id = null)
    {
        if ($language_id) {
            $terms = TermsCondition::where('language_id', $language_id)->get();
        } else {
            $terms = TermsCondition::all();
        }

        return view('admin.terms_conditions', compact('terms'));
    }





public function productMap(Request $request)
{
    // ✅ Seed table names
    $seedItems = \DB::table('seed')
        ->where('language_id', 1)
        ->get(['id', 'name']);

    // ✅ Name -> Table mapping
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

    $tables = array_values($tableMap);
    $allData = collect();
    $category = $request->get('category');
    $selectedRegion = $request->get('region'); // ✅ Get selected region

    // ✅ Determine selected table
    $selectedTable = null;
    if ($category) {
        foreach ($tableMap as $name => $table) {
            if (\Str::slug($name, '_') === \Str::slug($category, '_')) {
                $selectedTable = $table;
                break;
            }
        }
    }

    $tablesToFetch = $selectedTable ? [$selectedTable] : $tables;

    foreach ($tablesToFetch as $table) {
        if (!\Schema::hasTable($table)) continue;

        $query = \DB::table($table);

        // ✅ JOIN supplier location if supplier_id exists
        if (\Schema::hasColumn($table, 'supplier_id')) {
            $query->leftJoin('suppliers', $table . '.supplier_id', '=', 'suppliers.id')
                  ->select(
                      $table . '.*', 
                      'suppliers.latitude', 
                      'suppliers.longitude', 
                      'suppliers.name as supplier_name', 
                      'suppliers.region'
                  );
            
            // ✅ Apply region filter if selected (use 'region' column)
            if ($selectedRegion) {
                $query->where('suppliers.region', $selectedRegion);
            }
        }

        // ✅ SEARCH FILTER
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search, $table) {
                foreach (\Schema::getColumnListing($table) as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                }
            });
        }

        $data = $query->get()->map(function ($item) use ($table) {
            $item->table_name = $table;

            // Only for seed_forms: prepend image path
            if ($table === 'seed_forms' && isset($item->image) && $item->image) {
                $item->image = asset('uploads/seed_images/' . $item->image);
            }

            return $item;
        });

        $allData = $allData->merge($data);
    }

    // ✅ Fetch distinct regions from suppliers table for dropdown
    $regions = \DB::table('suppliers')->select('region')->distinct()->get();

    // ✅ Pass data to view
    return view('admin.products_map', [
        'allData' => $allData,
        'category' => $category,
        'regions' => $regions,
        'selectedRegion' => $selectedRegion
    ]);
}

public function createCountryFarmer(Request $request)
{
    // 🌎 Language Setup
    $lang = session('lang', 'en');
    if ($request->has('lang')) {
        $lang = $request->lang;
        session(['lang' => $lang]);
    }
    App::setLocale($lang);

    // ✅ Logged-in user's country
    $country_id = session('country_id');
    if ($country_id) {
        $country_name = DB::table('countries')->where('id', $country_id)->value('name');
    } else {
        $country_name = '';
    }

    return view('admin.farmer.add_country_farmer', compact(
        'country_id', 
        'country_name'
    ));
}





public function storecountryfmaer(Request $request)
{
    $request->validate([
        'username' => 'required',
        'name'     => 'required',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required',
        'phone'    => 'required'
    ]);

    // Logged-in user ki country auto set
    $loginCountry = session('country_id');
    if (!$loginCountry) {
        return back()->with('error', 'Your country is not set!');
    }

    // Create base user
    User::create([
        'username'    => $request->username,
        'name'        => $request->name,
        'email'       => $request->email,
        'password'    => bcrypt($request->password),
        'usertype_id' => 3,               // ✅ Farmer fixed (assuming 2 = Farmer)
        'country_id'  => $loginCountry,   // AUTO country
        'phone'       => $request->phone,
    ]);

return redirect('/admin/country/users')
            ->with('success', 'Country Farmer created successfully!');}

public function countryUsers(Request $request)
{
    // 🌎 Language Setup
    $lang = session('lang', 'en');
    if ($request->has('lang')) {
        $lang = $request->lang;
        session(['lang' => $lang]);
    }
    App::setLocale($lang);

    // ✅ Logged-in user's country
    $country_id = session('country_id');

    if (!$country_id) {
        return back()->with('error', __('dashboard.your_country_not_set'));
    }

    // Sirf us country ke users fetch karo
    $users = User::where('country_id', $country_id)->get();

    // Country ka name fetch karo
    $country_name = DB::table('countries')->where('id', $country_id)->value('name');

    return view('admin.farmer.country_users', compact('users', 'country_name'));
}
public function allProductWithCountry(Request $request)
{
    // LANGUAGE HANDLING
    $lang = session('lang', 'en');
    if ($request->has('lang')) {
        $lang = $request->lang;
        session(['lang' => $lang]);
    }
    App::setLocale($lang);

    $userCountryId = session('country_id');

    $category = $request->get('category', 'veterinary_products');
    $search   = $request->get('search');
    $minPrice = $request->get('min_price');
    $maxPrice = $request->get('max_price');
    $minYield = $request->get('min_yield');
    $maxYield = $request->get('max_yield');
    $status   = $request->get('status');

    // CATEGORY → TABLE MAP
    $tableMap = [
        'seeds'                       => 'seed_forms',
        'animal_feeds'                => 'animal_feeds',
        'biostimulants'               => 'bio_stimulants',
        'inorganic_soil_conditioners' => 'inorganic_soil_conditioners',
        'mineral_fertilizers'         => 'mineral_fertilizers',
        'organic_amendments'          => 'organic_amendments',
        'synthetic_pesticides'        => 'synthetic_pesticides',
        'veterinary_products'         => 'veterinary_products',
    ];

    // ================= CATEGORY CARDS COUNT (STATUS 0 & 4 HIDDEN) =================
    $counts = [];
    foreach ($tableMap as $slug => $tableName) {

        if (!Schema::hasTable($tableName)) {
            $counts[] = [
                'slug'  => $slug,
                'name'  => __('labels.' . $slug),
                'count' => 0
            ];
            continue;
        }

        $query = DB::table($tableName);

        if (Schema::hasColumn($tableName, 'status_id')) {
            $query->where('status_id', '!=', 0)
                  ->where('status_id', '!=', 4);
        }

        if (Schema::hasColumn($tableName, 'supplier_id')) {
            $supplierIds = DB::table('suppliers')
                ->where('country_id', $userCountryId)
                ->pluck('id')
                ->toArray();

            $query->whereIn('supplier_id', $supplierIds ?: [0]);
        }

        $counts[] = [
            'slug'  => $slug,
            'name'  => __('labels.' . $slug),
            'count' => $query->count()
        ];
    }

    // ================= SELECTED TABLE DATA (STATUS 0 & 4 HIDDEN) =================
    $selectedTable = $tableMap[$category] ?? null;
    $allData = collect();

    if ($selectedTable && Schema::hasTable($selectedTable)) {

        $query = DB::table($selectedTable);

        if (Schema::hasColumn($selectedTable, 'status_id')) {
            $query->where('status_id', '!=', 0)
                  ->where('status_id', '!=', 4);
        }

        if (Schema::hasColumn($selectedTable, 'supplier_id')) {
            $supplierIds = DB::table('suppliers')
                ->where('country_id', $userCountryId)
                ->pluck('id')
                ->toArray();

            $query->whereIn('supplier_id', $supplierIds ?: [0]);
        }

        if ($search) {
            $query->where(function ($q) use ($search, $selectedTable) {
                foreach (Schema::getColumnListing($selectedTable) as $col) {
                    $q->orWhere($col, 'like', "%{$search}%");
                }
            });
        }

        if (Schema::hasColumn($selectedTable, 'price')) {
            if ($minPrice !== null) $query->where('price', '>=', $minPrice);
            if ($maxPrice !== null) $query->where('price', '<=', $maxPrice);
        }

        if ($selectedTable === 'seed_forms' && Schema::hasColumn($selectedTable, 'yield')) {
            if ($minYield !== null) $query->where('yield', '>=', $minYield);
            if ($maxYield !== null) $query->where('yield', '<=', $maxYield);
        }

        $statusColumn = Schema::hasColumn($selectedTable, 'status_id')
            ? 'status_id'
            : (Schema::hasColumn($selectedTable, 'status') ? 'status' : null);

        if ($status && $statusColumn) {
            $query->where($statusColumn, $status);
        }

        $allData = $query->get()->map(function ($item) use ($selectedTable, $category) {
            $item->table_name = $selectedTable;
            $item->category   = __('labels.' . $category);
            return $item;
        });
    }

    // ================= PAGINATION =================
    $perPage     = 10;
    $currentPage = $request->get('page', 1);

    $pagedData = $allData
        ->slice(($currentPage - 1) * $perPage, $perPage)
        ->values();

    $tableData = new \Illuminate\Pagination\LengthAwarePaginator(
        $pagedData,
        $allData->count(),
        $perPage,
        $currentPage,
        [
            'path'  => $request->url(),
            'query' => $request->query()
        ]
    );

    return view('admin.farmer.countryallproduct', compact(
        'tableData',
        'counts',
        'category'
    ));
}





public function allProductWithCountryt(Request $request)
{
    // Logged-in user's country
    $userCountryId = session('country_id');

    // -------------------------------
    // FILTER INPUTS
    // -------------------------------
    $minPrice  = $request->get('min_price');
    $maxPrice  = $request->get('max_price');
    $minYield  = $request->get('min_yield');
    $maxYield  = $request->get('max_yield');
    $status    = $request->get('status');
    $search    = $request->get('search');
    $category  = $request->get('category');

    // -------------------------------
    // CATEGORY → TABLE MAP (FIXED)
    // -------------------------------
    $tableMap = [
        'seeds'                       => 'seed_forms',
        'animal_feeds'                => 'animal_feeds',
        'biostimulants'               => 'bio_stimulants',
        'inorganic_soil_conditioners' => 'inorganic_soil_conditioners',
        'mineral_fertilizers'         => 'mineral_fertilizers',
        'organic_amendments'          => 'organic_amendments',
        'synthetic_pesticides'        => 'synthetic_pesticides',
        'veterinary_products'         => 'veterinary_products',
    ];

    // -------------------------------
    // DEFAULT CATEGORY
    // -------------------------------
    if (!$category) {
        $category = 'veterinary_products';
    }

    // -------------------------------
    // CATEGORY CARDS COUNT
    // -------------------------------
    $counts = [];

    foreach ($tableMap as $slug => $tableName) {

        if (!\Schema::hasTable($tableName)) {
            $counts[] = ['name' => Str::title(str_replace('_',' ', $slug)), 'count' => 0];
            continue;
        }

        $query = \DB::table($tableName);

        // Exclude status 4
        if (\Schema::hasColumn($tableName, 'status_id')) {
            $query->where('status_id', '!=', 4);
        }

        // Country-wise supplier filter
        if (\Schema::hasColumn($tableName, 'supplier_id')) {

            $supplierIds = \DB::table('suppliers')
                ->where('country_id', $userCountryId)
                ->pluck('id')
                ->toArray();

            if (!empty($supplierIds)) {
                $query->whereIn('supplier_id', $supplierIds);
            } else {
                $query->whereRaw('0=1');
            }
        }

        $counts[] = [
            'name'  => Str::title(str_replace('_',' ', $slug)),
            'count' => $query->count()
        ];
    }

    // -------------------------------
    // SELECTED TABLE (FIXED)
    // -------------------------------
    $selectedTable = $tableMap[$category] ?? null;

    $allData = collect();

    if ($selectedTable && \Schema::hasTable($selectedTable)) {

        $query = \DB::table($selectedTable);

        // Exclude status 4
        if (\Schema::hasColumn($selectedTable, 'status_id')) {
            $query->where('status_id', '!=', 4);
        }

        // Country filter
        if (\Schema::hasColumn($selectedTable, 'supplier_id')) {

            $supplierIds = \DB::table('suppliers')
                ->where('country_id', $userCountryId)
                ->pluck('id')
                ->toArray();

            if (!empty($supplierIds)) {
                $query->whereIn('supplier_id', $supplierIds);
            } else {
                $query->whereRaw('0=1');
            }
        }

        // SEARCH FILTER
        if ($search) {
            $query->where(function ($q) use ($search, $selectedTable) {
                foreach (\Schema::getColumnListing($selectedTable) as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                }
            });
        }

        // PRICE FILTER
        if (\Schema::hasColumn($selectedTable, 'price')) {
            if ($minPrice !== null) $query->where('price', '>=', $minPrice);
            if ($maxPrice !== null) $query->where('price', '<=', $maxPrice);
        }

        // YIELD FILTER (SEEDS ONLY)
        if ($selectedTable === 'seed_forms' && \Schema::hasColumn($selectedTable, 'yield')) {
            if ($minYield !== null) $query->where('yield', '>=', $minYield);
            if ($maxYield !== null) $query->where('yield', '<=', $maxYield);
        }

        // STATUS FILTER
        $statusColumn = \Schema::hasColumn($selectedTable, 'status_id')
            ? 'status_id'
            : (\Schema::hasColumn($selectedTable, 'status') ? 'status' : null);

        if ($status && $statusColumn) {
            $query->where($statusColumn, $status);
        }

        // FETCH DATA
        $data = $query->get()->map(function ($item) use ($selectedTable) {
            $item->table_name = $selectedTable;
            return $item;
        });

        $allData = $allData->merge($data);
    }

    // -------------------------------
    // PAGINATION
    // -------------------------------
    $perPage     = 10;
    $currentPage = $request->get('page', 1);

    $pagedData = $allData
        ->slice(($currentPage - 1) * $perPage, $perPage)
        ->values();

    $tableData = new \Illuminate\Pagination\LengthAwarePaginator(
        $pagedData,
        $allData->count(),
        $perPage,
        $currentPage,
        [
            'path'  => $request->url(),
            'query' => $request->query()
        ]
    );

    return view('admin.farmer.countryallproduct', compact(
        'tableData',
        'counts',
        'category'
    ));
}










public function export(Request $request)
{
    /*
    |--------------------------------------------------------------------------
    | 1️⃣ SINGLE ROW EXPORT (View ke Download Excel button se)
    |--------------------------------------------------------------------------
    */
    if ($request->filled('table') && $request->filled('id')) {

        $table = $request->table;
        $id    = $request->id;

        if (!Schema::hasTable($table)) {
            return back()->with('error', 'Invalid table');
        }

        $record = DB::table($table)->where('id', $id)->first();

        if (!$record) {
            return back()->with('error', 'Record not found');
        }

        return Excel::download(
            new ProductsExport(collect([$record])),
            $table . '_record_' . $id . '.xlsx'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | 2️⃣ FILTERED CATEGORY EXPORT (Top Export Excel button)
    |--------------------------------------------------------------------------
    */

    // 🔹 Filters
    $minPrice  = $request->min_price;
    $maxPrice  = $request->max_price;
    $minYield  = $request->min_yield;
    $maxYield  = $request->max_yield;
    $status    = $request->status;
    $search    = $request->search;
    $category  = $request->category; // 🔥 slug
    $countryId = $request->country;

    /*
    |--------------------------------------------------------------------------
    | 3️⃣ CATEGORY SLUG → TABLE MAP (IMPORTANT FIX)
    |--------------------------------------------------------------------------
    */
    $tableMap = [
        'seeds'                       => 'seed_forms',
        'animal_feeds'                => 'animalfeed_testing', // ✅ FIX
        'bio_stimulants'              => 'bio_stimulants',
        'inorganic_soil_conditioners' => 'inorganic_soil_conditioners',
        'mineral_fertilizers'         => 'mineral_fertilizers',
        'organic_amendments'          => 'organic_amendments',
        'synthetic_pesticides'        => 'synthetic_pesticides',
        'veterinary_products'         => 'veterinary_products',
    ];

    // 🔹 Default category
    if (!$category) {
        $category = 'veterinary_products';
    }

    $selectedTable = $tableMap[$category] ?? null;

    if (!$selectedTable || !Schema::hasTable($selectedTable)) {
        return back()->with('error', 'Invalid category table');
    }

    /*
    |--------------------------------------------------------------------------
    | 4️⃣ BUILD QUERY
    |--------------------------------------------------------------------------
    */
    $query = DB::table($selectedTable);

    // Status
    if (Schema::hasColumn($selectedTable, 'status_id')) {
        $query->where('status_id', '!=', 4);
    }

    // Country filter
    if ($countryId && Schema::hasColumn($selectedTable, 'supplier_id')) {
        $supplierIds = DB::table('suppliers')
            ->where('country_id', $countryId)
            ->pluck('id')
            ->toArray();

        $supplierIds
            ? $query->whereIn('supplier_id', $supplierIds)
            : $query->whereRaw('0=1');
    }

    // Search
    if ($search) {
        $query->where(function ($q) use ($search, $selectedTable) {
            foreach (Schema::getColumnListing($selectedTable) as $col) {
                $q->orWhere($col, 'like', "%{$search}%");
            }
        });
    }

    // Price
    if (Schema::hasColumn($selectedTable, 'price')) {
        if ($minPrice !== null) $query->where('price', '>=', $minPrice);
        if ($maxPrice !== null) $query->where('price', '<=', $maxPrice);
    }

    // Yield (Seeds only)
    if ($selectedTable === 'seed_forms' && Schema::hasColumn($selectedTable, 'yield')) {
        if ($minYield !== null) $query->where('yield', '>=', $minYield);
        if ($maxYield !== null) $query->where('yield', '<=', $maxYield);
    }

    // Status filter
    if ($status && Schema::hasColumn($selectedTable, 'status_id')) {
        $query->where('status_id', $status);
    }

    /*
    |--------------------------------------------------------------------------
    | 5️⃣ FETCH DATA
    |--------------------------------------------------------------------------
    */
    $finalData = $query->get();

    if ($finalData->isEmpty()) {
        return back()->with('error', 'No data found for export');
    }

    /*
    |--------------------------------------------------------------------------
    | 6️⃣ EXCEL DOWNLOAD (AUTO OPEN)
    |--------------------------------------------------------------------------
    */
    return Excel::download(
        new ProductsExport($finalData),
        $selectedTable . '_export.xlsx'
    );
}



public function importExcel(Request $request)
{
    $request->validate([
        'excel_file' => 'required|mimes:xlsx,xls,csv'
    ]);

    $file = $request->file('excel_file');
    $fileName = time().'_'.$file->getClientOriginalName();

    $destination = public_path('imports');
    if (!file_exists($destination)) {
        mkdir($destination, 0777, true);
    }

    $file->move($destination, $fileName);

    Excel::import(new ProductImport, $destination.'/'.$fileName);

    return back()->with('success', 'Animal Feed Excel Imported Successfully ✅');
}



}



