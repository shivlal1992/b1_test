<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
class RolePermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    // List roles and permissions
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        return view('roles.index', compact('roles', 'permissions'));
    }
    // Create a new role
    public function storeRole(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles']);
        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);
        return back()->with('success', 'Role created successfully.');
    }
    // Update role
    public function updateRole(Request $request, Role $role)
    {
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions);
        return back()->with('success', 'Role updated successfully.');
    }
    // Delete role
    public function destroyRole(Role $role)
    {
        $role->delete();
        return back()->with('success', 'Role deleted successfully.');
    }
    // Create a new permission
    public function storePermission(Request $request)
    {
        $request->validate(['name' => 'required|unique:permissions']);
        Permission::create(['name' => $request->name]);
        return back()->with('success', 'Permission created successfully.');
    }
    // Delete permission
    public function destroyPermission(Permission $permission)
    {
        $permission->delete();
        return back()->with('success', 'Permission deleted successfully.');
    }
    // Assign role to user
    public function assignRole(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->syncRoles([$request->role]);
        return back()->with('success', 'User role updated successfully.');
    }
    public function editRole(Role $role)
    {
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }
    public function editPermission(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }
    public function updatePermission(Request $request, Permission $permission)
    {
        $request->validate(['name' => 'required|unique:permissions,name,' . $permission->id]);
        $permission->update(['name' => $request->name]);
        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }
    public function managePermissions()
    {
        $permissions = Permission::all();
        return view('permissions.index', compact('permissions'));
    }
    public function permissionsAdd()
    {
        return view('permissions.add');
    }
    // Show user details with assigned permissions
    public function show($id)
    {
        // $role = Role::findByName('District Admin');
        // $role->revokePermissionTo('manage districts');
        $user = User::findOrFail($id);
        $roles = $user->roles; // Get user's roles
        $permissions = Permission::all(); // Get all available permissions
        $userPermissions = $user->permissions->pluck('name')->toArray(); // Get user's assigned permissions
        return view('permissions.user-permissions', compact('user', 'roles', 'permissions', 'userPermissions'));
    }
    // Assign permissions to a user
    public function store(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'permissions' => 'array', // Ensure it's an array
            'permissions.*' => 'exists:permissions,name', // Each permission must exist in DB
        ]);
        $user->syncPermissions($request->permissions); // Assign selected permissions
        return redirect()->back()->with('success', 'Permissions assigned successfully!');
    }
}
    