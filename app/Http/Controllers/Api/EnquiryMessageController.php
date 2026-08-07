<?php

namespace App\Http\Controllers\Api; // <--- yahi change karein

use Illuminate\Http\Request;
use App\Models\EnquiryMessage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class EnquiryMessageController extends Controller
{
    public function index()
    {
        $messages = EnquiryMessage::all();
        return response()->json([
            'success' => true,
            'data' => $messages
        ]);
    }

    public function show($id)
    {
        $message = EnquiryMessage::find($id);

        if (!$message) {
            return response()->json([
                'success' => false,
                'message' => 'Message not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $message
        ]);
    }
    public function getComplementaryData($table_record_id = null)
    {
        $query = DB::table('allcomplementary');

        // Filter if table_record_id provided
        if (!empty($table_record_id)) {
            $query->where('table_record_id', $table_record_id);
        }

        $data = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'Complementary Data Retrieved',
            'data' => $data
        ]);
    }


}
