<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use App\Permission;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('browse-roles');
        if($request->ajax()){
            $roles = Role::get();
            return datatables($roles)->addColumn('action', function ($roles) {
                if (auth()->user()->can('read-roles')) {
                    $act[] = '<a href="'.route('roles.show',$roles->id).'" title="View Role" class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                }
                if (auth()->user()->can('edit-roles')) {
                    $act[] = '<a href="'.route('roles.edit',$roles->id).'" title="Edit Role" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                }
                if (auth()->user()->can('delete-roles')) {
                    $act[] = '<a href="'.route('roles.destroy', $roles->id).'" title="Delete Role" class="deleteBtn btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
                }
                return implode("\n", $act);
            })
            ->toJson();
        }

        return view('admin.roles.index');
    }
    public function create()
    {
        $this->authorize('add-roles');
        $permissions = Permission::select('id', 'name', 'label')->get()->pluck('label', 'name');

        return view('admin.roles.create', compact('permissions'));
    }
    public function store(Request $request)
    {
        $this->authorize('add-roles');
        $this->validate($request, ['name' => 'required']);

        $role = Role::create($request->all());
        $role->permissions()->detach();

        if ($request->has('permissions')) {
            foreach ($request->permissions as $permission_name) {
                $permission = Permission::whereName($permission_name)->first();
                $role->givePermissionTo($permission);
            }
        }

        return redirect('admin/roles')->with('flash_message', 'Role added!');
    }
    public function show($id)
    {
        $this->authorize('read-roles');
        $role = Role::findOrFail($id);

        return view('admin.roles.show', compact('role'));
    }
    public function edit($id)
    {
        $this->authorize('edit-roles');
        $role = Role::findOrFail($id);
        $permissions = Permission::select('id', 'name', 'label')->get()->pluck('label', 'name');

        return view('admin.roles.edit', compact('role', 'permissions'));
    }
    public function update(Request $request, $id)
    {
        $this->authorize('edit-roles');
        $this->validate($request, ['name' => 'required']);

        $role = Role::findOrFail($id);
        $role->update($request->all());
        $role->permissions()->detach();

        if ($request->has('permissions')) {
            foreach ($request->permissions as $permission_name) {
                $permission = Permission::whereName($permission_name)->first();
                $role->givePermissionTo($permission);
            }
        }

        return redirect('admin/roles')->with('flash_message', 'Role updated!');
    }
    public function destroy($id)
    {
        $this->authorize('delete-roles');
        Role::destroy($id);

        return ['flash_message' => 'Role deleted!'];
    }
}
