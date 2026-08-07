<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agent;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\AgentTranslation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class AgentController extends Controller
{
    // 1️⃣ List all agents
    // public function index()
    // {
    //     $agents = Agent::orderBy('id', 'desc')->get();

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Agents retrieved successfully',
    //         'data' => $agents
    //     ]);
    // }
    public function index()
{
    // Get Agents
    $agents = Agent::orderBy('id', 'desc')->get();

    // Get users whose usertype_id = 1
    $users = User::where('usertype_id', 1)
                 ->orderBy('id', 'desc')
                 ->get();

    return response()->json([
        'status'  => true,
        'message' => 'Agents & Users retrieved successfully',
        'agents'  => $agents,
        'users'   => $users
    ]);
}


    // 2️⃣ Show single agent
    public function show($id)
    {
        try {
            $agent = Agent::findOrFail($id);
            return response()->json([
                'status' => true,
                'message' => 'Agent retrieved successfully',
                'data' => $agent
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Agent not found'
            ], 404);
        }
    }

    // 3️⃣ Create new agent + save translations for all languages
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:agents,email',
    //         'username' => 'required|string|unique:agents,username',
    //         'password' => 'required|string|min:6',
    //         'created_by' => 'nullable|integer'
    //     ]);

    //     $data = $request->only(['name', 'email', 'username', 'created_by']);
    //     $data['password'] = Hash::make($request->password);

    //     // Set language_id from creator if exists
    //     if (!empty($data['created_by'])) {
    //         $creator = User::find($data['created_by']);
    //         if ($creator) {
    //             $data['language_id'] = $creator->language_id;
    //         }
    //     }

    //     $agent = Agent::create($data);

    //     // Save translations for all languages
    //     $languages = DB::table('languages')->get();
    //     foreach ($languages as $lang) {
    //         AgentTranslation::create([
    //             'agent_id' => $agent->id,
    //             'language_id' => $lang->id,
    //             'name' => $agent->name,
    //             'email' => $agent->email,
    //             'username' => $agent->username
    //         ]);
    //     }

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Agent created successfully with translations',
    //         'data' => $agent
    //     ], 201);
    // }
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:agents,email',
        'username' => 'required|string|unique:agents,username',
        'password' => 'required|string|min:6',
        'created_by' => 'nullable|integer',
        'country_id' => 'nullable|integer', // country_id id aayegi
    ]);

    $data = $request->only(['name', 'email', 'username', 'created_by', 'country_id']);
    $data['password'] = Hash::make($request->password);

    // Set language_id from creator if exists
    if (!empty($data['created_by'])) {
        $creator = User::find($data['created_by']);
        if ($creator) {
            $data['language_id'] = $creator->language_id;
        }
    }

    $agent = Agent::create($data);

    return response()->json([
        'status' => true,
        'message' => 'Agent created successfully',
        'data' => $agent
    ], 201);
}
public function update(Request $request, $id)
{
    try {
        $agent = Agent::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:agents,email,'.$id,
            'username' => 'sometimes|required|string|unique:agents,username,'.$id,
            'password' => 'nullable|string|min:6',
            'created_by' => 'nullable|integer',
            'country_id' => 'nullable|integer', // ✅ added country_id
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        // Update language_id if created_by changed
        if (!empty($validated['created_by'])) {
            $creator = User::find($validated['created_by']);
            if ($creator) {
                $validated['language_id'] = $creator->language_id;
            }
        }

        $agent->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Agent updated successfully',
            'data' => $agent
        ]);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'status' => false,
            'message' => 'Agent not found'
        ], 404);
    }
}



    // 4️⃣ Update agent + translations
    // public function update(Request $request, $id)
    // {
    //     try {
    //         $agent = Agent::findOrFail($id);

    //         $validated = $request->validate([
    //             'name' => 'sometimes|required|string|max:255',
    //             'email' => 'sometimes|required|email|unique:agents,email,'.$id,
    //             'username' => 'sometimes|required|string|unique:agents,username,'.$id,
    //             'password' => 'nullable|string|min:6',
    //             'created_by' => 'nullable|integer'
    //         ]);

    //         if (isset($validated['password'])) {
    //             $validated['password'] = Hash::make($validated['password']);
    //         }

    //         // Update language_id if created_by changed
    //         if (!empty($validated['created_by'])) {
    //             $creator = User::find($validated['created_by']);
    //             if ($creator) {
    //                 $validated['language_id'] = $creator->language_id;
    //             }
    //         }

    //         $agent->update($validated);

    //         // Update all translations
    //         $languages = DB::table('languages')->get();
    //         foreach ($languages as $lang) {
    //             AgentTranslation::updateOrCreate(
    //                 [
    //                     'agent_id' => $agent->id,
    //                     'language_id' => $lang->id
    //                 ],
    //                 [
    //                     'name' => $agent->name,
    //                     'email' => $agent->email,
    //                     'username' => $agent->username
    //                 ]
    //             );
    //         }

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Agent updated successfully with translations',
    //             'data' => $agent
    //         ]);
    //     } catch (ModelNotFoundException $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Agent not found'
    //         ], 404);
    //     }
    // }

    // 5️⃣ Delete agent + translations
    public function destroy($id)
    {
        try {
            $agent = Agent::findOrFail($id);
            $agent->delete();

            AgentTranslation::where('agent_id', $id)->delete();

            return response()->json([
                'status' => true,
                'message' => 'Agent deleted successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Agent not found'
            ], 404);
        }
    }
}
