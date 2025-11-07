<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function index()
    {
        return response()->json([
            'roles' => Role::with('permissions')->get(),
            'permissions' => Permission::all(),
        ]);
    }

    public function store(Request $request)
    {
        $role = Role::create(['name' => $request->name]);
        $role->givePermissionTo($request->permissions ?? []);

        return response()->json($role->load('permissions'));
    }

    public function show($id)
    {
        return Role::with('permissions')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions ?? []);

        return response()->json($role->load('permissions'));
    }

    public function destroy($id)
    {
        Role::findOrFail($id)->delete();

        return response()->noContent();
    }
}
