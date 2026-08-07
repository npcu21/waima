<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Language;

class LanguageController extends Controller
{
    /**
     * Show all languages
     */
    public function index()
    {
        $languages = Language::orderBy('id', 'desc')->get();
        return view('languages.index', compact('languages'));
    }

    /**
     * Show the form to create a new language
     */
    public function create()
    {
        return view('languages.create');
    }

    /**
     * Store a new language
     */
    public function store(Request $request)
    {
        $request->validate([
            'lang_code' => 'required|string|max:5|unique:languages,lang_code',
            'lang_name' => 'required|string|max:50',
        ]);

        Language::create([
            'lang_code' => $request->lang_code,
            'lang_name' => $request->lang_name,
        ]);

        return redirect()->route('languages.index')
                         ->with('message', 'Language added successfully!');
    }

    /**
     * Show the form to edit a language
     */
    public function edit($id)
    {
        $language = Language::findOrFail($id);
        return view('languages.edit', compact('language'));
    }

    /**
     * Update an existing language
     */
    public function update(Request $request, $id)
    {
        $language = Language::findOrFail($id);

        $request->validate([
            'lang_code' => 'required|string|max:5|unique:languages,lang_code,' . $id,
            'lang_name' => 'required|string|max:50',
        ]);

        $language->lang_code = $request->lang_code;
        $language->lang_name = $request->lang_name;
        $language->save();

        return redirect()->route('languages.index')
                         ->with('message', 'Language updated successfully!');
    }

    /**
     * Delete a language
     */
    public function destroy($id)
    {
        $language = Language::findOrFail($id);
        $language->delete();

        return redirect()->route('languages.index')
                         ->with('message', 'Language deleted successfully!');
    }
}
