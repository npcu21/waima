<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Image;


use App\Models\FarmerEnquiry;
use App\Models\User;
use App\Models\Seed;
use App\Models\SeedForm;
use App\Models\AnimalFeed;
use App\Models\BioStimulant;
use App\Models\VeterinaryProduct;
use App\Models\InorganicSoilConditioner;
use App\Models\MineralFertilizer;
use App\Models\OrganicAmendment;
use App\Models\SyntheticPesticide;
use App\Models\Supplier;
use App\Models\Document;
use App\Models\Enqerytype;
use App\Models\ProductLike;
use App\Models\PreOrder;
use App\Models\PreOrderSupplierResponse;
use App\Models\OrderStatus;

use App\Models\EnquiryMessage;   // ✅ NEW IMPORTANT MODEL

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PriceTrendExcelExport;



class FarmerEnquiryController extends Controller
{


 public function farmerdocument(Request $request)
    {
        $id = $request->id;

        // users table se user fetch
        $user = DB::table('users')->where('id', $id)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }

        // usertype_id ke hisab se related documents fetch
        $documents = DB::table('documents')
            ->where('usertype_id', $user->usertype_id)
            ->get()
            ->map(function($doc) {
                return [
                    'id' => $doc->id,
                    'name' => $doc->name,
                    'file_path' => $doc->file_path ? url($doc->file_path) : null,
                    'created_at' => $doc->created_at,
                ];
            });

        return response()->json([
            'status' => true,
            'message' => 'User fetched successfully',
            'data' => [
                'user' => $user,
                'documents' => $documents
            ]
        ], 200);
    }



public function farmerEnquiryList()
{
    // Farmer enquiries
    $enquiries = FarmerEnquiry::orderBy('created_at', 'desc')->get();

    // Map each enquiry with related documents (matching usertype_id)
    $enquiriesWithDocs = $enquiries->map(function($enquiry) {
        // Get documents related to this farmer's usertype (assuming FarmerEnquiry has usertype_id)
        $documents = Document::where('usertype_id', $enquiry->usertype_id ?? 3)
            ->get()
            ->map(function($doc) {
                return [
                    'id' => $doc->id,
                    'name' => $doc->name,
                    'file_path' => $doc->file_path ? url($doc->file_path) : null,
                    'created_at' => $doc->created_at,
                ];
            });

        return [
            'farmer_enquiry' => $enquiry,
            'documents' => $documents
        ];
    });

    return response()->json([
        'status' => true,
        'message' => 'Farmer enquiries with related documents fetched successfully',
        'data' => $enquiriesWithDocs
    ], 200);
}


    // Get total enquiries with linked products
    public function totalEnquiriesWithProducts()
    {
        $totalEnquiries = FarmerEnquiry::count();

        $overallProducts = FarmerEnquiry::all()->sum(function($enquiry) {
            $seedId = $enquiry->enquiry_type;
            return
                SeedForm::where('product_id', $seedId)->count() +
                AnimalFeed::where('product_id', $seedId)->count() +
                BioStimulant::where('product_id', $seedId)->count() +
                VeterinaryProduct::where('product_id', $seedId)->count() +
                InorganicSoilConditioner::where('product_id', $seedId)->count() +
                MineralFertilizer::where('product_id', $seedId)->count() +
                OrganicAmendment::where('product_id', $seedId)->count() +
                SyntheticPesticide::where('product_id', $seedId)->count();
        });

        return response()->json([
            'success' => true,
            'total_enquiries' => $totalEnquiries,
            'overall_total_products' => $overallProducts
        ]);
    }
    public function supplierTotalProducts(Request $request)
{
    $supplierId = $request->query('supplier_id');

    if (!$supplierId) {
        return response()->json([
            'success' => false,
            'message' => 'supplier_id is required'
        ], 400);
    }

    // ============================
    // TOTAL PRODUCTS COUNT
    // ============================
    $totalProducts =
        SeedForm::where('supplier_id', $supplierId)->count() +
        AnimalFeed::where('supplier_id', $supplierId)->count() +
        BioStimulant::where('supplier_id', $supplierId)->count() +
        VeterinaryProduct::where('supplier_id', $supplierId)->count() +
        InorganicSoilConditioner::where('supplier_id', $supplierId)->count() +
        MineralFertilizer::where('supplier_id', $supplierId)->count() +
        OrganicAmendment::where('supplier_id', $supplierId)->count() +
        SyntheticPesticide::where('supplier_id', $supplierId)->count();

    // ============================
    // FARMER ENQUIRIES FIX (LONGTEXT supplier_id)
    // ============================
    $farmerEnquiries = FarmerEnquiry::where('supplier_id', 'LIKE', "%$supplierId%")->get();
    $totalEnquiries  = $farmerEnquiries->count();

    // ============================
    // IMAGE URL HANDLING
    // ============================
    $baseUrl = 'https://fivoflow.com/wclm/public/uploads/';

    $images = Image::all()->map(function ($image) use ($baseUrl) {

        $paths = json_decode($image->image_path, true);
        if (!is_array($paths)) {
            $paths = [$image->image_path];
        }

        return [
            'id' => $image->id,
            'name' => $image->name,
            'image_paths' => array_map(function ($p) use ($baseUrl) {

                if (str_starts_with($p, 'http://') || str_starts_with($p, 'https://')) {
                    return $p;
                }

                return $baseUrl . ltrim($p, '/');

            }, $paths)
        ];
    });

    return response()->json([
        'success' => true,
        'supplier_id' => $supplierId,
        'total_products' => $totalProducts,
        'total_enquiries' => $totalEnquiries,
        'farmer_enquiries' => $farmerEnquiries,
        'images' => $images
    ]);
}


//     public function supplierTotalProducts(Request $request)
// {
//     $supplierId = $request->query('supplier_id');

//     if (!$supplierId) {
//         return response()->json([
//             'success' => false,
//             'message' => 'supplier_id is required'
//         ], 400);
//     }

//     $totalProducts =
//         SeedForm::where('supplier_id', $supplierId)->count() +
//         AnimalFeed::where('supplier_id', $supplierId)->count() +
//         BioStimulant::where('supplier_id', $supplierId)->count() +
//         VeterinaryProduct::where('supplier_id', $supplierId)->count() +
//         InorganicSoilConditioner::where('supplier_id', $supplierId)->count() +
//         MineralFertilizer::where('supplier_id', $supplierId)->count() +
//         OrganicAmendment::where('supplier_id', $supplierId)->count() +
//         SyntheticPesticide::where('supplier_id', $supplierId)->count();

//     $farmerEnquiries = FarmerEnquiry::where('supplier_id', $supplierId)->get();
//     $totalEnquiries = $farmerEnquiries->count();

//     // ============================
//     // FIXED IMAGE URL HANDLING
//     // ============================
//     $baseUrl = 'https://fivoflow.com/wclm/public/uploads/';

//     $rawImages = Image::all();

//     $images = $rawImages->map(function ($image) use ($baseUrl) {

//         $paths = json_decode($image->image_path, true);
//         if (!is_array($paths)) {
//             $paths = [$image->image_path];
//         }

//         return [
//             "id" => $image->id,
//             "name" => $image->name,
//             "image_paths" => array_map(function ($p) use ($baseUrl) {

//                 // If already full URL → keep as is
//                 if (str_starts_with($p, 'http://') || str_starts_with($p, 'https://')) {
//                     return $p;
//                 }

//                 // If relative → add base URL
//                 return $baseUrl . ltrim($p, '/');

//             }, $paths)
//         ];
//     });

//     return response()->json([
//         'success' => true,
//         'supplier_id' => $supplierId,
//         'total_products' => $totalProducts,
//         'total_enquiries' => $totalEnquiries,
//         'farmer_enquiries' => $farmerEnquiries,
//         'images' => $images
//     ]);
// }

public function store(Request $request)
{
    $data = $request->all();

    // ================= IMAGE UPLOAD =================
    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')
            ->store('uploads/enquiry_images', 'public');
    }

    // ================= PDF UPLOAD =================
    if ($request->hasFile('pdf')) {
        $data['pdf'] = $request->file('pdf')
            ->store('uploads/enquiry_pdfs', 'public');
    }

    // ================= CUSTOMER INQUIRY TYPE =================
    if (!isset($data['customer_inqer']) && isset($data['enquiry_type'])) {
        $enquiryType = \App\Models\EnqeryType::find($data['enquiry_type']);
        $data['customer_inqer'] = $enquiryType ? $enquiryType->name : null;
    }

    // ================= SUPPLIER ID (ALL EDGE CASES) =================
    if ($request->has('supplier_id')) {

        $supplierIds = $request->supplier_id;
        $finalIds = [];

        // Case: supplier_id[] = "1,2,3"
        if (is_array($supplierIds)) {
            foreach ($supplierIds as $value) {
                if (is_string($value)) {
                    $finalIds = array_merge(
                        $finalIds,
                        explode(',', $value)
                    );
                } else {
                    $finalIds[] = $value;
                }
            }
        }
        // Case: supplier_id = "1,2,3"
        elseif (is_string($supplierIds)) {
            $finalIds = explode(',', $supplierIds);
        }
        // Case: supplier_id = 1
        else {
            $finalIds[] = $supplierIds;
        }

        // clean data
        $finalIds = array_values(
            array_unique(
                array_map('intval', array_filter($finalIds))
            )
        );

        // save as array (JSON cast)
        $data['supplier_id'] = $finalIds;
    }

    // ================= CREATE ENQUIRY =================
    $enquiry = \App\Models\FarmerEnquiry::create($data);

    return response()->json([
        'success' => true,
        'message' => 'Enquiry submitted successfully',
        'data'    => $enquiry
    ], 200);
}
// public function store(Request $request)
// {
//     $data = $request->all();

