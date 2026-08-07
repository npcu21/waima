<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function count()
    {
        $count = Notification::where('is_read', 0)->count();
        return response()->json(['count' => $count]);
    }
// public function list()
// {
//     $data = Notification::where('is_read', 0)   // Only unread
//                         ->latest()
//                         ->limit(20)
//                         ->get();

//     return response()->json(['notifications' => $data]);
// }
public function list()
{
    $notifications = Notification::where('is_read', 0)
        ->latest()
        ->limit(20)
        ->get()
        ->map(function($n) {
            return [
                'id' => $n->id,
                'title' => $n->title,
                'message' => $n->message,
                'is_read' => $n->is_read,
                'table_name' => $n->table_name, // <-- add this
                'record_id' => $n->record_id,   // <-- add this
            ];
        });

    return response()->json(['notifications' => $notifications]);
}


    // public function list()
    // {
    //     $data = Notification::latest()->limit(20)->get();
    //     return response()->json(['notifications' => $data]);
    // }

    // public function markRead($id)
    // {
    //     Notification::where('id', $id)->update(['is_read' => 1]);
    //     return response()->json(['success' => true]);
    // }
    public function markRead($id)
{
    // Mark as read
    Notification::where('id', $id)->update(['is_read' => 1]);

    // Get updated unread count
    $count = Notification::where('is_read', 0)->count();

    return response()->json([
        'success' => true,
        'count' => $count
    ]);
}

}
