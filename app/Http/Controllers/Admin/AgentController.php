<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usertype;
use App\Models\User;
use App\Models\UserTranslation;
use App\Models\UserCreationLog;
use App\Models\Language;
use App\Models\Country;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Seed;
use Illuminate\Support\Facades\App;

use App\Models\MasterAdmin;
use App\Models\Agent;
use App\Models\Region;
use App\Models\Notification;





class AgentController extends Controller
{
    // Show create agent form
    // public function create()
    // {
    //     return view('admin.agent.create_agent');
    // } translaste 
    public function create(Request $request)
{
    // 🌎 Language handling
    $lang = session('lang', 'en');
    if ($request->has('lang')) {
        $lang = $request->lang;
        session(['lang' => $lang]);
    }
    App::setLocale($lang);

    // Fetch countries if needed
    $countries = \DB::table('countries')->orderBy('name', 'asc')->get();

    // Pass lang + countries to view
    return view('admin.agent.create_agent', compact('countries', 'lang'));
}




public function store(Request $request)
{
    $request->validate([
        'name'        => 'required|string|max:255',
        'email'       => 'required|email|unique:agents,email',
        'password'    => 'required|string|min:6',
        'region'      => 'required|array',
        'country'     => 'required|string',
    ]);

    $languageId = 1;

    // ✅ Find country ID safely
    $countryId = Country::where('name', $request->country)->value('id') ?? null;

    // ✅ Auto create unique username
    $username = strtolower(str_replace(' ', '', $request->name)) . rand(100, 999);

    // ✅ Get "Pending" Status ID from status table
    $pendingStatusId = DB::table('status')->where('name', 'Pending')->value('id') ?? 2;

    DB::beginTransaction();

    try {
        DB::table('agents')->insert([
            'usertype_id'  => 1,
            'name'         => $request->name,
            'email'        => $request->email,
            'username'     => $username,
            'password'     => Hash::make($request->password),
            'region'       => implode(',', $request->region),
            'country'      => $request->country,
            'status_id'    => $pendingStatusId, // ✅ Default Pending
            'created_by'   => Auth::id() ?? 0,
            'language_id'  => $languageId,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        Notification::create([
    'title'   => 'New Agent Created',
    'message' => "Agent {$request->name} has been added.",
    'is_read' => 0,
]);
        DB::commit();
        return redirect()->back()->with('success', '✅ Agent created successfully with Pending status!');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', '❌ Error: ' . $e->getMessage());
    }
}


  


    // Show edit form
    // public function edit($id)
    // {
    //     $agent = Agent::findOrFail($id);
    //     return view('admin.agent.edit_agent', compact('agent'));
    // }  translate 
    public function edit(Request $request, $id)
{
    // 🌎 Language handling
    $lang = session('lang', 'en');

    if ($request->has('lang')) {
        $lang = $request->lang;
        session(['lang' => $lang]);
    }

    App::setLocale($lang);

    // Fetch agent
    $agent = Agent::findOrFail($id);

    // Fetch all countries (dropdown)
    $countries = \DB::table('countries')->orderBy('name', 'asc')->get();

    // Return view with language support
    return view('admin.agent.edit_agent', compact('agent', 'countries', 'lang'));
}

//  public function editCountry($id)
// {
//     $agent = Agent::findOrFail($id);
//     return view('admin.agent.edit_country', compact('agent'));
// }
public function editCountry(Request $request, $id)
{
    // 🌎 Language Setup
    $lang = session('lang', 'en');
    if ($request->has('lang')) {
        $lang = $request->lang;
        session(['lang' => $lang]);
    }
    App::setLocale($lang);

    // ✅ Fetch Agent
    $agent = Agent::findOrFail($id);

    return view('admin.agent.edit_country', compact('agent'));
}




public function updateCountry(Request $request, $id)
{
    $agent = Agent::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:agents,email,' . $id,
        'username' => 'required|string|unique:agents,username,' . $id,
        'password' => 'nullable|string|min:6',
        'region' => 'required|array',
        'country' => 'required|string|max:255',
        'status_id' => 'nullable|exists:status,id', // optional status update
    ]);

    $agent->name = $request->name;
    $agent->email = $request->email;
    $agent->username = $request->username;
    $agent->region = is_array($request->region) ? implode(',', $request->region) : $request->region;
    $agent->country = $request->country;

    // Update status only if provided
    if ($request->filled('status_id')) {
        $agent->status_id = $request->status_id;
    }

    // Update password only if filled
    if ($request->filled('password')) {
        $agent->password = Hash::make($request->password);
    }

    $agent->save();

    // ✅ Redirect to specific URL instead of route
    return redirect('https://fivoflow.com/wclm/public/agents/country')
           ->with('success', '✅ Agent updated successfully!');
}


public function update(Request $request, $id)
{
    $agent = Agent::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:agents,email,' . $id,
        'username' => 'nullable|string|unique:agents,username,' . $id,
        'password' => 'nullable|string|min:6',
        'region' => 'required|array',
        'country' => 'required|string|max:255',
        'status_id' => 'nullable|exists:status,id', // ✅ optional status update
    ]);

    $agent->name = $request->name;
    $agent->email = $request->email;
    $agent->username = $request->username;
    $agent->region = is_array($request->region) ? implode(',', $request->region) : $request->region;
    $agent->country = $request->country;

    // ✅ Update status only if provided
    if ($request->filled('status_id')) {
        $agent->status_id = $request->status_id;
    }

    // ✅ Update password only if filled
    if ($request->filled('password')) {
        $agent->password = Hash::make($request->password);
    }

    $agent->save();

    return redirect()->route('admin.agent.status')->with('success', '✅ Agent updated successfully!');
}
public function updateStatus(Request $request)
{
    $request->validate([
        'agent_id' => 'required|exists:agents,id',
        'status_id' => 'required|exists:status,id',
    ]);

    $agent = Agent::findOrFail($request->agent_id);
    $agent->status_id = $request->status_id;
    $agent->save();

    return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
}



    // Delete agent
    public function destroy($id)
{
    $agent = Agent::findOrFail($id);
    $agent->delete();

    // Redirect using correct route name
    return redirect()->route('admin.agent.status')->with('success', 'Agent deleted successfully!');
}
 public function destroycountry($id)
{
    $agent = Agent::findOrFail($id);
    $agent->delete();

    return redirect()->route('agents.country.list')
                     ->with('success', 'Agent deleted successfully!');
}