//     // Image upload
//     if ($request->hasFile('image')) {
//         $data['image'] = $request->file('image')
//             ->store('uploads/enquiry_images', 'public');
//     }

//     // PDF upload
//     if ($request->hasFile('pdf')) {
//         $data['pdf'] = $request->file('pdf')
//             ->store('uploads/enquiry_pdfs', 'public');
//     }

//     // enquiry_type se customer_inqer set
//     if (!isset($data['customer_inqer']) && isset($data['enquiry_type'])) {
//         $enquiryType = \App\Models\EnqeryType::find($data['enquiry_type']);
//         $data['customer_inqer'] = $enquiryType ? $enquiryType->name : null;
//     }

//     // ✅ supplier_id single + multiple
//     if ($request->has('supplier_id')) {

//         $supplierIds = $request->supplier_id;

//         // single → array
//         if (!is_array($supplierIds)) {
//             $supplierIds = [$supplierIds];
//         }

//         // ✅ DIRECT array save karo (json_encode ❌)
//         $data['supplier_id'] = $supplierIds;
//     }

//     // Create enquiry
//     $enquiry = \App\Models\FarmerEnquiry::create($data);

//     return response()->json([
//         'success' => true,
//         'message' => 'Enquiry submitted successfully',
//         'data' => $enquiry
//     ], 200);
// } 







 public function farmerReply(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $enquiry = FarmerEnquiry::find($id);
        if (!$enquiry) {
            return response()->json(['success' => false, 'message' => 'Enquiry not found'], 404);
        }

        EnquiryMessage::create([
            'enquiry_id' => $id,
            'sender_id' => $enquiry->created_by,
            'sender_type' => 'farmer',
            'message' => $request->message,
            'seen_by_farmer' => 1,
            'seen_by_supplier' => 0,
        ]);

        return response()->json(['success' => true, 'message' => 'Message sent successfully']);
    }

    // Supplier replies to enquiry
    public function supplierReply(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $enquiry = FarmerEnquiry::find($id);
        if (!$enquiry) {
            return response()->json(['success' => false, 'message' => 'Enquiry not found'], 404);
        }

        EnquiryMessage::create([
            'enquiry_id' => $id,
            'sender_id' => $enquiry->supplier_id,
            'sender_type' => 'supplier',
            'message' => $request->message,
            'seen_by_supplier' => 1,
            'seen_by_farmer' => 0,
        ]);

        return response()->json(['success' => true, 'message' => 'Reply sent successfully']);
    }

    
    public function markAsSeen($id)
{
    // Find the enquiry
    $enquiry = FarmerEnquiry::find($id);
    if (!$enquiry) {
        return response()->json([
            'success' => false,
            'message' => 'Enquiry not found'
        ], 404);
    }

    // Update messages seen status
    EnquiryMessage::where('enquiry_id', $id)
        ->where('sender_type', 'farmer')
        ->where('seen_by_supplier', 0)
        ->update([
            'seen_by_supplier' => 1,
            'seen_at' => now()
        ]);

    // Update enquiry seen status
    if ($enquiry->seen_by_supplier == 0) {
        $enquiry->update([
            'seen_by_supplier' => 1,
            'seen_at' => now()
        ]);
    }

    return response()->json([
        'success' => true,
        'message' => 'Enquiry and messages marked as seen by supplier'
    ]);
}


    // Get conversation (all messages for an enquiry)
    public function getConversation($id)
    {
        $enquiry = FarmerEnquiry::find($id);
        if (!$enquiry) {
            return response()->json(['success' => false, 'message' => 'Enquiry not found'], 404);
        }

        $messages = EnquiryMessage::where('enquiry_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'enquiry' => $enquiry,
            'messages' => $messages
        ]);
    }
public function supplierEnquiryList(Request $request)
{
    $supplierId = $request->query('supplier_id');
    $markSeen   = $request->query('mark_seen', 0);

    if (!$supplierId) {
        return response()->json([
            'status'  => false,
            'message' => 'Supplier ID missing'
        ], 400);
    }

    // ============================
    // FETCH ENQUIRIES
    // ============================
    $enquiries = FarmerEnquiry::where('supplier_id', 'LIKE', "%$supplierId%")
        ->orderByDesc('created_at')
        ->get();

    // ============================
    // FORMAT RESPONSE DATA
    // ============================
    $responseData = $enquiries->map(function ($enquiry) {

        // ============================
        // SUPPLIER ID NORMALIZE
        // ============================
        $supplierRaw = $enquiry->supplier_id;
        $supplierIds = [];

        if (is_array($supplierRaw)) {
            $supplierIds = $supplierRaw;
        } elseif (is_string($supplierRaw)) {
            $decoded = json_decode($supplierRaw, true);
            if (is_array($decoded)) {
                $supplierIds = $decoded;
            } else {
                $supplierIds = [$supplierRaw];
            }
        } else {
            $supplierIds = [$supplierRaw];
        }

        // cast to int
        $supplierIds = array_values(array_map('intval', $supplierIds));

        // single ya multiple decide
        $supplierIdFormatted = count($supplierIds) === 1
            ? $supplierIds[0]
            : $supplierIds;

        // ============================
        // UNSEEN COUNT
        // ============================
        $unseenCount = EnquiryMessage::where('enquiry_id', $enquiry->id)
            ->where('sender_type', 'farmer')
            ->where(function ($q) {
                $q->where('seen_by_supplier', 0)
                  ->orWhereNull('seen_by_supplier');
            })
            ->count();

        // ============================
        // ALL MESSAGES
        // ============================
        $messages = EnquiryMessage::where('enquiry_id', $enquiry->id)
            ->orderBy('created_at', 'asc')
            ->get();

        return [
            'enquiry' => array_merge(
                $enquiry->toArray(),
                ['supplier_id' => $supplierIdFormatted]
            ),
            'last_message' => optional($messages->last())->message,
            'unseen_count' => $unseenCount,
            'messages'     => $messages
        ];
    });

    // ============================
    // MARK AS SEEN (ONLY IF FLAG)
    // ============================
    if ($markSeen == 1) {

        FarmerEnquiry::where('supplier_id', 'LIKE', "%$supplierId%")
            ->where('seen_by_supplier', 0)
            ->update([
                'seen_by_supplier' => 1,
                'seen_at'          => now()
            ]);

        EnquiryMessage::whereIn('enquiry_id', $enquiries->pluck('id'))
            ->where('sender_type', 'farmer')
            ->where(function ($q) {
                $q->where('seen_by_supplier', 0)
                  ->orWhereNull('seen_by_supplier');
            })
            ->update([
                'seen_by_supplier' => 1,
                'seen_at'          => now()
            ]);
    }

    return response()->json([
        'status'  => true,
        'message' => 'Supplier enquiries fetched successfully',
        'data'    => $responseData
    ]);
}


// public function supplierEnquiryList(Request $request) 23-12-25
// {
//     $supplierId = $request->query('supplier_id');

//     if (!$supplierId) {
//         return response()->json([
//             'status' => false,
//             'message' => 'Supplier ID missing'
//         ], 400);
//     }

//     // ============================
//     // FETCH ENQUIRIES (FIX: supplier_id is LONGTEXT)
//     // ============================
//     $enquiries = FarmerEnquiry::where('supplier_id', 'LIKE', "%$supplierId%")
//         ->orderByDesc('created_at')
//         ->get();

//     // ============================
//     // MARK ENQUIRIES AS SEEN
//     // ============================
//     FarmerEnquiry::where('supplier_id', 'LIKE', "%$supplierId%")
//         ->where('seen_by_supplier', 0)
//         ->update([
//             'seen_by_supplier' => 1,
//             'seen_at' => now()
//         ]);

//     // ============================
//     // MARK FARMER MESSAGES AS SEEN
//     // ============================
//     EnquiryMessage::whereIn('enquiry_id', $enquiries->pluck('id'))
//         ->where('sender_type', 'farmer')
//         ->where('seen_by_supplier', 0)
//         ->update([
//             'seen_by_supplier' => 1,
//             'seen_at' => now()
//         ]);

//     // ============================
//     // FORMAT RESPONSE DATA
//     // ============================
//     $enquiries = $enquiries->map(function ($enquiry) {

//         // Refresh enquiry to get updated seen status
//         $enquiry->refresh();

//         // Fetch messages
//         $messages = EnquiryMessage::where('enquiry_id', $enquiry->id)
//             ->orderBy('created_at', 'asc')
//             ->get();

//         return [
//             'enquiry' => $enquiry,
//             'last_message' => $messages->last() ? $messages->last()->message : null,
//             'unseen_count' => 0,
//             'messages' => $messages
//         ];
//     });

//     return response()->json([
//         'status' => true,
//         'message' => 'Supplier enquiries fetched successfully',
//         'data' => $enquiries
//     ]);
// }

    // A shorter summary view (returns messages + counts) for supplier's list
//   public function supplierEnquiryList(Request $request)
// {
//     $supplierId = $request->query('supplier_id');

//     if (!$supplierId) {
//         return response()->json(['status' => false, 'message' => 'Supplier ID missing'], 400);
//     }

//     // Fetch all enquiries
//     $enquiries = FarmerEnquiry::where('supplier_id', $supplierId)
//         ->orderByDesc('created_at')
//         ->get();

//     // Mark all enquiries as seen
//     FarmerEnquiry::where('supplier_id', $supplierId)
//         ->where('seen_by_supplier', 0)
//         ->update([
//             'seen_by_supplier' => 1,
//             'seen_at' => now()
//         ]);

//     // Mark all farmer messages as seen
//     EnquiryMessage::whereIn('enquiry_id', $enquiries->pluck('id'))
//         ->where('sender_type', 'farmer')
//         ->where('seen_by_supplier', 0)
//         ->update([
//             'seen_by_supplier' => 1,
//             'seen_at' => now()
//         ]);

