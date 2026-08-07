<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Usertype;
use App\Models\Country;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
    // public function create()
    // {
    //     $usertypes = Usertype::where('id', 3)->get(); // केवल id=3
    //     $countries = Country::all(); // सभी countries

    //     return view('admin.add_document', compact('usertypes', 'countries'));
    // }
//  public function create()
//     {
//         $usertypes = Usertype::all(); 
//         $countries = Country::all(); 

//         return view('admin.add_document', compact('usertypes', 'countries'));
//     }
public function create()
{
    // ---------------- LANGUAGE SETUP ----------------
    $user = auth()->user(); // If you already have $user, remove this line

    // Default language ID (use current session lang or existing user lang)
    $lang = session('lang', 'en');
    App::setLocale($lang);
    $defaultLangId = $user->language_id ?? 1;


    // ---------------- FETCH DATA ----------------
    $usertypes = Usertype::all(); 
    $countries = Country::all(); 

    return view('admin.add_document', compact('usertypes', 'countries', 'defaultLangId'));
}

public function store(Request $request)
{
    // ✅ Validation
    $request->validate([
        'document_name' => 'required|string|max:255',
        'usertype_id'   => 'required|exists:usertype,id',  // correct table name
        'country_id'    => 'nullable|exists:countries,id', // fixed table name
        'document_file' => 'required|file|mimes:pdf,xlsx,csv|max:10240', // 10MB max
    ]);

    // ✅ File Upload
    $filename = null;
    if ($request->hasFile('document_file')) {
        $file = $request->file('document_file');
        $filename = Str::slug($request->document_name) . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('documents'), $filename);
    }

    // ✅ Insert into documents table
    \App\Models\Document::create([
        'name'        => $request->document_name,
        'usertype_id' => $request->usertype_id,
        'country_id'  => $request->country_id,
        'file_path'   => 'documents/' . $filename,
        'created_by'  => auth()->id() ?? null,
    ]);

    return redirect()->back()->with('success', 'Document uploaded successfully!');
}

//    public function store(Request $request)
// {
//     // ✅ Validation
//     $request->validate([
//         'document_name' => 'required|string|max:255',
//         'usertype_id' => 'required|exists:usertype,id', // database table name exactly यही है
//         'country_id' => 'nullable|exists:country,id',   // optional
//         'document_file' => 'required|file|mimes:pdf,xlsx,csv|max:10240', // 10MB max
//     ]);

//     // ✅ File Upload
//     $filename = null;
//     if ($request->hasFile('document_file')) {
//         $file = $request->file('document_file');
//         $filename = Str::slug($request->document_name) . '_' . time() . '.' . $file->getClientOriginalExtension();
//         $file->move(public_path('documents'), $filename);
//     }

//     // ✅ Insert into documents table
//     \App\Models\Document::create([
//         'name' => $request->document_name,
//         'usertype_id' => $request->usertype_id,
//         'country_id' => $request->country_id,
//         'file_path' => 'documents/' . $filename,
//         'created_by' => auth()->id() ?? null,
//     ]);

//     return redirect()->back()->with('success', 'Document uploaded successfully!');
// }

    // Show list of documents
// public function index()
// {
//     // Eager load usertype
//     $documents = \App\Models\Document::with('usertype')->get();

//     return view('admin.documents_list', compact('documents'));
// }
// public function index(Request $request)
// {
//     // Eager load relationships
//     $query = \App\Models\Document::with(['usertype', 'country']);

//     // ✅ Country filter
//     if ($request->filled('country_id')) {
//         $query->where('country_id', $request->country_id);
//     }

//     $documents = $query->get();

//     // Get all countries for the filter dropdown
//     $countries = \App\Models\Country::all();

//     return view('admin.documents_list', compact('documents', 'countries'));
// }

public function index(Request $request)
{
    // ---------------- LANGUAGE SETUP ----------------
    $user = auth()->user(); // If you already have $user, remove this line

    // Default language ID (use current session lang or user lang)
    $lang = session('lang', 'en');
    App::setLocale($lang);
    $defaultLangId = $user->language_id ?? 1;


    // ---------------- DOCUMENT QUERY ----------------
    // Eager load relationships
    $query = \App\Models\Document::with(['usertype', 'country']);

    // Country filter
    if ($request->filled('country_id')) {
        $query->where('country_id', $request->country_id);
    }

    $documents = $query->get();

    // Get all countries for the filter dropdown
    $countries = \App\Models\Country::all();

    return view('admin.documents_list', compact('documents', 'countries', 'defaultLangId'));
}


// Delete a document
public function destroy($id)
{
    $document = \App\Models\Document::findOrFail($id);

    // Delete file from public folder if exists
    if (file_exists(public_path($document->file_path))) {
        unlink(public_path($document->file_path));
    }

    // Delete database record
    $document->delete();

    return redirect()->back()->with('success', 'Document deleted successfully!');
}

}
