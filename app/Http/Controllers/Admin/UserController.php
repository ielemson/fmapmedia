<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
// use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles', 'Vendor')
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = ['Admin', 'Vendor', 'Customer'];

        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'unique:users,email'],
        'password' => ['required', 'string', 'min:6'],
        'role' => ['required', 'in:Admin,Vendor,Customer'],
        'status' => ['required', 'in:active,suspended'],

        'business_name' => ['nullable', 'string', 'max:255'],
        'vendor_type' => ['nullable', 'string', 'max:255'],
        'vendor_status' => ['nullable', 'in:pending,approved,rejected,suspended'],
        'phone' => ['nullable', 'string', 'max:50'],
        'state' => ['nullable', 'string', 'max:100'],
        'city' => ['nullable', 'string', 'max:100'],
        'commission_type' => ['nullable', 'in:percentage,fixed'],
        'commission_value' => ['nullable', 'numeric', 'min:0'],
    ]);

    $user = User::create([
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'name' => trim($data['first_name'] . ' ' . $data['last_name']),
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'status' => $data['status'],
    ]);

    $user->assignRole($data['role']);

    if ($data['role'] === 'Vendor') {
        $vendorStatus = $data['vendor_status'] ?? 'pending';

        Vendor::create([
            'user_id' => $user->id,
            'business_name' => $data['business_name'] ?? null,
            'vendor_type' => $data['vendor_type'] ?? null,
            'phone' => $data['phone'] ?? null,
            'state' => $data['state'] ?? null,
            'city' => $data['city'] ?? null,
            'vendor_code' => 'VND-' . strtoupper(Str::random(8)),
            'referral_slug' => Str::slug($data['business_name'] ?? $user->name) . '-' . strtolower(Str::random(6)),
            'status' => $vendorStatus,
            'commission_type' => $data['commission_type'] ?? 'percentage',
            'commission_value' => $data['commission_value'] ?? 0,
            'approved_at' => $vendorStatus === 'approved' ? now() : null,
        ]);
    }

    return redirect()
        ->route('admin.users.index')
        ->with('success', 'User created successfully.');
}

    public function edit(User $user)
    {
        $user->load('roles', 'Vendor');

        $roles = ['Admin', 'Vendor', 'Customer'];

        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
{
    $data = $request->validate([
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'unique:users,email,' . $user->id],
        'password' => ['nullable', 'string', 'min:6'],
        'role' => ['required', 'in:Admin,Vendor,Customer'],
        'status' => ['required', 'in:active,suspended'],

        'business_name' => ['nullable', 'string', 'max:255'],
        'vendor_type' => ['nullable', 'string', 'max:255'],
        'vendor_status' => ['nullable', 'in:pending,approved,rejected,suspended'],
        'phone' => ['nullable', 'string', 'max:50'],
        'state' => ['nullable', 'string', 'max:100'],
        'city' => ['nullable', 'string', 'max:100'],
        'commission_type' => ['nullable', 'in:percentage,fixed'],
        'commission_value' => ['nullable', 'numeric', 'min:0'],
    ]);

    $userData = [
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'name' => trim($data['first_name'] . ' ' . $data['last_name']),
        'email' => $data['email'],
        'status' => $data['status'],
    ];

    if (!empty($data['password'])) {
        $userData['password'] = Hash::make($data['password']);
    }

    $user->update($userData);

    $user->syncRoles([$data['role']]);

    if ($data['role'] === 'Vendor') {
        $existingVendor = $user->vendor;

        $vendorStatus = $data['vendor_status'] ?? $existingVendor?->status ?? 'pending';

        $user->vendor()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'business_name' => $data['business_name'] ?? null,
                'vendor_type' => $data['vendor_type'] ?? null,
                'phone' => $data['phone'] ?? null,
                'state' => $data['state'] ?? null,
                'city' => $data['city'] ?? null,
                'vendor_code' => $existingVendor?->vendor_code ?? 'VND-' . strtoupper(Str::random(8)),
                'referral_slug' => $existingVendor?->referral_slug
                    ?? Str::slug($data['business_name'] ?? $user->name) . '-' . strtolower(Str::random(6)),
                'status' => $vendorStatus,
                'commission_type' => $data['commission_type'] ?? 'percentage',
                'commission_value' => $data['commission_value'] ?? 0,
                'approved_at' => $vendorStatus === 'approved'
                    ? ($existingVendor?->approved_at ?? now())
                    : null,
            ]
        );
    } else {
        $user->vendor()?->delete();
    }

    return redirect()
        ->route('admin.users.index')
        ->with('success', 'User updated successfully.');
}

    public function suspend(User $user)
    {
        $user->update(['status' => 'suspended']);

        if ($user->Vendor) {
            $user->Vendor->update(['status' => 'suspended']);
        }

        return back()->with('success', 'User suspended successfully.');
    }

    public function activate(User $user)
    {
        $user->update(['status' => 'active']);

        if ($user->Vendor) {
            $user->Vendor->update(['status' => 'approved']);
        }

        return back()->with('success', 'User activated successfully.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }
}