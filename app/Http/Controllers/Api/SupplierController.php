<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Status;
use App\Models\Supplier;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    private $baseImageUrl = 'https://fivoflow.com/wclm/public/';

   

public function store(Request $request)
{
    Log::info('SUPPLIER STORE REQUEST', ['inputs' => $request->all()]);

    try {
        // ✅ Email unique rule
        $emailRule = 'nullable|email|max:255|unique:suppliers,email';
        if ($request->id) {
            $emailRule .= ',' . $request->id;
        }

        // ✅ Validation
        $validated = $request->validate([
            'id' => 'nullable|integer|exists:suppliers,id',
            'company_name' => 'required|string|max:255',
            'manager_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'email' => $emailRule,
            'phone' => 'nullable|string|max:50',
            'mobile' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'country_id' => 'nullable|integer',
            'status_id' => 'nullable|integer',

            // ✅ CREATED BY (ADDED)
            'created_by' => 'nullable|integer|exists:agents,id',

            'state_entity_registration' => 'nullable|string|max:255',
            'employer_identification_number' => 'nullable|string|max:255',

            'seed_id' => 'nullable|array',
            'seed_id.*' => 'nullable|string',

            'language_id' => 'nullable|integer',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'altitude' => 'nullable|numeric',
            'accuracy' => 'nullable|numeric',
            'enumerator_first_name' => 'nullable|string|max:100',
            'enumerator_last_name' => 'nullable|string|max:100',
            'enumerator_whatsapp' => 'nullable|string|max:20',
            'otp' => 'nullable|string|max:10',
            'otp_expires_at' => 'nullable|date',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:4096',
        ]);

        DB::beginTransaction();

        // ✅ seed_id → JSON
        if (is_array($request->seed_id)) {
            $validated['seed_id'] = json_encode($request->seed_id);
        }

        // ================= UPDATE =================
        if ($request->id) {

            $supplier = Supplier::find($request->id);
            if (!$supplier) {
                return response()->json([
                    'status' => false,
                    'message' => 'Supplier not found!',
                ], 404);
            }

            // ✅ Image upload
            if ($request->hasFile('image')) {
                $path = 'uploads/supplier/';
                $file = $request->file('image');
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                if (!File::exists(public_path($path))) {
                    File::makeDirectory(public_path($path), 0755, true);
                }

                $file->move(public_path($path), $fileName);
                $validated['image'] = $this->baseImageUrl . $path . $fileName;
            }

            foreach ($validated as $key => $value) {
                if ($value !== null && $key !== 'id') {
                    $supplier->$key = $value;
                }
            }

            $supplier->save();
            DB::commit();

            $supplier->seed_id = json_decode($supplier->seed_id, true);

            return response()->json([
                'status' => true,
                'message' => 'Supplier updated successfully!',
                'data' => $supplier,
            ], 200);
        }

        // ================= CREATE =================
        $data = $validated;
        $data['usertype_id'] = 2;
        $data['status_id'] = $data['status_id'] ?? 1;

        // ✅ CREATED BY FINAL LOGIC (FORM DATA > LOGIN AGENT)
        $data['created_by'] = $request->created_by
            ?? (auth()->guard('agent')->check() ? auth()->guard('agent')->id() : null);

        $data['password'] = Hash::make('123456');

        // ✅ Image upload
        if ($request->hasFile('image')) {
            $path = 'uploads/supplier/';
            $file = $request->file('image');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            if (!File::exists(public_path($path))) {
                File::makeDirectory(public_path($path), 0755, true);
            }

            $file->move(public_path($path), $fileName);
            $data['image'] = $this->baseImageUrl . $path . $fileName;
        }

        $supplier = Supplier::create($data);
        DB::commit();

        $supplier->seed_id = json_decode($supplier->seed_id, true);

        return response()->json([
            'status' => true,
            'message' => 'Supplier saved successfully!',
            'data' => $supplier,
        ], 200);

    } catch (\Illuminate\Validation\ValidationException $e) {
        DB::rollBack();
        return response()->json([
            'status' => false,
            'message' => 'Validation failed',
            'errors' => $e->errors(),
        ], 422);
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('SUPPLIER STORE ERROR', ['error' => $e->getMessage()]);
        return response()->json([
            'status' => false,
            'message' => 'Operation failed: ' . $e->getMessage(),
        ], 500);
    }
}

