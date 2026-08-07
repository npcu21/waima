<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AnnouncementController extends Controller
{
    // List all announcements filtered by the user's language
//     public function index(Request $request)
// {
//     $userId = $request->user_id; // token use kar rahe ho to auth()->id() use kar sakte ho

//     if (!$userId) {
//         return response()->json([
//             'status' => false,
//             'message' => 'User ID is required'
//         ], 400);
//     }

//     $user = User::find($userId);
//     if (!$user) {
//         return response()->json([
//             'status' => false,
//             'message' => 'User not found'
//         ], 404);
//     }

//     $announcements = Announcement::byCreatorLanguage($user->language_id)->get();

//     // Map announcements to only required fields
//     $data = $announcements->map(function ($announcement) {
//         return [
//             'title' => $announcement->title,
//             'description' => $announcement->description,
//             'user_type_id' => $announcement->user_type_id,
//             'created_by' => $announcement->created_by,
//             'status' => $announcement->status,
//             'created_at' => $announcement->created_at,
//             'updated_at' => $announcement->updated_at,
//             'id' => $announcement->id,
//         ];
//     });

//     return response()->json([
//         'status' => true,
//         'message' => 'Announcements retrieved successfully',
//         'data' => $data
//     ]);
// }
// public function index(Request $request, $id = null)
// {
//     $userId = $request->user_id;

//     if (!$userId) {
//         return response()->json([
//             'status' => false,
//             'message' => 'User ID is required'
//         ], 400);
//     }

//     $user = User::find($userId);
//     if (!$user) {
//         return response()->json([
//             'status' => false,
//             'message' => 'User not found'
//         ], 404);
//     }

//     // If ID provided → show only one announcement
//     if ($id) {
//         $announcement = Announcement::where('id', $id)
//                                     ->where('language_id', $user->language_id)
//                                     ->first();

//         if (!$announcement) {
//             return response()->json([
//                 'status' => false,
//                 'message' => 'Announcement not found'
//             ], 404);
//         }

//         return response()->json([
//             'status' => true,
//             'message' => 'Announcement retrieved successfully',
//             'data' => [
//                 'title' => $announcement->title,
//                 'description' => $announcement->description,
//                 'user_type_id' => $announcement->user_type_id,
//                 'created_by' => $announcement->created_by,
//                 'status' => $announcement->status,
//                 'created_at' => $announcement->created_at,
//                 'updated_at' => $announcement->updated_at,
//                 'id' => $announcement->id,
//             ]
//         ]);
//     }

//     // ELSE → show all announcements
//     $announcements = Announcement::byCreatorLanguage($user->language_id)->get();

//     $data = $announcements->map(function ($announcement) {
//         return [
//             'title' => $announcement->title,
//             'description' => $announcement->description,
//             'user_type_id' => $announcement->user_type_id,
//             'created_by' => $announcement->created_by,
//             'status' => $announcement->status,
//             'created_at' => $announcement->created_at,
//             'updated_at' => $announcement->updated_at,
//             'id' => $announcement->id,
//         ];
//     });

//     return response()->json([
//         'status' => true,
//         'message' => 'Announcements retrieved successfully',
//         'data' => $data
//     ]);
// }
public function index(Request $request, $id = null)
{
    // Language ID get from URL (default = 1)
    $languageId = $request->language_id ?? 1;

    // Language set for response heading
    $languageName = $languageId == 2 ? "French" : "English";

    // USER CHECK REMOVE → NO NEED USER LANGUAGE FILTER
    // Because you want same data for all language

    // If ID provided → show only one announcement
    if ($id) {
        $announcement = Announcement::where('id', $id)->first();

        if (!$announcement) {
            return response()->json([
                'status' => false,
                'message' => 'Announcement not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'language' => $languageName,
            'message' => 'Announcement retrieved successfully',
            'data' => [
                'title' => $announcement->title,
                'description' => $announcement->description,
                'user_type_id' => $announcement->user_type_id,
                'created_by' => $announcement->created_by,
                'status' => $announcement->status,
                'created_at' => $announcement->created_at,
                'updated_at' => $announcement->updated_at,
                'id' => $announcement->id,
            ]
        ]);
    }

    // Show ALL announcements WITHOUT language filter
    $announcements = Announcement::orderBy('id', 'DESC')->get();

    $data = $announcements->map(function ($announcement) {
        return [
            'title' => $announcement->title,
            'description' => $announcement->description,
            'user_type_id' => $announcement->user_type_id,
            'created_by' => $announcement->created_by,
            'status' => $announcement->status,
            'created_at' => $announcement->created_at,
            'updated_at' => $announcement->updated_at,
            'id' => $announcement->id,
        ];
    });

    return response()->json([
        'status' => true,
        'language' => $languageName,
        'message' => 'Announcements retrieved successfully',
        'data' => $data
    ]);
}


    // Show single announcement
//     public function show($id)
// {
//     $announcement = Announcement::find($id);

//     if (!$announcement) {
//         return response()->json([
//             'status' => false,
//             'message' => 'Announcement not found'
//         ], 404);
//     }

//     // Return only the fields you want
//     $data = [
//         'title' => $announcement->title,
//         'description' => $announcement->description,
//         'user_type_id' => $announcement->user_type_id,
//         'created_by' => $announcement->created_by,
//         'status' => $announcement->status,
//         'created_at' => $announcement->created_at,
//         'updated_at' => $announcement->updated_at,
//         'id' => $announcement->id,
//     ];

//     return response()->json([
//         'status' => true,
//         'message' => 'Announcement retrieved successfully',
//         'data' => $data
//     ]);
// }
public function show($id)
{
    $announcement = Announcement::find($id);

    if (!$announcement) {
        return response()->json([
            'status' => false,
            'message' => 'Announcement not found'
        ], 404);
    }

    $data = [
        'id' => $announcement->id,
        'title' => $announcement->title,
        'description' => $announcement->description,
        'image' => $announcement->image ? url($announcement->image) : null, // <-- IMAGE URL
        'user_type_id' => $announcement->user_type_id,
        'created_by' => $announcement->created_by,
        'status' => $announcement->status,
        'created_at' => $announcement->created_at,
        'updated_at' => $announcement->updated_at,
    ];

    return response()->json([
        'status' => true,
        'message' => 'Announcement retrieved successfully',
        'data' => $data
    ]);
}


    // Store new announcement
// Create new announcement
 public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'user_type_id' => 'required|integer',
            'created_by' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $announcement = Announcement::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_type_id' => $request->user_type_id,
            'created_by' => $request->created_by,
            'status' => 'Active',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Announcement created successfully',
            'data' => $announcement
        ]);
    }


    // Update announcement
 // Update announcement