//     // Now fetch fresh updated data
//     $enquiries = $enquiries->map(function ($enquiry) {

//         // Reload enquiry fresh with updated seen status
//         $enquiry->refresh();

//         // Fetch messages
//         $messages = EnquiryMessage::where('enquiry_id', $enquiry->id)
//             ->orderBy('created_at', 'asc')
//             ->get();

//         // Now unread will always be zero because we marked them seen above
//         $unseenMessagesCount = 0;
//         $unseenEnquiry = 0;
//         $totalUnseen = 0;

//         return [
//             'enquiry' => $enquiry,
//             'last_message' => $messages->last() ? $messages->last()->message : null,
//             'unseen_count' => $totalUnseen,
//             'messages' => $messages
//         ];
//     });

//     return response()->json([
//         'status' => true,
//         'message' => 'Supplier enquiries fetched successfully',
//         'data' => $enquiries
//     ]);
// }


    // Generic filters for enquiries table
    public function farmerWithCreatedById(Request $request)
{
    $query = DB::table('farmer_enquiries');

    if ($request->filled('id')) {
        $query->where('id', $request->id);
    }

    if ($request->filled('created_by')) {
        $query->where('created_by', $request->created_by);
    }

    if ($request->filled('supplier_id')) {
        $query->where('supplier_id', $request->supplier_id);
    }

    $enquiries = $query->orderByDesc('id')->get();

    // ============================
    // SUPPLIER_ID FORMAT FIX
    // ============================
    $enquiries = $enquiries->map(function ($item) {

        $supplierRaw = $item->supplier_id;
        $supplierIds = [];

        if (is_array($supplierRaw)) {
            $supplierIds = $supplierRaw;
        } elseif (is_string($supplierRaw)) {
            $decoded = json_decode($supplierRaw, true);
            if (is_array($decoded)) {
                $supplierIds = $decoded;
            } else {
                $supplierIds = [$supplierRaw];
            }
        } else {
            $supplierIds = [$supplierRaw];
        }

        // cast to int
        $supplierIds = array_values(array_map('intval', $supplierIds));

        // single ya multiple decide
        $item->supplier_id = count($supplierIds) === 1
            ? $supplierIds[0]
            : $supplierIds;

        return $item;
    });

    return response()->json([
        'success' => true,
        'data'    => $enquiries
    ]);
}

    // public function farmerWithCreatedById(Request $request)
    // {
    //     $query = DB::table('farmer_enquiries');

    //     if ($request->filled('id')) {
    //         $query->where('id', $request->id);
    //     }

    //     if ($request->filled('created_by')) {
    //         $query->where('created_by', $request->created_by);
    //     }

    //     if ($request->filled('supplier_id')) {
    //         $query->where('supplier_id', $request->supplier_id);
    //     }

    //     $enquiries = $query->orderByDesc('id')->get();

    //     return response()->json([
    //         'success' => true,
    //         'data' => $enquiries
    //     ]);
    // }
    public function farmerbyuser(Request $request, $id = null)
{
    if ($id) {
        $user = DB::table('users')->where('id', $id)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        $enquiries = DB::table('farmer_enquiries')->where('created_by', $id)->get();

        $enquiries = $enquiries->map(function ($enquiry) {
            $messages = EnquiryMessage::where('enquiry_id', $enquiry->id)
                ->orderBy('created_at', 'asc')
                ->get();

            $unseenCount = $messages->where('sender_type', 'supplier')
                                    ->where('seen_by_farmer', 0)
                                    ->count();

            // supplier_id ko direct integer me convert kar rahe hain
            $supplierIds = json_decode($enquiry->supplier_id);
            $enquiry->supplier_id = is_array($supplierIds) && count($supplierIds) > 0 ? (int)$supplierIds[0] : null;

            return [
                'enquiry' => $enquiry,
                'messages' => $messages,
                'unseen_count' => $unseenCount
            ];
        });

        return response()->json([
            'success' => true,
            'user' => $user,
            'farmer_enquiries' => $enquiries
        ]);
    } else {
        $users = DB::table('users')->get();
        $enquiries = DB::table('farmer_enquiries')->get();

        $usersWithEnquiries = $users->map(function ($user) use ($enquiries) {
            $userEnquiries = $enquiries->where('created_by', $user->id)->values();

            $userEnquiries = $userEnquiries->map(function ($enquiry) {
                $messages = EnquiryMessage::where('enquiry_id', $enquiry->id)
                    ->orderBy('created_at', 'asc')
                    ->get();

                $unseenCount = $messages->where('sender_type', 'supplier')
                                        ->where('seen_by_farmer', 0)
                                        ->count();

                $supplierIds = json_decode($enquiry->supplier_id);
                $enquiry->supplier_id = is_array($supplierIds) && count($supplierIds) > 0 ? (int)$supplierIds[0] : null;

                return [
                    'enquiry' => $enquiry,
                    'messages' => $messages,
                    'unseen_count' => $unseenCount
                ];
            });

            return [
                'user' => $user,
                'farmer_enquiries' => $userEnquiries
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $usersWithEnquiries
        ]);
    }
}


    // farmerbyuser (single user or all users with their enquiries + unseen counts)
    // public function farmerbyuser(Request $request, $id = null)
    // {
    //     if ($id) {
    //         $user = DB::table('users')->where('id', $id)->first();

    //         if (!$user) {
    //             return response()->json(['success' => false, 'message' => 'User not found'], 404);
    //         }

    //         $enquiries = DB::table('farmer_enquiries')->where('created_by', $id)->get();

    //         $enquiries = $enquiries->map(function ($enquiry) {
    //             $messages = EnquiryMessage::where('enquiry_id', $enquiry->id)
    //                 ->orderBy('created_at', 'asc')
    //                 ->get();

    //             $unseenCount = $messages->where('sender_type', 'supplier')
    //                                     ->where('seen_by_farmer', 0)
    //                                     ->count();

    //             return [
    //                 'enquiry' => $enquiry,
    //                 'messages' => $messages,
    //                 'unseen_count' => $unseenCount
    //             ];
    //         });

    //         return response()->json([
    //             'success' => true,
    //             'user' => $user,
    //             'farmer_enquiries' => $enquiries
    //         ]);
    //     } else {
    //         $users = DB::table('users')->get();
    //         $enquiries = DB::table('farmer_enquiries')->get();

    //         $usersWithEnquiries = $users->map(function ($user) use ($enquiries) {
    //             $userEnquiries = $enquiries->where('created_by', $user->id)->values();

    //             $userEnquiries = $userEnquiries->map(function ($enquiry) {
    //                 $messages = EnquiryMessage::where('enquiry_id', $enquiry->id)
    //                     ->orderBy('created_at', 'asc')
    //                     ->get();

    //                 $unseenCount = $messages->where('sender_type', 'supplier')
    //                                         ->where('seen_by_farmer', 0)
    //                                         ->count();

    //                 return [
    //                     'enquiry' => $enquiry,
    //                     'messages' => $messages,
    //                     'unseen_count' => $unseenCount
    //                 ];
    //             });

    //             return [
    //                 'user' => $user,
    //                 'farmer_enquiries' => $userEnquiries
    //             ];
    //         });

    //         return response()->json([
    //             'success' => true,
    //             'data' => $usersWithEnquiries
    //         ]);
    //     }
    // }
public function supplierSendMessage(Request $request, $id)
{
    $request->validate([
        'message' => 'required|string',
        'sender_id' => 'required|integer',
        'sender_type' => 'required|string'
    ]);

    DB::table('enquiry_messages')->insert([
        'enquiry_id' => $id,
        'sender_id' => $request->sender_id,
        'sender_type' => $request->sender_type,
        'message' => $request->message,
        'created_at' => now(),
        'updated_at' => now(),
        'seen_by_farmer' => 0,
        'seen_by_supplier' => 1
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Message sent successfully'
    ]);
}

public function farmerSendMessage(Request $request, $id)
{
    $filePath = null;

    // File Upload
    if ($request->hasFile('file') && $request->file('file')->isValid()) {
        $file = $request->file('file');
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        $destination = public_path('uploads/farmermsg');

        if (!file_exists($destination)) {
            mkdir($destination, 0777, true);
        }

        $file->move($destination, $fileName);

        $filePath = 'uploads/farmermsg/' . $fileName;
    }

    // 💡 Default values so INSERT never fails
    $senderType = $request->sender_type ?: 'farmer';
    $senderId   = $request->sender_id ?: 0;
    $message    = $request->message ?: '';
    $customer   = $request->customer_inqer ?: null;

    // Insert Message
    DB::table('enquiry_messages')->insert([
        'enquiry_id'        => $id,
        'sender_id'         => $senderId,
        'sender_type'       => $senderType,
        'customer_inqer'    => $customer,
        'message'           => $message,
        'file'              => $filePath,
        'created_at'        => now(),
        'updated_at'        => now(),
        'seen_by_supplier'  => 0,
        'seen_by_farmer'    => 1
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Message sent successfully',
        'file' => $filePath
    ]);
}
public function farmerActiveProducts(Request $request)
{
    try {

        // ================= BASE URLS =================
        $qrBaseUrl      = 'https://fivoflow.com/wclm/public/qrcodes/';
        $uploadsBaseUrl = 'https://fivoflow.com/wclm/public/';

        // Logged-in user OR device token
        $userId       = auth()->id(); // null if guest
        $deviceToken  = $request->header('device-token');

        // product_id => table_name
        $tables = [
            8 => 'seed_forms',
            1 => 'veterinary_products',
            3 => 'synthetic_pesticides',
            7 => 'mineral_fertilizers',
            6 => 'organic_amendments',
            4 => 'inorganic_soil_conditioners',
            2 => 'animal_feeds',
            5 => 'bio_stimulants',
        ];

        $data = [];

        foreach ($tables as $productId => $table) {

            $data[$productId] = [];

            if (!\Schema::hasTable($table)) {
                continue;
            }

            if (!in_array('status_id', \Schema::getColumnListing($table))) {
                continue;
            }

            $records = \DB::table($table)
                ->where('status_id', 2)
                ->get()
                ->map(function ($item) use (
                    $productId,
                    $qrBaseUrl,
                    $uploadsBaseUrl,
                    $userId,
                    $deviceToken
                ) {

                    // Force product_id
                    $item->product_id = $productId;

                    // ================= QR CODE =================
                    $item->qr_code_url = !empty($item->qr_code_path)
                        ? $qrBaseUrl . basename($item->qr_code_path)
                        : null;

                    // ================= IMAGES =================
                    if (!empty($item->image_path)) {
                        $paths = json_decode($item->image_path, true);
                        $item->image_urls = is_array($paths)
                            ? array_map(fn($img) => $uploadsBaseUrl . ltrim($img, '/'), $paths)
                            : [$uploadsBaseUrl . ltrim($item->image_path, '/')];
                    } else {
                        $item->image_urls = [];
                    }

                    // ✅ ================= OTHER RECOMMENDATION PHOTO (FULL URL) =================
                    if (!empty($item->otherRecommendationsPhoto)) {
                        $item->otherRecommendationsPhoto =
                            $uploadsBaseUrl . ltrim($item->otherRecommendationsPhoto, '/');
                    } else {
                        $item->otherRecommendationsPhoto = null;
                    }

                    // ================= LIKE STATUS =================
                    $likeQuery = \DB::table('product_likes')
                        ->where('product_id', $productId)
                        ->where('product_row_id', $item->id);

                    if ($userId) {
                        $likeQuery->where('user_id', $userId);
                    } elseif ($deviceToken) {
                        $likeQuery->where('device_token', $deviceToken);
                    }

                    $like = $likeQuery->first();
                    $item->like_status = $like->like_status ?? 0;

                    // ================= DEFAULT ARRAYS =================
                    $item->raw_material = [];
                    $item->seed_id = [];
                    $item->raw_material_other = [];

                    // ================= SUPPLIER =================
                    if (!empty($item->supplier_id)) {
                        $supplier = \DB::table('suppliers')->where('id', $item->supplier_id)->first();
                        if ($supplier) {
                            $item->supplier = $supplier;
                            $item->supplier_name = $supplier->company_name ?? null;
                            $item->country_id = $supplier->country_id ?? null;
                            $item->latitude = $supplier->latitude ?? null;
                            $item->longitude = $supplier->longitude ?? null;
                        }
                    }

                    return $item;
                });

            $data[$productId] = $records->values();
        }

        return response()->json([
            'status'  => true,
            'message' => 'All active products fetched successfully',
            'data'    => $data
        ], 200);

    } catch (\Exception $e) {

        return response()->json([
            'status'  => false,
            'message' => 'Failed to fetch active products',
            'error'   => $e->getMessage()
        ], 500);
    }
}




public function getCountryData(Request $request)
    {
        $countryId = $request->country_id;
        $lang = $request->lang ?? 'en';
        $langId = $lang === 'fr' ? 2 : 1;

        if (!$countryId) {
            return response()->json([
                'status' => false,
                'message' => 'country_id is required'
            ], 400);
        }

        // Seed items (language wise)
        $seedItems = DB::table('seed')
                        ->where('language_id', $langId)
                        ->get(['id','name']);

        // Tables to show
        $tablesToShow = [
            'veterinary_products' => ['name'=>'Veterinary Products','columns'=>['product_name','manufacturing_lab','registration_number','route_of_administration','wholesale_price','semiwholesale_price','retail_price','supplier_id','status_id']],
            'synthetic_pesticides' => ['name'=>'Synthetic Pesticides','columns'=>['trade_name','active_ingredient','registration_number','other_function','wholesale_price','semiwholesale_price','retail_price','supplier_id','status_id']],
            'seed_forms' => ['name'=>'Seeds','columns'=>['cropName','verityName','registrationNumber','fruitColor','wholesalePrice','semiwholesalePrice','retailPrice','supplier_id','status_id']],
            'mineral_fertilizers' => ['name'=>'Mineral Fertilizers','columns'=>['trade_name','fertilizer_registration','mo','application_rate','fertilizer_wholesale_price','fertilizer_semiwholesale_price','fertilizer_retail_price','supplier_id','status_id']],
            'bio_stimulants' => ['name'=>'Bio Stimulants','columns'=>['physical_form','biostimulant_product','p2','wholesale_price','semiwholesale_price','retail_price','k2','supplier_id','status_id']],
            'animal_feeds' => ['name'=>'Animal Feeds','columns'=>['Typeoffeed','afrm','afEnergy','title','afWholesalePrice','afsemiwholesalePrice','afretailPrice','supplier_id','status_id']],
        ];

        // Count section
        $counts = [];
        foreach ($seedItems as $seed) {
            $tableKey = null;

            foreach ($tablesToShow as $key => $info) {
                if ($info['name'] == $seed->name) $tableKey = $key;
            }

            if ($tableKey && Schema::hasTable($tableKey)) {
                $count = DB::table($tableKey)
                        ->leftJoin('suppliers', $tableKey.'.supplier_id','=','suppliers.id')
                        ->where('suppliers.country_id', $countryId)
                        ->count();
            } else {
                $count = 0;
            }

            $counts[] = [
                'name' => $seed->name,
                'count' => $count
            ];
        }

        // Combined data
        $combinedData = collect();

        foreach ($tablesToShow as $tableName => $info) {
            if (!Schema::hasTable($tableName)) continue;

            $availableColumns = array_intersect($info['columns'], Schema::getColumnListing($tableName));

            $supplierIds = DB::table('suppliers')
                             ->where('country_id', $countryId)
                             ->pluck('id')
                             ->toArray();

            if (empty($supplierIds)) continue;

            $data = DB::table($tableName)
                        ->select(array_merge(['id'], $availableColumns))
                        ->whereIn('supplier_id', $supplierIds)
                        ->orderByDesc('id')
                        ->take(10)
                        ->get()
                        ->map(function ($item) use ($info, $tableName) {
                            $item->seed = $info['name'];
                            $item->table_name = $tableName;
                            return $item;
                        });

            $combinedData = $combinedData->merge($data);
        }

        return response()->json([
            'status' => true,
            'counts' => $counts,
            'data' => $combinedData->sortByDesc('id')->values(),
        ]);
    }



    public function getAllFormData(Request $request)
{
    try {
        $qrBaseUrl = 'https://fivoflow.com/wclm/public/qrcodes/';

        // Existing filters
        $countryId   = $request->query('country_id');
        $supplierId  = $request->query('supplier_id');
        $lat         = $request->query('lat');
        $lng         = $request->query('lng');
        $radius      = $request->query('radius', 10);

        // New filters
        $priceFrom   = $request->query('price_from');
        $priceTo     = $request->query('price_to');
        $region      = $request->query('region');      // text input
        $yieldInput  = $request->query('yield');       // text input
        $countryName = $request->query('country');     // region list input

        // All product tables
        $tables = [
            8 => \App\Models\SeedForm::class,
            1 => \App\Models\VeterinaryProduct::class,
            3 => \App\Models\SyntheticPesticide::class,
            7 => \App\Models\MineralFertilizer::class,
            4 => \App\Models\OrganicAmendment::class,
            6 => \App\Models\InorganicSoilConditioner::class,
            2 => \App\Models\AnimalFeed::class,
            5 => \App\Models\BioStimulant::class,
        ];

        $data = [];

        foreach ($tables as $key => $model) {
            $query = $model::query()->with('supplier.country'); // include country relation

            // ===== Supplier filters =====
            if ($supplierId) {
                $query->where('supplier_id', $supplierId);
            }

            if ($countryId) {
                $query->whereHas('supplier', function($q) use ($countryId) {
                    $q->where('country_id', $countryId);
                });
            }

            // NEW: Country name filter
            if ($countryName) {
                $query->whereHas('supplier.country', function($q) use ($countryName) {
                    $q->where('name', 'LIKE', "%$countryName%");
                });
            }

            // NEW: Region filter
            if ($region) {
                $query->whereHas('supplier', function($q) use ($region) {
                    $q->where('region', 'LIKE', "%$region%");
                });
            }

            // ===== Location Filter =====
            if ($lat && $lng) {
                $query->whereHas('supplier', function($q) use ($lat, $lng, $radius) {
                    $q->whereRaw(
                        "(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * 
                        cos(radians(longitude) - radians(?)) + 
                        sin(radians(?)) * sin(radians(latitude)))) <= ?",
                        [$lat, $lng, $lat, $radius]
                    );
                });
            }

            // ===== Price Filters =====
            if ($priceFrom) {
                $query->where('price', '>=', $priceFrom);
            }

            if ($priceTo) {
                $query->where('price', '<=', $priceTo);
            }

            // ===== Yield Filter =====
            if ($yieldInput) {
                // Yield column name depend karega model par
                $query->where(function ($q) use ($yieldInput) {
                    $q->where('yield', 'LIKE', "%$yieldInput%")
                      ->orWhere('expected_yield', 'LIKE', "%$yieldInput%");
                });
            }

            // Fetch data
            $data[$key] = $query->get()->map(function ($item) use ($qrBaseUrl) {

                $item->qr_code_url = $item->qr_code_path
                    ? $qrBaseUrl . basename($item->qr_code_path)
                    : null;

                if ($item->supplier) {
                    $item->supplier_name = $item->supplier->company_name;
                    $item->country_id    = $item->supplier->country_id;
                    $item->latitude      = $item->supplier->latitude;
                    $item->longitude     = $item->supplier->longitude;

                    // Region
                    $item->region        = $item->supplier->region ?? null;

                    // Country name
                    $item->country       = $item->supplier->country->name ?? null;
                }

                return $item;
            });
        }

        return response()->json([
            'status' => true,
            'message' => 'All form data fetched successfully',
            'data' => $data
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch data',
            'error' => $e->getMessage()
        ], 500);
    }
}



