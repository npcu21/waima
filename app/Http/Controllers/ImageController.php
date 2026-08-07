<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends Controller
{
    // Show upload form
    public function create()
    {
        return view('images.create');
    }

    // Store uploaded images (all in one record)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'images.*' => 'required|image|max:5120', // multiple images
        ]);

        $uploadedUrls = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $filename = time() . "_" . $imageFile->getClientOriginalName();

                $ftp_server = "173.201.186.254";
                $ftp_user_name = "reena@fivoflow.com";
                $ftp_user_pass = "YOUR_PASSWORD"; // Replace with actual password
                $remote_file = "/wclm/public/uploads/" . $filename;
                $local_file = $imageFile->getRealPath();

                $publicUrl = null;

                // FTP Upload
                $conn_id = ftp_connect($ftp_server);
                if ($conn_id && @ftp_login($conn_id, $ftp_user_name, $ftp_user_pass)) {
                    ftp_pasv($conn_id, true); // Passive mode
                    if (ftp_put($conn_id, $remote_file, $local_file, FTP_BINARY)) {
                        $publicUrl = "https://fivoflow.com/wclm/public/uploads/" . $filename;
                    }
                    ftp_close($conn_id);
                }

                // Fallback to local storage
                if (!$publicUrl) {
                    $imageFile->move(public_path('uploads'), $filename);
                    $publicUrl = url('uploads/' . $filename);
                }

                $uploadedUrls[] = $publicUrl;
            }

            // Save all uploaded URLs in one record as JSON
            Image::create([
                'name' => $request->name,
                'description' => $request->description,
                'image_path' => json_encode($uploadedUrls),
            ]);
        }

        return redirect()->back()->with('success', 'Images uploaded successfully!');
    }

    // Show all uploaded images
    public function index()
    {
        $images = Image::all();
        return view('images.index', compact('images'));
    }
}