public function update(Request $request, $id)
{
    // Find announcement
    $announcement = Announcement::find($id);
    if (!$announcement) {
        return response()->json([
            'status' => false,
            'message' => 'Announcement not found'
        ], 404);
    }

    // Validation
    $validator = Validator::make($request->all(), [
        'title' => 'sometimes|required|string|max:255',
        'description' => 'sometimes|required|string',
        'user_type_id' => 'sometimes|required|integer|exists:user_types,id',
        'status' => 'sometimes|required|in:Active,Inactive',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    // Update only validated fields
    $announcement->update($validator->validated());

    return response()->json([
        'status' => true,
        'message' => 'Announcement updated successfully',
        'data' => $announcement
    ]);
}


    // Delete announcement
   // Delete announcement
public function destroy($id)
{
    // Find announcement by ID
    $announcement = Announcement::find($id);

    // Agar announcement exist nahi karta
    if (!$announcement) {
        return response()->json([
            'status' => false,
            'message' => 'Announcement not found'
        ], 404);
    }

    // Delete announcement
    $announcement->delete();

    // Return JSON response
    return response()->json([
        'status' => true,
        'message' => 'Announcement deleted successfully'
    ]);
}
// New method: List all announcements (all entries, no filter)
// public function allAnnouncements()
// {
//     $announcements = Announcement::all();

//     $data = $announcements->map(function ($announcement) {
//         $creator = User::find($announcement->created_by);
//         $creatorName = $creator ? $creator->name : null; // full name of creator

//         return [
//             'id' => $announcement->id,
//             'title' => $announcement->title,
//             'description' => $announcement->description,
//             'user_type_id' => $announcement->user_type_id,
//             'created_by' => $announcement->created_by,
//             // 'created_by_name' => $creatorName,
//             'status' => $announcement->status,
//             'created_at' => $announcement->created_at,
//             'updated_at' => $announcement->updated_at,
//         ];
//     });

//     return response()->json([
//         'status' => true,
//         'message' => 'All announcements retrieved successfully',
//         'data' => $data
//     ]);
// }

public function allAnnouncements()
{
    $announcements = Announcement::all();

    $data = $announcements->map(function ($announcement) {

        return [
            'id' => $announcement->id,
            'title' => $announcement->title,
            'description' => $announcement->description,
            'image' => $announcement->image ? url($announcement->image) : null,
            'user_type_id' => $announcement->user_type_id,
            'created_by' => $announcement->created_by,
            'status' => $announcement->status,
            'created_at' => $announcement->created_at,
            'updated_at' => $announcement->updated_at,
        ];
    });

    return response()->json([
        'status' => true,
        'message' => 'All announcements retrieved successfully',
        'data' => $data
    ]);
}



}