public function enqerytypeget(Request $request)
{
    // Ignore language_id, return all records
    $types = EnqeryType::all();

    return response()->json([
        'success' => true,
        'data' => $types
    ], 200);
}

public function closeChat(Request $request)
{
    $enquiryId = $request->post('enquiry_id');

    if (!$enquiryId) {
        return response()->json(['success' => false, 'message' => 'Enquiry ID is required'], 400);
    }

    // enquiry_messages → पहला message record
    $enquiryMessage = EnquiryMessage::where('enquiry_id', $enquiryId)->first();
    if (!$enquiryMessage) {
        return response()->json(['success' => false, 'message' => 'Enquiry Message not found'], 404);
    }

    // farmer_enquiries → main enquiry
    $farmerEnquiry = FarmerEnquiry::find($enquiryId);
    if (!$farmerEnquiry) {
        return response()->json(['success' => false, 'message' => 'Farmer Enquiry not found'], 404);
    }

    // 🔒 दोनों में integer status (1 = closed)
    $enquiryMessage->status = 1;
    $enquiryMessage->save();

    $farmerEnquiry->status = 1;
    $farmerEnquiry->save();

    return response()->json(['success' => true, 'message' => 'Chat closed successfully']);
}




    public function toggleLike(Request $request)
{
    $request->validate([
        'product_id'      => 'required|integer',
        'product_row_id'  => 'required|integer',
        'user_id'         => 'required|integer',
        'like_status'     => 'required|integer|in:1,2',
        'product_type'    => 'nullable|string',
        'device_id'       => 'nullable|string',
    ]);

    // INSERT/UPDATE DATA
    $data = [
        'product_id'     => $request->product_id,
        'product_row_id' => $request->product_row_id,
        'user_id'        => $request->user_id,
        'like_status'    => $request->like_status,
        'created_by'     => $request->user_id,
        'product_type'   => $request->product_type ?? null,
    ];

    // CHECK EXISTING LIKE
    $existing = DB::table('product_likes')
        ->where('product_id', $request->product_id)
        ->where('product_row_id', $request->product_row_id)
        ->where('user_id', $request->user_id)
        ->first();

    if ($existing) {
        // UPDATE
        DB::table('product_likes')
            ->where('id', $existing->id)
            ->update([
                'like_status' => $request->like_status,
                'updated_at' => now()
            ]);

        $message = 'Status updated successfully';
    } else {
        // INSERT
        $data['created_at'] = now();
        $data['updated_at'] = now();

        DB::table('product_likes')->insert($data);

        $message = 'Status added successfully';
    }

    return response()->json([
        'status'      => true,
        'message'     => $message,
        'like_status' => $request->like_status
    ]);
}


