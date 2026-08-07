<?php

namespace App\Http\Controllers\CountryAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\MasterAdmin;

class CountryAdminController extends Controller
{
    // Middleware: Only logged-in Country Admin
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Session::has('masteradmin_id') || Session::get('userType') != 'Country-Admin') {
                return redirect()->route('masteradmin.login.form')
                                 ->with('error', 'Access denied! Login as Country Admin.');
            }
            return $next($request);
        });
    }

    // Dashboard
    public function dashboard()
    {
        $admin_id = Session::get('masteradmin_id');
        $admin = MasterAdmin::find($admin_id);

        $countries = \DB::table('countries')->get();

        return view('countryadmin.dashboard', compact('admin', 'countries'));
    }

    // Profile page
    public function profile()
    {
        $admin_id = Session::get('masteradmin_id');
        $admin = MasterAdmin::find($admin_id);

        return view('countryadmin.profile', compact('admin'));
    }

    // Logout
    public function logout()
    {
        Session::forget('masteradmin_id');
        Session::forget('userType');
        return redirect()->route('masteradmin.login.form')
                         ->with('message', 'Logged out successfully!');
    }
}
