<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class CountryController extends Controller
{
    public function create()
    {
        $user = auth()->user();
        $lang = session('lang', 'en');
        App::setLocale($lang);
        $defaultLangId = $user->language_id ?? 1;

        return view('country.add_country', compact('defaultLangId'));
    }

    // Store Country with automatic currency
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:10',
            'language_id' => 'nullable|integer',
        ]);

        // -------------------- COUNTRY CODE TO CURRENCY --------------------
        $currencyMap = [
            'IN' => 'INR', // India
            'US' => 'USD', // USA
            'GB' => 'GBP', // UK
            'CA' => 'CAD', // Canada
            'AU' => 'AUD', // Australia
            'JP' => 'JPY', // Japan
            'CN' => 'CNY', // 
           ' SL' => 'SLL', // Sierra Leone
        'CI' => 'XOF', // Ivory Coast
        ];

        $countryCode = strtoupper($request->code ?? '');
        $currency = $currencyMap[$countryCode] ?? 'USD'; // default USD अगर mapping नहीं मिली

        // -------------------- INSERT COUNTRY --------------------
        DB::table('countries')->insert([
            'name' => $request->name,
            'code' => $request->code,
            'language_id' => $request->language_id,
            'currency' => $currency,           // automatic currency
            'created_by' => auth()->id() ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', "Country added successfully with currency: $currency");
    }


    public function list(Request $request)
{
    // Get selected language (default: English)
   $user = auth()->user(); // If user exists

    // Default language ID (use current session lang or user's saved lang)
    $lang = session('lang', 'en');
    App::setLocale($lang);
    $defaultLangId = $user->language_id ?? 1;

    // Fetch countries
    $countries = DB::table('countries')->orderBy('id', 'desc')->get();

    // Return view with data + selected language
    return view('country.list_country', compact('countries', 'defaultLangId'));
}


    // List all countries
    // public function list()
    // {
    //     $countries = DB::table('countries')->orderBy('id', 'desc')->get();
    //     return view('country.list_country', compact('countries'));
    // }

    // Show edit form
    // public function edit($id)
    // {
    //     $country = DB::table('countries')->where('id', $id)->first();

    //     if (!$country) {
    //         return redirect()->back()->with('error', 'Country not found');
    //     }

    //     return view('country.edit_country', compact('country'));
    // }

 public function edit(Request $request, $id)
{
    // Fetch country first
    $country = DB::table('countries')->where('id', $id)->first();
    if (!$country) {
        return redirect()->back()->with('error', __('country.not_found'));
    }

    // Get logged-in user safely
    $user = auth()->user();

    // Determine language
    if ($request->has('lang')) {
        $lang = $request->get('lang');
    } elseif ($user && $user->language_id == 2) {
        $lang = 'fr';
    } else {
        $lang = session('lang', 'en'); // default: English
    }

    session(['lang' => $lang]); // Save in session
    App::setLocale($lang);

    // Default language ID (if user exists)
    $defaultLangId = $user->language_id ?? 1;

    return view('country.edit_country', compact('country', 'lang', 'defaultLangId'));
}

    // Update country
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:10',
            'language_id' => 'nullable|integer',
        ]);

        $updated = DB::table('countries')->where('id', $id)->update([
            'name' => $request->name,
            'code' => $request->code,
            'language_id' => $request->language_id,
            'updated_at' => now(),
        ]);

        if ($updated) {
            return redirect()->route('country.list')->with('success', 'Country updated successfully');
        } else {
            return redirect()->back()->with('error', 'Nothing to update or Country not found');
        }
    }

    // Delete country
    public function delete($id)
    {
        $deleted = DB::table('countries')->where('id', $id)->delete();

        if ($deleted) {
            return redirect()->route('country.list')->with('success', 'Country deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Country not found');
        }
    }
      public function regioncreate()
    {
        $countries = DB::table('countries')->get();
        return view('region.add_region', compact('countries'));
    }
   public function regionstore(Request $request)
    {
        // Validate input
        $request->validate([
            'country_id' => 'required|integer|exists:countries,id',
            'name'       => 'required|string|max:255',
            'commune'    => 'required|string|max:255',
            'district'   => 'required|string|max:255',
        ]);

        // Insert into regions table
        DB::table('regions')->insert([
            'country_id' => $request->country_id,
            'name'       => $request->name,
            'commune'    => $request->commune,
            'district'   => $request->district,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Region added successfully!');
    }
    // Show regions in Blade
public function regionListView()
{
    $regions = DB::table('regions')
        ->join('countries', 'regions.country_id', '=', 'countries.id')
        ->select('regions.*', 'countries.name as country_name')
        ->orderBy('regions.id', 'desc')
        ->get();

    return view('region.list_region', compact('regions'));
}

// Show edit form
public function regionEdit($id)
{
    $region = DB::table('regions')->where('id', $id)->first();
    $countries = DB::table('countries')->get();

    if (!$region) {
        return redirect()->back()->with('error', 'Region not found');
    }

    return view('region.edit_region', compact('region', 'countries'));
}
public function regionUpdate(Request $request, $id)
{
    $request->validate([
        'country_id' => 'required|integer|exists:countries,id',
        'name'       => 'required|string|max:255',
        'commune'    => 'required|string|max:255',
        'district'   => 'required|string|max:255',
    ]);

    $updated = DB::table('regions')->where('id', $id)->update([
        'country_id' => $request->country_id,
        'name'       => $request->name,
        'commune'    => $request->commune,
        'district'   => $request->district,
        'updated_at' => now(),
    ]);

    if ($updated) {
        return redirect()->route('region.list')->with('success', 'Region updated successfully');
    } else {
        return redirect()->back()->with('error', 'Region not found or nothing to update');
    }
}
// Delete region
public function regionDelete($id)
{
    $deleted = DB::table('regions')->where('id', $id)->delete();

    if ($deleted) {
        return redirect()->route('region.list')->with('success', 'Region deleted successfully');
    } else {
        return redirect()->back()->with('error', 'Region not found');
    }
}


}

