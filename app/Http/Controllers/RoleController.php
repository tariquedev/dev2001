<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\User;

class RoleController extends Controller
{
    function role(){

        // $role = Role::create(['name' => 'subscriber']);
        // $permission = Permission::create(['name' => 'restore category']);

        return view('backend.role',[
            'roles' => Role::all(),
            'permissions' => Permission::all(),
            'users' => User::all(),
        ]);
    }

    function RoleAddToPermission(Request $request){
        $role_name = $request->role_name;
        $permission_name = $request->permission_name;
        $role = Role::where('name', $role_name)->first();
        // Multiple 
        $role->givePermissionTo($permission_name);
        // Single
        // $role->syncPermissions($permission_name);
        return back();
    }

    function RoleAddToUser(Request $request){
        $user_id = $request->user_id;
        $role_name = $request->role_name;
        $user = User::findOrFail($user_id);
        // Multiple 
        $user->syncRoles($role_name);
        // Single
        // $role->syncPermissions($permission_name);
        return back();
    }

    function PermissionChange($user_id){
        $user = User::findOrFail($user_id);
        return view('backend.edit_permission',[
            'permissions' => Permission::all(),
            'user' => $user
        ]);
    }

    function PermissionChangeToUser(Request $request){
        $user = User::findOrFail($request->user_id);
        $user->syncPermissions($request->permission);
        return back();
    }
}