public function getRegions($countryId)
{
    // Fetch regions for the selected country
    $regions = \App\Models\Region::where('country_id', $countryId)->get(['id', 'name']);

    return response()->json($regions);
}



// public function agentStatus(Request $request)
// {
//     // 1. Get unique countries from agents table for dropdown
//     $countries = \App\Models\Agent::select('country')
//         ->whereNotNull('country')
//         ->distinct()
//         ->orderBy('country')
//         ->pluck('country');

//     // 2. Build query
//     $query = \App\Models\Agent::orderBy('id', 'desc');

//     // 3. If country selected, filter agents
//     if ($request->country) {
//         $query->where('country', $request->country);
//     }

//     // 4. Pagination
//     $agents = $query->paginate(10)->withQueryString();

//     return view('admin.agent.agentstatus', compact('agents', 'countries'));
// } translte 
public function agentStatus(Request $request)
{
     $lang = session('lang', 'en');

    if ($request->has('lang')) {
        $lang = $request->lang;
        session(['lang' => $lang]);
    }

    App::setLocale($lang);
    // 1. Get unique countries from agents table for dropdown
    $countries = \App\Models\Agent::select('country')
        ->whereNotNull('country')
        ->distinct()
        ->orderBy('country')
        ->pluck('country');

    // 2. Build query
    $query = \App\Models\Agent::orderBy('id', 'desc');

    // 3. If country selected, filter agents
    if ($request->country) {
        $query->where('country', $request->country);
    }
$countries = \App\Models\Country::orderBy('name')->get();

    // 4. Pagination
    $agents = $query->paginate(10)->withQueryString();

    return view('admin.agent.agentstatus', compact('agents', 'countries', 'lang'));
}  