public function storef(Request $request)
{
    Log::info('SUPPLIER STORE REQUEST', ['inputs' => $request->all()]);

    try {

        // ================= EMAIL RULE =================
        $emailRule = 'nullable|email|max:255|unique:suppliers,email';
        if ($request->filled('id')) {
            $emailRule .= ',' . $request->id;
        }

        // ================= VALIDATION =================
        $validated = $request->validate([
            'id' => 'nullable|integer|exists:suppliers,id',

            'company_name' => 'required|string|max:255',
            'manager_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',

            'email' => $emailRule,
            'phone' => 'nullable|string|max:50',
            'mobile' => 'nullable|string|max:50',

            'city' => 'nullable|string|max:255',

            // ✅ region array
            'region' => 'nullable|string|max:255',
            'region.*' => 'integer',

            'address' => 'nullable|string|max:255',
            'country_id' => 'nullable|integer',
            'status_id' => 'nullable|integer',

            // ✅ created_by from FORM DATA
            'created_by' => 'nullable|integer|exists:agents,id',

            'state_entity_registration' => 'nullable|string|max:255',
            'employer_identification_number' => 'nullable|string|max:255',

            // ✅ seed array
            'seed_id' => 'nullable|array',
            'seed_id.*' => 'string',

            'language_id' => 'nullable|integer',

            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'altitude' => 'nullable|numeric',
            'accuracy' => 'nullable|numeric',

            'enumerator_first_name' => 'nullable|string|max:100',
            'enumerator_last_name' => 'nullable|string|max:100',
            'enumerator_whatsapp' => 'nullable|string|max:20',

            'otp' => 'nullable|string|max:10',
            'otp_expires_at' => 'nullable|date',

            'image' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:4096',
        ]);

        DB::beginTransaction();

        // ================= ARRAY → JSON =================
        if ($request->filled('seed_id')) {
            $validated['seed_id'] = json_encode($request->seed_id);
        }

        if ($request->filled('region')) {
            $validated['region'] = json_encode($request->region);
        }

        // ================= UPDATE =================
        if ($request->filled('id')) {

            $supplier = Supplier::find($request->id);
            if (!$supplier) {
                return response()->json([
                    'status' => false,
                    'message' => 'Supplier not found'
                ], 404);
            }

            // Image upload
            if ($request->hasFile('image')) {
                $path = public_path('uploads/supplier/');
                if (!File::exists($path)) {
                    File::makeDirectory($path, 0755, true);
                }

                $fileName = time() . '_' . uniqid() . '.' . $request->image->extension();
                $request->image->move($path, $fileName);
                $validated['image'] = 'uploads/supplier/' . $fileName;
            }

            foreach ($validated as $key => $value) {
                if ($value !== null && $key !== 'id') {
                    $supplier->$key = $value;
                }
            }

            $supplier->save();
            DB::commit();

            $supplier->seed_id = json_decode($supplier->seed_id, true);
            $supplier->region = json_decode($supplier->region, true);

            return response()->json([
                'status' => true,
                'message' => 'Supplier updated successfully',
                'data' => $supplier
            ]);
        }

        // ================= CREATE =================
        $data = $validated;
        $data['usertype_id'] = 2;
        $data['status_id'] = $data['status_id'] ?? 1;
        $data['password'] = Hash::make('123456');

        // ✅ created_by priority: FORM DATA > AUTH AGENT
        $data['created_by'] = $request->created_by
            ?? (auth()->guard('agent')->check() ? auth()->guard('agent')->id() : null);

        // Image upload
        if ($request->hasFile('image')) {
            $path = public_path('uploads/supplier/');
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            $fileName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move($path, $fileName);
            $data['image'] = 'uploads/supplier/' . $fileName;
        }

        $supplier = Supplier::create($data);
        DB::commit();

        $supplier->seed_id = json_decode($supplier->seed_id, true);
        $supplier->region = json_decode($supplier->region, true);

        return response()->json([
            'status' => true,
            'message' => 'Supplier created successfully',
            'data' => $supplier
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        DB::rollBack();
        return response()->json([
            'status' => false,
            'message' => 'Validation failed',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('SUPPLIER STORE ERROR', ['error' => $e->getMessage()]);
        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

public function index(Request $request)
{
    $query = Supplier::with(['status']);

    // 🔍 Search filter
    if ($request->filled('search')) {
        $keyword = $request->search;
        $query->where(function ($q) use ($keyword) {
            $q->where('company_name', 'LIKE', "%{$keyword}%")
              ->orWhere('manager_name', 'LIKE', "%{$keyword}%");
        });
    }

    // ✅ AGENT FILTER (created_by = agent_id)
    if ($request->filled('agent_id')) {
        $query->where('created_by', $request->agent_id);
    }

    // 🌐 Language filter
    if ($request->filled('language_id')) {
        $query->where('language_id', $request->language_id);
    }

    $suppliers = $query->get()->map(function ($supplier) {

        // ✅ seed_id response exact format ["4","5"]
        $seedIds = [];
        if (!empty($supplier->seed_id)) {
            $decoded = json_decode($supplier->seed_id, true);
            if (is_array($decoded)) {
                foreach ($decoded as $value) {
                    $parts = explode(',', $value);
                    foreach ($parts as $p) {
                        $seedIds[] = (string) trim($p);
                    }
                }
            } else {
                $seedIds = array_map(
                    'strval',
                    array_filter(array_map('trim', explode(',', $supplier->seed_id)))
                );
            }
        }

        return [
            'id' => $supplier->id,
            'company_name' => $supplier->company_name,
            'manager_name' => $supplier->manager_name,
            'position' => $supplier->position,
           'image' => !empty($supplier->image) 
           ? (filter_var($supplier->image, FILTER_VALIDATE_URL) 
               ? $supplier->image 
               : url('uploads/supplier/' . $supplier->image))
           : null,

            'city' => $supplier->city,
            'region' => $supplier->region,
            'address' => $supplier->address,
            'phone' => $supplier->phone,
            'mobile' => $supplier->mobile,
            'email' => $supplier->email,
            'created_by' => $supplier->created_by,
            'language_id' => $supplier->language_id,
            'seed_id' => $seedIds,
            'state_entity_registration' => $supplier->state_entity_registration,
            'employer_identification_number' => $supplier->employer_identification_number,
            'status_id' => $supplier->status_id,
            'country_id' => $supplier->country_id,
            'latitude' => $supplier->latitude,
            'longitude' => $supplier->longitude,
            'enumerator_last_name' => $supplier->enumerator_last_name,
            'enumerator_first_name' => $supplier->enumerator_first_name,
            'enumerator_whatsapp' => $supplier->enumerator_whatsapp,
            'altitude' => $supplier->altitude,
            'accuracy' => $supplier->accuracy,
            'status' => $supplier->status->name ?? null,
            'created_at' => $supplier->created_at,
            'updated_at' => $supplier->updated_at,
        ];
    });

    return response()->json([
        'status' => true,
        'count' => $suppliers->count(),
        'data' => $suppliers
    ]);
}






    public function show($id)
{
    $supplier = Supplier::with(['status'])->find($id);

    if (!$supplier) {
        return response()->json([
            'status' => false,
            'message' => 'Supplier not found'
        ], 404);
    }

    $responseData = [
        'id' => $supplier->id,
        'company_name' => $supplier->company_name,
        'manager_name' => $supplier->manager_name,
        'position' => $supplier->position,
        'image' => $supplier->image,
        'city' => $supplier->city,
        'region' => $supplier->region,
        'address' => $supplier->address,
        'phone' => $supplier->phone,
        'mobile' => $supplier->mobile,
        'email' => $supplier->email,
        'created_by' => $supplier->created_by,
        'language_id' => $supplier->language_id,
        'seed_id' => $supplier->seed_id,
        'state_entity_registration' => $supplier->state_entity_registration,
        'employer_identification_number' => $supplier->employer_identification_number,
        'status_id' => $supplier->status_id,
        'status' => $supplier->status->name ?? null,
        'country_id' => $supplier->country_id,
        'latitude' => $supplier->latitude,
        'longitude' => $supplier->longitude,
        'created_at' => $supplier->created_at,
        'updated_at' => $supplier->updated_at,
        'enumerator_last_name' => $supplier->enumerator_last_name,
        'enumerator_first_name' => $supplier->enumerator_first_name,
        'enumerator_whatsapp' => $supplier->enumerator_whatsapp,
        'altitude' => $supplier->altitude,
        'accuracy' => $supplier->accuracy,
        'translations' => [],
    ];

    return response()->json([
        'status' => true,
        'data' => $responseData
    ]);
}


    // ✅ Get all statuses
    public function getStatuses()
    {
        $statuses = Status::select('id', 'name')->orderBy('id', 'asc')->get();

        return response()->json([
            'status' => true,
            'message' => 'Statuses retrieved successfully',
            'data' => $statuses
        ]);
    }
public function distance(Request $request)
{
    $user = auth()->user();

    // 🔥 Smart location logic
    $lat = $request->latitude ?? ($user->latitude ?? null);
    $lng = $request->longitude ?? ($user->longitude ?? null);

    // ❗ Default location if nothing is provided
    if (!$lat || !$lng) {
        $lat = 28.6139;   // Delhi example
        $lng = 77.2090;
    }

    $radius = $request->radius;

    // 🔹 Base query with distance calculation
    $query = \DB::table('suppliers')
        ->selectRaw("
            id, company_name, latitude, longitude,
            (6371 * acos(
                cos(radians(?)) 
                * cos(radians(latitude)) 
                * cos(radians(longitude) - radians(?)) 
                + sin(radians(?)) 
                * sin(radians(latitude))
            )) AS distance
        ", [$lat, $lng, $lat]);

    // 🔥 Apply radius filter if provided
    if ($radius) {
        $query->having('distance', '<=', $radius);
    }

    $suppliers = $query->orderBy('distance', 'asc')->get();

    // ❗ If no suppliers found with radius, return all suppliers (ignoring distance)
    if ($radius && $suppliers->isEmpty()) {
        $suppliers = \DB::table('suppliers')
            ->select('id', 'company_name', 'latitude', 'longitude')
            ->get();
    }

    return response()->json([
        'status' => true,
        'used_lat' => $lat,
        'used_lng' => $lng,
        'radius' => $radius,
        'total_suppliers' => $suppliers->count(),
        'data' => $suppliers
    ]);
}
public function distances(Request $request)
{
    $user = auth()->user();

    // 🔥 Smart location logic
    $lat = $request->latitude ?? ($user->latitude ?? null);
    $lng = $request->longitude ?? ($user->longitude ?? null);

    // ❗ Agar kuch bhi nahi mila to default location use karo
    if (!$lat || !$lng) {
        $lat = 28.6139;   // default (Delhi example)
        $lng = 77.2090;
    }

    // 🔹 Radius (optional)
    $radius = $request->radius;

    $query = \DB::table('suppliers')
        ->selectRaw("
            id, company_name, latitude, longitude,
            (6371 * acos(
                cos(radians(?)) 
                * cos(radians(latitude)) 
                * cos(radians(longitude) - radians(?)) 
                + sin(radians(?)) 
                * sin(radians(latitude))
            )) AS distance
        ", [$lat, $lng, $lat]);

    // 🔥 Radius filter
    if ($radius) {
        $query->having('distance', '<=', $radius);
    }

    $suppliers = $query
        ->orderBy('distance', 'asc')
        ->get();

    return response()->json([
        'status' => true,
        'used_lat' => $lat,
        'used_lng' => $lng,
        'radius' => $radius,
        'total_suppliers' => $suppliers->count(),
        'data' => $suppliers
    ]);
}

// public function distance(Request $request)
// {
//     // 🔹 User (optional - agar login hai)
//     $user = auth()->user();

//     // 🔥 Location logic
//     $lat = $request->latitude ?? ($user->latitude ?? null);
//     $lng = $request->longitude ?? ($user->longitude ?? null);

//     if (!$lat || !$lng) {
//         return response()->json([
//             'status' => false,
//             'message' => 'Location required (latitude & longitude)'
//         ]);
//     }

//     // 🔹 Radius (optional)
//     $radius = $request->radius;

//     // 🔥 Query (Multiple Suppliers)
//     $query = \DB::table('suppliers')
//         ->selectRaw("
//             id, company_name, latitude, longitude,
//             (6371 * acos(
//                 cos(radians(?)) 
//                 * cos(radians(latitude)) 
//                 * cos(radians(longitude) - radians(?)) 
//                 + sin(radians(?)) 
//                 * sin(radians(latitude))
//             )) AS distance
//         ", [$lat, $lng, $lat]);

//     // 🔥 Radius filter
//     if ($radius) {
//         $query->having('distance', '<=', $radius);
//     }

//     $suppliers = $query
//         ->orderBy('distance', 'asc')
//         ->get();

//     return response()->json([
//         'status' => true,
//         'radius' => $radius,
//         'total_suppliers' => $suppliers->count(),
//         'data' => $suppliers
//     ]);
// }
// public function distance(Request $request, $id)
// {
//     $supplier = Supplier::find($id);

//     if (!$supplier) {
//         return response()->json([
//             'status' => false,
//             'message' => 'Supplier not found'
//         ], 404);
//     }

//     // User lat long (API se aayega)
//     $userLat = $request->latitude;
//     $userLng = $request->longitude;

//     if (!$userLat || !$userLng) {
//         return response()->json([
//             'status' => false,
//             'message' => 'User latitude & longitude required'
//         ]);
//     }

//     // Supplier lat long
//     $supplierLat = $supplier->latitude;
//     $supplierLng = $supplier->longitude;

//     // Distance formula (Haversine)
//     $earthRadius = 6371; // KM

//     $latDiff = deg2rad($supplierLat - $userLat);
//     $lngDiff = deg2rad($supplierLng - $userLng);

//     $a = sin($latDiff / 2) * sin($latDiff / 2) +
//          cos(deg2rad($userLat)) * cos(deg2rad($supplierLat)) *
//          sin($lngDiff / 2) * sin($lngDiff / 2);

//     $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

//     $distance = $earthRadius * $c;

//     return response()->json([
//         'status' => true,
//         'distance_km' => round($distance, 2)
//     ]);
// }


    
}