// public function getLikedProducts($user_id)
// {
//     if (!$user_id) {
//         return response()->json([
//             'status' => false,
//             'message' => 'User ID required',
//             'total_likes' => 0,
//             'data' => []
//         ], 400);
//     }

//     $likes = \DB::table('product_likes')
//         ->where('user_id', $user_id)
//         ->where('like_status', 1)
//         ->orderBy('id', 'desc')
//         ->get();

//     $finalData = [];

//     foreach ($likes as $like) {

//         // 🔹 Base data
//         $item = [
//             'like_id'        => $like->id,
//             'user_id'        => $like->user_id,
//             'product_id'     => $like->product_id,
//             'product_row_id' => $like->product_row_id,
//             'like_status'    => $like->like_status,
//         ];

//         // 🌱 Seed Forms
//         if ($data = \DB::table('seed_forms')
//             ->where('id', $like->product_row_id)
//             ->where('product_id', $like->product_id)
//             ->first()) {
//                             $data->like_status = $like->like_status;

//             $item['seed_form_data'] = $data;
//         }

//         // 🐄 Animal Feeds
//         if ($data = \DB::table('animal_feeds')
//             ->where('id', $like->product_row_id)
//             ->where('product_id', $like->product_id)
//             ->first()) {
//                             $data->like_status = $like->like_status;

//             $item['animal_feed_data'] = $data;
//         }

//         // 🧪 Bio Stimulants
//         if ($data = \DB::table('bio_stimulants')
//             ->where('id', $like->product_row_id)
//             ->where('product_id', $like->product_id)
//             ->first()) {
//                             $data->like_status = $like->like_status;

//             $item['bio_stimulant_data'] = $data;
//         }

//         // 🌍 Inorganic Soil Conditioners
//         if ($data = \DB::table('inorganic_soil_conditioners')
//             ->where('id', $like->product_row_id)
//             ->where('product_id', $like->product_id)
//             ->first()) {
//                             $data->like_status = $like->like_status;

//             $item['inorganic_soil_conditioner'] = $data;
//         }

//         // 🧂 Mineral Fertilizers
//         if ($data = \DB::table('mineral_fertilizers')
//             ->where('id', $like->product_row_id)
//             ->where('product_id', $like->product_id)
//             ->first()) {
//                             $data->like_status = $like->like_status;

//             $item['mineral_fertilizer_data'] = $data;
//         }

//         // 🌿 Organic Amendments
//         if ($data = \DB::table('organic_amendments')
//             ->where('id', $like->product_row_id)
//             ->where('product_id', $like->product_id)
//             ->first()) {
//                             $data->like_status = $like->like_status;

//             $item['organic_amendment_data'] = $data;
//         }

//         // ☠️ Synthetic Pesticides
//         if ($data = \DB::table('synthetic_pesticides')
//             ->where('id', $like->product_row_id)
//             ->where('product_id', $like->product_id)
//             ->first()) {
//                             $data->like_status = $like->like_status;

//             $item['synthetic_pesticide_data'] = $data;
//         }

//         // 🐕 Veterinary Products
//         if ($data = \DB::table('veterinary_products')
//             ->where('id', $like->product_row_id)
//             ->where('product_id', $like->product_id)
//             ->first()) {
//                             $data->like_status = $like->like_status;

//             $item['veterinary_product_data'] = $data;
//         }

//         // ❌ Skip if no module data found
//         if (count($item) === 5) {
//             continue;
//         }

//         $finalData[] = $item;
//     }

//     return response()->json([
//         'status' => true,
//         'message' => 'Liked products fetched successfully',
//         'total_likes' => count($finalData),
//         'data' => $finalData
//     ]);
// } live 
public function getLikedProducts($user_id)
{
    if (!$user_id) {
        return response()->json([
            'status' => false,
            'message' => 'User ID required',
            'total_likes' => 0,
            'data' => []
        ], 400);
    }

    $likes = \DB::table('product_likes')
        ->where('user_id', $user_id)
        ->where('like_status', 1)
        ->orderBy('id', 'desc')
        ->get();

    $finalData = [];

    foreach ($likes as $like) {

        // 🔹 Base data
        $item = [
            'like_id'        => $like->id,
            'user_id'        => $like->user_id,
            'product_id'     => $like->product_id,
            'product_row_id' => $like->product_row_id,
            'like_status'    => $like->like_status,
        ];

        $productData = null;

        // 🌱 Seed Forms
        $productData = \DB::table('seed_forms')
            ->where('id', $like->product_row_id)
            ->where('product_id', $like->product_id)
            ->first();

        // 🐄 Animal Feeds
        if (!$productData) {
            $productData = \DB::table('animal_feeds')
                ->where('id', $like->product_row_id)
                ->where('product_id', $like->product_id)
                ->first();
        }

        // 🧪 Bio Stimulants
        if (!$productData) {
            $productData = \DB::table('bio_stimulants')
                ->where('id', $like->product_row_id)
                ->where('product_id', $like->product_id)
                ->first();
        }

        // 🌍 Inorganic Soil Conditioners
        if (!$productData) {
            $productData = \DB::table('inorganic_soil_conditioners')
                ->where('id', $like->product_row_id)
                ->where('product_id', $like->product_id)
                ->first();
        }

        // 🧂 Mineral Fertilizers
        if (!$productData) {
            $productData = \DB::table('mineral_fertilizers')
                ->where('id', $like->product_row_id)
                ->where('product_id', $like->product_id)
                ->first();
        }

        // 🌿 Organic Amendments
        if (!$productData) {
            $productData = \DB::table('organic_amendments')
                ->where('id', $like->product_row_id)
                ->where('product_id', $like->product_id)
                ->first();
        }

        // ☠️ Synthetic Pesticides
        if (!$productData) {
            $productData = \DB::table('synthetic_pesticides')
                ->where('id', $like->product_row_id)
                ->where('product_id', $like->product_id)
                ->first();
        }

        // 🐕 Veterinary Products
        if (!$productData) {
            $productData = \DB::table('veterinary_products')
                ->where('id', $like->product_row_id)
                ->where('product_id', $like->product_id)
                ->first();
        }

        // ❌ Skip if no product found
        if (!$productData) {
            continue;
        }

        // ✅ Add like_status inside product data
        $productData->like_status = $like->like_status;

        // ✅ SINGLE CONSISTENT KEY
        $item['product_data'] = $productData;

        $finalData[] = $item;
    }

    return response()->json([
        'status' => true,
        'message' => 'Liked products fetched successfully',
        'total_likes' => count($finalData),
        'data' => $finalData
    ]);
}




 




