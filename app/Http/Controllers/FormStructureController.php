<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormStructure;

class FormStructureController extends Controller
{
    public function store(Request $request)
    {
        FormStructure::updateOrCreate(
            [
                'product_id' => $request->product_id,
                'supplier_id' => $request->supplier_id,
                'agent_id' => $request->agent_id,
            ],
            [
                'form_json' => json_encode($request->except('_token'))
            ]
        );

        return back()->with('success', 'Form Saved Successfully ✅');
    }

    public function load(Request $request)
    {
        $form = FormStructure::where([
            'product_id' => $request->product_id,
            'supplier_id' => $request->supplier_id,
            'agent_id' => $request->agent_id,
        ])->first();

        if ($form) {
            return response()->json($form->form_json);
        }

        return response()->json(null);
    }
}