public function viewAgent(Request $request, $id)
{
    // Get the current language from session or default to English
    $lang = session('lang', 'en');

    // Update language if it's passed in the request
    if ($request->has('lang')) {
        $lang = $request->lang;
        session(['lang' => $lang]);
    }

    // Set the application locale
    App::setLocale($lang);

    // Find the agent by ID
    $agent = Agent::findOrFail($id);

    // Return view with agent and language
    return view('admin.agent.view-agent', compact('agent', 'lang'));
}

// Approve agent
public function approveAgent($id)
{
    $agent = Agent::findOrFail($id);
    $agent->status_id = 2; // Approved
    $agent->reject_message = null;
    $agent->save();

    return redirect()->route('admin.agent.status')->with('success', '✅ Agent approved successfully');
}
public function approveAgentcountry($id)
{
    $agent = Agent::findOrFail($id);
    $agent->status_id = 2; // Approved
    $agent->reject_message = null;
    $agent->save();

    return redirect()->route('admin.agent.status')->with('success', '✅ Agent approved successfully');
}

// Reject agent
public function rejectAgent(Request $request, $id)
{
    $request->validate([
        'reject_message' => 'required|string|max:255'
    ]);

    $agent = Agent::findOrFail($id);
    $agent->status_id = 3; // Rejected
    $agent->reject_message = $request->reject_message;
    $agent->save();

    return redirect()
        ->route('admin.agent.status')
        ->with('error', '❌ Agent rejected successfully');
}

    //    public function countryAgentCreate()
    // {
    //     return view('admin.agent.create');
    // }

public function countryAgentCreate(Request $request)
{
    // 🌎 Language Setup
    $lang = session('lang', 'en');
    if ($request->has('lang')) {
        $lang = $request->lang;
        session(['lang' => $lang]);
    }
    App::setLocale($lang);

    return view('admin.agent.create');
}


public function countryAgent(Request $request)
{
    $request->validate([
        'name'        => 'required|string|max:255',
        'email'       => 'required|email|unique:agents,email',
        'password'    => 'required|string|min:6',
        'region'      => 'required|array',
    ]);

    $languageId = 1;

    // ✅ Get country from logged-in user session
    $country = session('country_id'); // agar session me numeric ID hai
    if (!$country) {
        return redirect()->back()->with('error', '❌ Your account does not have a country assigned.');
    }

    // ✅ Auto create unique username
    $username = strtolower(str_replace(' ', '', $request->name)) . rand(100, 999);

    // ✅ Get "Pending" Status ID from status table
    $pendingStatusId = DB::table('status')->where('name', 'Pending')->value('id') ?? 1;

    DB::beginTransaction();

    try {
        DB::table('agents')->insert([
            'usertype_id'  => 1,
            'name'         => $request->name,
            'email'        => $request->email,
            'username'     => $username,
            'password'     => Hash::make($request->password),
            'region'       => implode(',', $request->region),
            'country'      => (string)$country, // ✅ Changed from country_id to country
            'status_id'    => $pendingStatusId,
            'created_by'   => Auth::id() ?? 0,
            'language_id'  => $languageId,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        DB::commit();
        return redirect()->back()->with('success', '✅ Agent created successfully with Pending status!');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', '❌ Error: ' . $e->getMessage());
    }
}


// public function countryAgentList(Request $request)
// {
//     $country = session('country_id');
//     if (!$country) {
//         return redirect()->back()->with('error', '❌ Your account does not have a country assigned.');
//     }

//     // Use paginate instead of get
//     $agents = DB::table('agents')
//                 ->where('country', $country)
//                 ->orderBy('id', 'desc')
//                 ->paginate(15); // 15 records per page

//     return view('admin.agent.country_list', compact('agents'));
// }
public function countryAgentList(Request $request)
{
    // 🌎 Language Setup
    $lang = session('lang', 'en');
    if ($request->has('lang')) {
        $lang = $request->lang;
        session(['lang' => $lang]);
    }
    App::setLocale($lang);

    // ✅ Logged-in user's country
    $country = session('country_id');
    if (!$country) {
        return redirect()->back()->with('error', __('dashboard.account_no_country'));
    }

    // Use paginate instead of get
    $agents = DB::table('agents')
                ->where('country', $country)
                ->orderBy('id', 'desc')
                ->paginate(15); // 15 records per page

    return view('admin.agent.country_list', compact('agents'));
}



}