public function createPreOrder(Request $request)
{
    // ================= VALIDATION =================
    $request->validate([
        'farmer_id'   => 'required|integer',
        'supplier_id' => 'required|integer',
        'product_id'  => 'required|integer',
        'quantity'    => 'required|numeric|min:1',
        'location'    => 'required|string',
        'order_type'  => 'required|string', // lowercase check later
        'description' => 'nullable|string'
    ]);

    // ================= ORDER TYPE NORMALIZE =================
    $orderType = strtolower($request->order_type);
    if (!in_array($orderType, ['pickup', 'delivery'])) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid order_type. Allowed: pickup, delivery'
        ], 422);
    }

    // ================= CREATE PRE-ORDER =================
    $preOrder = PreOrder::create([
        'farmer_id'   => $request->farmer_id,
        'supplier_id' => $request->supplier_id,
        'product_id'  => $request->product_id,
        'quantity'    => $request->quantity,
        'location'    => $request->location,
        'order_type'  => $orderType, // always saved as lowercase
        'description' => $request->description,
        'status'      => 'pending'
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Pre-order created successfully',
        'data' => $preOrder
    ]);
}



// public function createPreOrder(Request $request)
// {
//     $request->validate([
//         'farmer_id'   => 'required|integer',
//         'supplier_id' => 'required|integer',
//         'product_id'  => 'required|integer',
//         'quantity'    => 'required|numeric|min:1',
//         'location'    => 'required|string',
//         'order_type'  => 'required|in:pickup,delivery',
//         'description' => 'nullable|string'
//     ]);

//     $preOrder = PreOrder::create([
//         'farmer_id'   => $request->farmer_id,
//         'supplier_id' => $request->supplier_id,
//         'product_id'  => $request->product_id,
//         'quantity'    => $request->quantity,
//         'location'    => $request->location,
//         'order_type'  => $request->order_type,
//         'description' => $request->description,
//         'status'      => 'pending'
//     ]);

//     return response()->json([
//         'status' => true,
//         'message' => 'Pre-order created successfully',
//         'data' => $preOrder
//     ]);
// }






public function pendingPreOrders(Request $request)
{
    // Supplier ID request se lo
    $supplierId = $request->query('supplier_id');

    if (!$supplierId) {
        return response()->json([
            'status' => false,
            'message' => 'Supplier ID is required'
        ], 400);
    }

    // Pending pre-orders filter by supplier_id
    $data = PreOrder::where('status', 'pending')
                    ->where('supplier_id', $supplierId)
                    ->get()
                    ->map(function ($order) {
                        $order->quantity = (int) $order->quantity;
                        return $order;
                    });

    return response()->json([
        'status' => true,
        'data' => $data
    ]);
}

public function supplierResponse(Request $request)
{
    $request->validate([
        'pre_order_id' => 'required|integer',
        'supplier_id' => 'required|integer',
        'available_quantity' => 'required|numeric',
        'final_price' => 'required|numeric',
        'status' => 'required|in:pending,confirmed,rejected',
        'remarks' => 'nullable|string'
    ]);

    PreOrderSupplierResponse::create([
        'pre_order_id' => $request->pre_order_id,
        'supplier_id' => $request->supplier_id,
        'available_quantity' => $request->available_quantity,
        'final_price' => $request->final_price,
        'remarks' => $request->remarks,
        'status' => $request->status
    ]);

    PreOrder::where('id', $request->pre_order_id)->update([
        'status' => $request->status
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Supplier response submitted'
    ]);
}


public function farmerPreOrders($farmer_id)
{
    $data = PreOrder::with('supplierResponse')
        ->where('farmer_id', $farmer_id)
        ->get()
        ->map(function ($order) {

            // pre_orders quantity
            $order->quantity = (int) $order->quantity;

            // supplier response quantity (agar ho)
            if ($order->supplierResponse) {
                $order->supplierResponse->available_quantity =
                    (int) $order->supplierResponse->available_quantity;
            }

            return $order;
        });

    return response()->json([
        'status' => true,
        'data' => $data
    ]);
}




public function getOrderStatus()
{
    $data = OrderStatus::select('id', 'name', 'language_id')->get();

    return response()->json([
        'status' => true,
        'data' => $data
    ]);
}

public function priceTrend(Request $request)
{
    try {

        $validated = $request->validate([
            'language_id'     => 'nullable|integer', // frontend ke liye allowed
            'product_id'      => 'nullable|integer',
            'add_product_id'  => 'nullable|integer',
            'product_name'    => 'nullable|string',
            'supplier_id'     => 'nullable|integer',
            'from_date'       => 'nullable|date',
            'to_date'         => 'nullable|date',
            'price_cap'       => 'nullable|numeric', // 🔥 dynamic filter
        ]);

        $productTables = [
            8 => ['model' => \App\Models\SeedForm::class, 'search_fields' => ['cropName','verityName','breederName']],
            1 => ['model' => \App\Models\VeterinaryProduct::class, 'search_fields' => ['product_name','title']],
            2 => ['model' => \App\Models\AnimalFeed::class, 'search_fields' => ['title','Typeoffeed','afrm']],
            3 => ['model' => \App\Models\SyntheticPesticide::class, 'search_fields' => ['trade_name','function']],
            4 => ['model' => \App\Models\OrganicAmendment::class, 'search_fields' => ['trade_name','bio_label']],
            5 => ['model' => \App\Models\BioStimulant::class, 'search_fields' => ['biostimulant_product','action_mode']],
            6 => ['model' => \App\Models\InorganicSoilConditioner::class, 'search_fields' => ['trade_name','raw_material']],
            7 => ['model' => \App\Models\MineralFertilizer::class, 'search_fields' => ['trade_name','fertilizer_type']],
        ];

        $finalData = [];

        foreach ($productTables as $typeId => $info) {

            if (!empty($validated['product_id']) && $validated['product_id'] != $typeId) {
                continue;
            }

            $table = (new $info['model'])->getTable();

            $query = DB::table('price_histories as ph')
                ->leftJoin($table, "$table.id", '=', 'ph.add_product_id')
                ->leftJoin('suppliers as s', 's.id', '=', 'ph.supplier_id')
                ->where('ph.product_id', $typeId);

            // ❌ language_id filter REMOVED (column exist nahi karta)

            if (!empty($validated['supplier_id'])) {
                $query->where('ph.supplier_id', $validated['supplier_id']);
            }

            if (!empty($validated['add_product_id'])) {
                $query->where('ph.add_product_id', $validated['add_product_id']);
            }

            if (!empty($validated['product_name'])) {
                $query->where(function ($q) use ($info, $table, $validated) {
                    foreach ($info['search_fields'] as $field) {
                        $q->orWhere("$table.$field", 'LIKE', '%' . $validated['product_name'] . '%');
                    }
                });
            }

            if (!empty($validated['from_date'])) {
                $query->whereDate('ph.changed_at', '>=', $validated['from_date']);
            }

            if (!empty($validated['to_date'])) {
                $query->whereDate('ph.changed_at', '<=', $validated['to_date']);
            }

            $query->select(
                DB::raw('MIN(ph.id) as id'),
                'ph.product_id',
                'ph.add_product_id',
                'ph.supplier_id',
                DB::raw('DATE(ph.changed_at) as price_date'),
                DB::raw('AVG(ph.wholesalePrice) as avg_wholesale_price'),
                DB::raw('AVG(ph.semiwholesalePrice) as avg_semiwholesale_price'),
                DB::raw('AVG(ph.retailPrice) as avg_retail_price'),
                's.company_name',
                's.city'
            )
            ->groupBy(
                'ph.product_id',
                'ph.add_product_id',
                'ph.supplier_id',
                DB::raw('DATE(ph.changed_at)'),
                's.company_name',
                's.city'
            );

            // 🔥 CORE REQUIREMENT
            if (!empty($validated['price_cap'])) {
                $query->havingRaw(
                    'GREATEST(
                        AVG(ph.wholesalePrice),
                        AVG(ph.semiwholesalePrice),
                        AVG(ph.retailPrice)
                    ) <= ?',
                    [$validated['price_cap']]
                );
            }

            $finalData = array_merge($finalData, $query->get()->toArray());
        }

        return response()->json([
            'status' => true,
            'data'   => $finalData
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ]);
    }
}

// today work 
// public function priceTrend(Request $request)
// {
//     try {

//         $validated = $request->validate([
//             'product_id'     => 'nullable|integer',
//             'add_product_id' => 'nullable|integer',
//             'product_name'   => 'nullable|string',
//             'supplier_id'    => 'nullable|integer',
//             'from_date'      => 'nullable|date',
//             'to_date'        => 'nullable|date',
//         ]);

//         $productTables = [
//             8 => [
//                 'model' => \App\Models\SeedForm::class,
//                 'search_fields' => ['cropName','verityName','breederName']
//             ],
//             1 => [
//                 'model' => \App\Models\VeterinaryProduct::class,
//                 'search_fields' => ['product_name','title']
//             ],
//             2 => [
//                 'model' => \App\Models\AnimalFeed::class,
//                 'search_fields' => ['title','Typeoffeed','afrm']
//             ],
//             3 => [
//                 'model' => \App\Models\SyntheticPesticide::class,
//                 'search_fields' => ['trade_name','function']
//             ],
//             4 => [
//                 'model' => \App\Models\OrganicAmendment::class,
//                 'search_fields' => ['trade_name','bio_label']
//             ],
//             5 => [
//                 'model' => \App\Models\BioStimulant::class,
//                 'search_fields' => ['biostimulant_product','action_mode']
//             ],
//             6 => [
//                 'model' => \App\Models\InorganicSoilConditioner::class,
//                 'search_fields' => ['trade_name','raw_material']
//             ],
//             7 => [
//                 'model' => \App\Models\MineralFertilizer::class,
//                 'search_fields' => ['trade_name','fertilizer_type']
//             ],
//         ];

