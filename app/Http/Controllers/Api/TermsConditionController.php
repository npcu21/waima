<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TermsCondition;
use App\Models\PrivacyPolicy;
use Illuminate\Support\Facades\Validator;

class TermsConditionController extends Controller
{
    /* ==========================================================
        ✅ TERMS & CONDITIONS API
    ========================================================== */

    // Create T&C
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'language_id' => 'nullable|exists:languages,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $tc = TermsCondition::create($request->only(['title','description','language_id']));

        return response()->json([
            'status' => true,
            'message' => 'Terms & Conditions saved successfully',
            'data' => $tc
        ], 201);
    }

    // Update T&C
    public function update(Request $request, $id)
    {
        $tc = TermsCondition::find($id);
        if (!$tc) {
            return response()->json(['status' => false, 'message' => 'Not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title'       => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'language_id' => 'nullable|exists:languages,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $tc->update($request->only(['title','description','language_id']));

        return response()->json([
            'status' => true,
            'message' => 'Terms & Conditions updated',
            'data' => $tc
        ], 200);
    }

    // List T&C
    public function index(Request $request)
    {
        $query = TermsCondition::query();

        if ($request->has('language_id')) {
            $query->where('language_id', $request->language_id);
        }

        $items = $query->orderBy('id', 'desc')->get();

        return response()->json(['status' => true, 'data' => $items], 200);
    }

    // Show single T&C
    public function show($id)
    {
        $tc = TermsCondition::find($id);
        if (!$tc) {
            return response()->json(['status' => false, 'message' => 'Not found'], 404);
        }

        return response()->json(['status' => true, 'data' => $tc], 200);
    }

    // Delete T&C
    public function destroy($id)
    {
        $tc = TermsCondition::find($id);
        if (!$tc) {
            return response()->json(['status' => false, 'message' => 'Not found'], 404);
        }

        $tc->delete();

        return response()->json(['status' => true, 'message' => 'Deleted'], 200);
    }

    /* ==========================================================
        ✅ PRIVACY POLICY API
    ========================================================== */

    public function storePrivacy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'language_id' => 'nullable|exists:languages,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $privacy = PrivacyPolicy::create($request->only(['title','description','language_id']));

        return response()->json([
            'status' => true,
            'message' => 'Privacy Policy saved successfully',
            'data' => $privacy
        ], 201);
    }

    public function updatePrivacy(Request $request, $id)
    {
        $privacy = PrivacyPolicy::find($id);
        if (!$privacy) {
            return response()->json(['status' => false, 'message' => 'Not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title'       => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'language_id' => 'nullable|exists:languages,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
        }

        $privacy->update($request->only(['title','description','language_id']));

        return response()->json([
            'status' => true,
            'message' => 'Privacy Policy updated',
            'data' => $privacy
        ], 200);
    }

    public function indexPrivacy(Request $request)
    {
        $query = PrivacyPolicy::query();

        if ($request->has('language_id')) {
            $query->where('language_id', $request->language_id);
        }

        $items = $query->orderBy('id', 'desc')->get();

        return response()->json(['status' => true, 'data' => $items], 200);
    }

    public function showPrivacy($id)
    {
        $privacy = PrivacyPolicy::find($id);
        if (!$privacy) {
            return response()->json(['status' => false, 'message' => 'Not found'], 404);
        }

        return response()->json(['status' => true, 'data' => $privacy], 200);
    }

    public function deletePrivacy($id)
    {
        $privacy = PrivacyPolicy::find($id);
        if (!$privacy) {
            return response()->json(['status' => false, 'message' => 'Not found'], 404);
        }

        $privacy->delete();

        return response()->json(['status' => true, 'message' => 'Deleted'], 200);
    }
}
