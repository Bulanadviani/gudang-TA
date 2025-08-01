<?php

namespace App\Http\Controllers;

use App\Models\Merk;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // for search feature
            if ($request->has('keyword') || $request->has('page')  && !$request->has('draw') ) {
                $merk = Merk::where(function($query) use ($request) {
                    if($request->has('id')){
                        $query->where('id',$request->id);
                    }else{
                        $keyword = strtolower($request->keyword);
                        $query->where('nama', 'like', '%' . $keyword . '%');
                    }
                })->paginate(5);
                return response()->json($merk, 200);
            }
        }

        $permissions = [
            'masuk.view', 'masuk.create', 'masuk.delete', 'masuk.update',
            'keluar.view', 'keluar.update', 'keluar.delete',
            'peminjaman.view', 'peminjaman.update', 'peminjaman.delete',
            'report.view',
            'pengaturan.view', 'pengaturan.create', 'pengaturan.update', 'pengaturan.delete',
            'users.view', 'users.create', 'users.update', 'users.delete',
        ];
        $roles = \Spatie\Permission\Models\Role::with('permissions')->get();
        $merk = Merk::paginate(10);
        
        return view("pengaturan.role",compact('merk',"roles","permissions"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function show(Merk $merk)
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'required|array',
        ]);

        // Create missing permissions if any
        foreach ($request->permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Create role
        $role = Role::create(['name' => $request->name]);

        // Assign permissions to role
        $role->syncPermissions($request->permissions);

        return redirect()->route('pengaturan.role.index')->with('success', 'Role created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Merk $merk)
    {
        //
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => "required|string|unique:roles,name,$id",
            'permissions' => 'required|array',
        ]);

        $role = Role::findOrFail($id);

        // Update name
        $role->name = $request->name;
        $role->save();

        // Sync permissions
        foreach ($request->permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }
        $role->syncPermissions($request->permissions);

        return redirect()->route('pengaturan.role.index')->with('success', 'Role updated successfully.');
    }

public function destroy($id)
{
    $role = Role::findOrFail($id);

    // Optionally, protect some roles from deletion (like 'admin')
    if (in_array($role->name, ['admin'])) {
        return redirect()->route('pengaturan.role.index')->with('error', 'Cannot delete admin role.');
    }

    $role->delete();

    return redirect()->route('pengaturan.role.index')->with('success', 'Role deleted successfully.');
}


}