//         $finalData = [];

//         foreach ($productTables as $typeId => $info) {

//             if (!empty($validated['product_id']) && $validated['product_id'] != $typeId) {
//                 continue;
//             }

//             $table = (new $info['model'])->getTable();

//             $query = DB::table('price_histories as ph')
//                 ->leftJoin($table, "$table.id", '=', 'ph.add_product_id')
//                 ->leftJoin('suppliers as s', 's.id', '=', 'ph.supplier_id')
//                 ->where('ph.product_id', $typeId);

//             // supplier
//             if (!empty($validated['supplier_id'])) {
//                 $query->where('ph.supplier_id', $validated['supplier_id']);
//             }

//             // add product
//             if (!empty($validated['add_product_id'])) {
//                 $query->where('ph.add_product_id', $validated['add_product_id']);
//             }

//             // 🔥 PRODUCT NAME SEARCH (MULTI FIELD)
//             if (!empty($validated['product_name'])) {
//                 $query->where(function ($q) use ($info, $table, $validated) {
//                     foreach ($info['search_fields'] as $field) {
//                         $q->orWhere("$table.$field", 'LIKE', '%' . $validated['product_name'] . '%');
//                     }
//                 });
//             }

//             // date filters
//             if (!empty($validated['from_date'])) {
//                 $query->whereDate('ph.changed_at', '>=', $validated['from_date']);
//             }

//             if (!empty($validated['to_date'])) {
//                 $query->whereDate('ph.changed_at', '<=', $validated['to_date']);
//             }

//             $data = $query->select(
//                 DB::raw('MIN(ph.id) as id'),
//                 'ph.product_id',
//                 'ph.add_product_id',
//                 'ph.supplier_id',
//                 DB::raw('DATE(ph.changed_at) as price_date'),
//                 DB::raw('AVG(ph.wholesalePrice) as avg_wholesale_price'),
//                 DB::raw('AVG(ph.semiwholesalePrice) as avg_semiwholesale_price'),
//                 DB::raw('AVG(ph.retailPrice) as avg_retail_price'),
//                 's.company_name',
//                 's.city'
//             )
//             ->groupBy(
//                 'ph.product_id',
//                 'ph.add_product_id',
//                 'ph.supplier_id',
//                 DB::raw('DATE(ph.changed_at)'),
//                 's.company_name',
//                 's.city'
//             )
//             ->get()
//             ->toArray();

//             $finalData = array_merge($finalData, $data);
//         }

//         return response()->json([
//             'status' => true,
//             'data'   => $finalData
//         ]);

//     } catch (\Exception $e) {
//         return response()->json([
//             'status' => false,
//             'message' => $e->getMessage()
//         ]);
//     }
// }




// public function priceTrend(Request $request) lie code 
// {
//     try {
//         $validated = $request->validate([
//             'product_id'     => 'nullable|integer',
//             'add_product_id' => 'nullable|integer',
//             'product_name'   => 'nullable|string',
//             'search'         => 'nullable|string',
//             'supplier_id'    => 'nullable|integer',
//             'from_date'      => 'nullable|date',
//             'to_date'        => 'nullable|date',
//         ]);

//         $productTables = [
//             8 => ['model' => \App\Models\SeedForm::class, 'name_field' => 'cropName', 'search_fields' => ['cropName','breederName']],
//             1 => ['model' => \App\Models\VeterinaryProduct::class, 'name_field' => 'product_name', 'search_fields' => ['product_name','manufacturing_lab']],
//             3 => ['model' => \App\Models\SyntheticPesticide::class, 'name_field' => 'trade_name', 'search_fields' => ['trade_name','other_function']],
//             7 => ['model' => \App\Models\MineralFertilizer::class, 'name_field' => 'trade_name', 'search_fields' => ['trade_name','fertilizer_type']],
//             4 => ['model' => \App\Models\OrganicAmendment::class, 'name_field' => 'trade_name', 'search_fields' => ['trade_name','bio_label']],
//             6 => ['model' => \App\Models\InorganicSoilConditioner::class, 'name_field' => 'trade_name', 'search_fields' => ['trade_name','raw_material']],
//             2 => ['model' => \App\Models\AnimalFeed::class, 'name_field' => 'Typeoffeed', 'search_fields' => ['Typeoffeed']],
//             5 => ['model' => \App\Models\BioStimulant::class, 'name_field' => 'biostimulant_product', 'search_fields' => ['biostimulant_product','action_mode']],
//         ];

//         $priceTrend = [];

//         foreach ($productTables as $typeId => $info) {

//             // product_id filter
//             if (!empty($validated['product_id']) && $validated['product_id'] != $typeId) {
//                 continue;
//             }

//             $table        = (new $info['model'])->getTable();
//             $nameField    = $info['name_field'];
//             $searchFields = $info['search_fields'];

//             $query = DB::table('price_histories as ph')
//                 // ✅ FIXED JOIN (MOST IMPORTANT)
//                 ->leftJoin($table, "$table.id", '=', 'ph.add_product_id')
//                 ->leftJoin('suppliers as s', 's.id', '=', 'ph.supplier_id')
//                 ->select(
//                     DB::raw('MIN(ph.id) as id'),
//                     'ph.product_id',
//                     'ph.add_product_id',
//                     'ph.supplier_id',
//                     DB::raw('DATE(ph.changed_at) as price_date'),
//                     DB::raw('AVG(ph.wholesalePrice) as avg_wholesale_price'),
//                     DB::raw('AVG(ph.semiwholesalePrice) as avg_semiwholesale_price'),
//                     DB::raw('AVG(ph.retailPrice) as avg_retail_price'),
//                     DB::raw("$table.$nameField as product_name"),
//                     's.company_name',
//                     's.manager_name',
//                     's.name as supplier_name',
//                     's.city',
//                     's.phone',
//                     's.email'
//                 )
//                 ->where('ph.product_id', $typeId);

//             if (!empty($validated['add_product_id'])) {
//                 $query->where('ph.add_product_id', $validated['add_product_id']);
//             }

//             if (!empty($validated['product_name'])) {
//                 $query->where("$table.$nameField", 'LIKE', "%{$validated['product_name']}%");
//             }

//             if (!empty($validated['search'])) {
//                 $query->where(function ($q) use ($table, $searchFields, $validated) {
//                     foreach ($searchFields as $field) {
//                         $q->orWhere("$table.$field", 'LIKE', "%{$validated['search']}%");
//                     }
//                 });
//             }

//             if (!empty($validated['from_date'])) {
//                 $query->whereDate('ph.changed_at', '>=', $validated['from_date']);
//             }

//             if (!empty($validated['to_date'])) {
//                 $query->whereDate('ph.changed_at', '<=', $validated['to_date']);
//             }

//             $query->groupBy(
//                 'ph.product_id',
//                 'ph.add_product_id',
//                 'ph.supplier_id',
//                 DB::raw('DATE(ph.changed_at)'),
//                 "$table.$nameField",
//                 's.company_name',
//                 's.manager_name',
//                 's.name',
//                 's.city',
//                 's.phone',
//                 's.email'
//             );

//             $priceTrend = array_merge($priceTrend, $query->get()->toArray());
//         }

//         return response()->json([
//             'status' => true,
//             'data'   => $priceTrend
//         ]);

//     } catch (\Exception $e) {
//         return response()->json([
//             'status'  => false,
//             'message' => $e->getMessage()
//         ]);
//     }
// }

