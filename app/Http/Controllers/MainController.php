<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Agent; // Agent model

class MainController extends Controller
{
    // Show main form
    public function formSelector()
    {
        return view('admin.products.form_selector');
    }

    // Fetch suppliers dynamically
    public function getSuppliers()
    {
        $suppliers = Supplier::select('id', 'company_name')->get();
        return response()->json($suppliers);
    }

    // Fetch agents dynamically
    public function getAgents()
    {
        $agents = Agent::select('id', 'name')->get();
        return response()->json($agents);
    }
}
