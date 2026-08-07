<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AgricultureForm;
use App\Models\Seed;

class AgricultureController extends Controller
{
    // 🧾 Show the form
    public function createForm()
    {
        // ✅ Fetch all seeds for dropdown
        $seeds = Seed::all();

        // Updated path to new Blade file
        return view('admin.products.form', compact('seeds'));
    }

    // 💾 Store the form data
    public function storeForm(Request $request)
    {
        $request->validate([
            'enumerator_name' => 'required|string|max:255',
            'enumerator_phone' => 'required|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'manager_name' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'latitude' => 'nullable|string|max:50',
            'longitude' => 'nullable|string|max:50',
            'altitude' => 'nullable|string|max:50',
            'accuracy' => 'nullable|string|max:50',
            'seed_id' => 'required|integer|exists:seed,id', // ✅ ensure valid seed selected
        ]);

        // ✅ Save to DB
        AgricultureForm::create($request->all());

        return redirect()->back()->with('success', 'Agriculture form submitted successfully!');
    }
}
