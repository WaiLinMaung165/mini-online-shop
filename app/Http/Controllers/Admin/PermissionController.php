<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::with('permissions')->where('name', '!=', 'customer')->get();
        return view('admin.permissions.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $roles = Role::where('name', '!=', 'customer')->get();
        $permissions = Permission::all();
        $selectedRole = null;

        if ($request->has('role_id')) {
            $selectedRole = Role::with('permissions')->find($request->role_id);
        }

        return view('admin.permissions.create', compact('roles', 'permissions', 'selectedRole'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'array',
        ]);

        $role = Role::findOrFail($request->role_id);
        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permissions assigned to role successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $roles = Role::where('name', '!=', 'customer')->get();
        $permissions = Permission::all();

        return view('admin.permissions.edit', compact('role', 'roles', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'permissions' => 'array',
        ]);

        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Role permissions updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        $role->syncPermissions([]);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Role permissions revoked successfully.');
    }
}
