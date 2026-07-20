<?php

namespace App\Http\Controllers;

use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('Admin')) {
            return "aDmin";

            $totalAdmins = User::role('Admin')->count();
            $totalVendors = User::role('Vendor')->count();
            $totalCustomers = User::role('Customer')->count();
            $totalUsers = User::count();

            return view('admin.dashboard', compact(
                'user',
                'totalAdmins',
                'totalVendors',
                'totalCustomers',
                'totalUsers'
            ));
        }

        if ($user->hasRole('Vendor')) {
            return view('vendor.dashboard', compact('user'));
        }

        if ($user->hasRole('Customer')) {
            return view('customer.dashboard', compact('user'));
        }

        abort(403);
    }
}