public function priceTrendExcel(Request $request)
{
    try {

        $validated = $request->validate([
            'product_id'     => 'nullable|integer',
            'add_product_id' => 'nullable|integer',
            'product_name'   => 'nullable|string',
            'search'         => 'nullable|string',
            'supplier_id'    => 'nullable|integer',
            'from_date'      => 'nullable|date',
            'to_date'        => 'nullable|date',
        ]);

        $productTables = [
            8 => ['model' => \App\Models\SeedForm::class, 'name_field' => 'cropName'],
            1 => ['model' => \App\Models\VeterinaryProduct::class, 'name_field' => 'product_name'],
            3 => ['model' => \App\Models\SyntheticPesticide::class, 'name_field' => 'trade_name'],
            7 => ['model' => \App\Models\MineralFertilizer::class, 'name_field' => 'trade_name'],
            4 => ['model' => \App\Models\OrganicAmendment::class, 'name_field' => 'trade_name'],
            6 => ['model' => \App\Models\InorganicSoilConditioner::class, 'name_field' => 'trade_name'],
            2 => ['model' => \App\Models\AnimalFeed::class, 'name_field' => 'title'],
            5 => ['model' => \App\Models\BioStimulant::class, 'name_field' => 'biostimulant_product'],
        ];

        $priceTrend = [];

        foreach ($productTables as $typeId => $info) {

            if (!empty($validated['product_id']) && $validated['product_id'] != $typeId) {
                continue;
            }

            $table     = (new $info['model'])->getTable();
            $nameField = $info['name_field'];

            $query = DB::table('price_histories as ph')
                ->leftJoin($table, "$table.id", '=', 'ph.add_product_id')
                ->leftJoin('suppliers as s', 's.id', '=', 'ph.supplier_id')
                ->select(
                    'ph.product_id', // ✅ PRODUCT ID
                    DB::raw('DATE(ph.changed_at) as price_date'),
                    "$table.$nameField as product_name",
                    's.name as supplier_name',
                    's.company_name',
                    's.city',
                    DB::raw('AVG(ph.wholesalePrice) as wholesale_price'),
                    DB::raw('AVG(ph.semiwholesalePrice) as semiwholesale_price'),
                    DB::raw('AVG(ph.retailPrice) as retail_price')
                )
                ->where('ph.product_id', $typeId);

            if (!empty($validated['add_product_id'])) {
                $query->where('ph.add_product_id', $validated['add_product_id']);
            }

            if (!empty($validated['supplier_id'])) {
                $query->where('ph.supplier_id', $validated['supplier_id']);
            }

            if (!empty($validated['product_name'])) {
                $query->where("$table.$nameField", 'LIKE', "%{$validated['product_name']}%");
            }

            if (!empty($validated['search'])) {
                $query->where("$table.$nameField", 'LIKE', "%{$validated['search']}%");
            }

            if (!empty($validated['from_date'])) {
                $query->whereDate('ph.changed_at', '>=', $validated['from_date']);
            }

            if (!empty($validated['to_date'])) {
                $query->whereDate('ph.changed_at', '<=', $validated['to_date']);
            }

            $query->groupBy(
                'ph.product_id', // ✅ GROUP BY PRODUCT ID
                DB::raw('DATE(ph.changed_at)'),
                "$table.$nameField",
                's.name',
                's.company_name',
                's.city'
            );

            $priceTrend = array_merge($priceTrend, $query->get()->toArray());
        }

        return Excel::download(
            new PriceTrendExcelExport($priceTrend),
            'price_trend_' . date('Ymd_His') . '.xlsx'
        );

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

// public function priceTrendExcel(Request $request)
// {
//     try {

//         $validated = $request->validate([
//             'product_id'     => 'nullable|integer',
//             'add_product_id' => 'nullable|integer',
//             'product_name'   => 'nullable|string',
//             'search'         => 'nullable|string',
//             'supplier_id'    => 'nullable|integer',
//             'from_date'      => 'nullable|date',
//             'to_date'        => 'nullable|date',
//         ]);

//         $productTables = [
//             8 => ['model' => \App\Models\SeedForm::class, 'name_field' => 'cropName', 'search_fields' => ['cropName','breederName']],
//             1 => ['model' => \App\Models\VeterinaryProduct::class, 'name_field' => 'product_name', 'search_fields' => ['product_name','manufacturing_lab']],
//             3 => ['model' => \App\Models\SyntheticPesticide::class, 'name_field' => 'trade_name', 'search_fields' => ['trade_name','other_function']],
//             7 => ['model' => \App\Models\MineralFertilizer::class, 'name_field' => 'trade_name', 'search_fields' => ['trade_name','fertilizer_type']],
//             4 => ['model' => \App\Models\OrganicAmendment::class, 'name_field' => 'trade_name', 'search_fields' => ['trade_name','bio_label']],
//             6 => ['model' => \App\Models\InorganicSoilConditioner::class, 'name_field' => 'trade_name', 'search_fields' => ['trade_name','raw_material']],
//             2 => ['model' => \App\Models\AnimalFeed::class, 'name_field' => 'Typeoffeed', 'search_fields' => ['Typeoffeed']],
//             5 => ['model' => \App\Models\BioStimulant::class, 'name_field' => 'biostimulant_product', 'search_fields' => ['biostimulant_product','action_mode']],
//         ];

//         $priceTrend = [];

//         foreach ($productTables as $typeId => $info) {

//             if (!empty($validated['product_id']) && $validated['product_id'] != $typeId) {
//                 continue;
//             }

//             $table     = (new $info['model'])->getTable();
//             $nameField = $info['name_field'];

//             $query = DB::table('price_histories as ph')
//                 ->leftJoin($table, "$table.id", '=', 'ph.add_product_id')
//                 ->leftJoin('suppliers as s', 's.id', '=', 'ph.supplier_id')
//                 ->select(
//                     DB::raw('DATE(ph.changed_at) as price_date'),
//                     "$table.$nameField as product_name",
//                     's.name as supplier_name',
//                     's.company_name',
//                     's.city',
//                     DB::raw('AVG(ph.wholesalePrice) as wholesale_price'),
//                     DB::raw('AVG(ph.semiwholesalePrice) as semiwholesale_price'),
//                     DB::raw('AVG(ph.retailPrice) as retail_price')
//                 )
//                 ->where('ph.product_id', $typeId);

//             if (!empty($validated['add_product_id'])) {
//                 $query->where('ph.add_product_id', $validated['add_product_id']);
//             }

//             if (!empty($validated['supplier_id'])) {
//                 $query->where('ph.supplier_id', $validated['supplier_id']);
//             }

//             if (!empty($validated['product_name'])) {
//                 $query->where("$table.$nameField", 'LIKE', "%{$validated['product_name']}%");
//             }

//             if (!empty($validated['search'])) {
//                 $query->where("$table.$nameField", 'LIKE', "%{$validated['search']}%");
//             }

//             if (!empty($validated['from_date'])) {
//                 $query->whereDate('ph.changed_at', '>=', $validated['from_date']);
//             }

//             if (!empty($validated['to_date'])) {
//                 $query->whereDate('ph.changed_at', '<=', $validated['to_date']);
//             }

//             $query->groupBy(
//                 DB::raw('DATE(ph.changed_at)'),
//                 "$table.$nameField",
//                 's.name',
//                 's.company_name',
//                 's.city'
//             );

//             $priceTrend = array_merge($priceTrend, $query->get()->toArray());
//         }

//         return Excel::download(
//             new PriceTrendExcelExport($priceTrend),
//             'price_trend_' . date('Ymd_His') . '.xlsx'
//         );

//     } catch (\Exception $e) {
//         return response()->json([
//             'status' => false,
//             'message' => $e->getMessage()
//         ], 500);
//     }
// }




public function productListWithAverage(Request $request)
{
    $categoryId = $request->get('category'); // seed table ID (ex: 8)
    $supplierId = $request->get('supplier_id');

    if (!$categoryId) {
        return response()->json([
            'status' => false,
            'message' => 'Category ID is required'
        ], 422);
    }

    /**
     * 🔹 Get category from seed table
     */
    $seedCategory = DB::table('seed')->where('id', $categoryId)->first();

    if (!$seedCategory) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid category ID'
        ], 422);
    }

    /**
     * 🔹 seed.name → product table mapping
     */
    $categoryTableMap = [
        'Seeds'                       => 'seed_forms',
        'Animal Feed'                 => 'animal_feeds',
        'Biostimulants'               => 'bio_stimulants',
        'Organic Amendments'          => 'organic_amendments',
        'Mineral Fertilizers'         => 'mineral_fertilizers',
        'Synthetic Pesticides'        => 'synthetic_pesticides',
        'Veterinary Products'         => 'veterinary_products',
        'Inorganic Soil Conditioners' => 'inorganic_soil_conditioners',
    ];

    $categoryName = $seedCategory->name;

    if (!isset($categoryTableMap[$categoryName])) {
        return response()->json([
            'status' => false,
            'message' => 'No product table mapped for this category'
        ], 422);
    }

    $table = $categoryTableMap[$categoryName];

    /**
     * 🔹 Price column mapping
     */
    $priceMap = [
        'seed_forms' => ['wholesalePrice', 'semiwholesalePrice', 'retailPrice'],
        'animal_feeds' => ['afWholesalePrice', 'afsemiwholesalePrice', 'afretailPrice'],
        'mineral_fertilizers' => ['fertilizer_wholesale_price', 'fertilizer_semiwholesale_price', 'fertilizer_retail_price'],
        'bio_stimulants' => ['wholesale_price', 'semiwholesale_price', 'retail_price'],
        'organic_amendments' => ['wholesale_price', 'semiwholesale_price', 'retail_price'],
        'synthetic_pesticides' => ['wholesale_price', 'semiwholesale_price', 'retail_price'],
        'veterinary_products' => ['wholesale_price', 'semiwholesale_price', 'retail_price'],
        'inorganic_soil_conditioners' => ['wholesale_price', 'semiwholesale_price', 'retail_price'],
    ];

    [$w, $sw, $r] = $priceMap[$table];

    /**
     * 🔹 Fetch products
     */
    $products = DB::table($table)
        ->where('status_id', 2) // approved only
        ->when($supplierId, fn ($q) => $q->where('supplier_id', $supplierId))
        ->get()
        ->map(function ($row) use ($w, $sw, $r) {

            $prices = collect([
                $row->$w ?? 0,
                $row->$sw ?? 0,
                $row->$r ?? 0,
            ])->filter(fn ($v) => $v > 0)->values();

            return [
                'id' => $row->id,
                'trade_name' => $row->trade_name ?? $row->title ?? '-',
                'prices_vertical' => $prices,   // vertical numbers
                'average_price' => $prices->count()
                    ? round($prices->avg(), 2)
                    : 0,
                'qr_code' => $row->qr_code_path ?? null,
            ];
        });

    return response()->json([
        'status' => true,
        'category_id' => $categoryId,
        'category_name' => $categoryName,
        'data' => $products
    ]);
}



    public function downloadCategoryCSV(Request $request)
    {
        $category = $request->get('category');
        $ids = $request->get('product_ids'); // array

        if (!$category || !$ids || !is_array($ids)) {
            return response()->json([
                'status' => false,
                'message' => 'Category and product_ids[] required'
            ], 422);
        }

        $fileName = $category . '_products.csv';

        $response = new StreamedResponse(function () use ($category, $ids) {

            $handle = fopen('php://output', 'w');

            $rows = DB::table($category)
                ->whereIn('id', $ids)
                ->get();

            if ($rows->isEmpty()) {
                fclose($handle);
                return;
            }

            // Header
            fputcsv($handle, array_keys((array)$rows->first()));

            foreach ($rows as $row) {
                // 🔹 remove zero values
                $cleanRow = array_filter((array)$row, function ($val) {
                    return !($val === 0 || $val === '0');
                });

                fputcsv($handle, $cleanRow);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename=$fileName");

        return $response;
    }


}




