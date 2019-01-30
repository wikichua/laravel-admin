<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Permission;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('browse-permissions');
        if($request->ajax()){
            $permissions = Permission::get();
            return datatables($permissions)->addColumn('action', function ($permissions) {
                if (auth()->user()->can('read-permissions')) {
                    $act[] = '<a href="'.route('permissions.show',$permissions->id).'" title="View Permission" class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                }
                if (auth()->user()->can('edit-permissions')) {
                    $act[] = '<a href="'.route('permissions.edit',$permissions->id).'" title="Edit Permission" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                }
                if (auth()->user()->can('delete-permissions')) {
                    $act[] = '<a href="'.route('permissions.destroy', $permissions->id).'" title="Delete Permission" class="deleteBtn btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
                }
                return implode("\n", $act);
            })
            ->toJson();
        }

        return view('admin.permissions.index');
    }
    public function create()
    {
        $this->authorize('add-permissions');
        return view('admin.permissions.create');
    }
    public function store(Request $request)
    {
        $this->authorize('add-permissions');
        $this->validate($request, ['name' => 'required']);

        Permission::create($request->all());

        return redirect('admin/permissions')->with('flash_message', 'Permission added!');
    }
    public function show($id)
    {
        $this->authorize('read-permissions');
        $permission = Permission::findOrFail($id);

        return view('admin.permissions.show', compact('permission'));
    }
    public function edit($id)
    {
        $this->authorize('edit-permissions');
        $permission = Permission::findOrFail($id);

        return view('admin.permissions.edit', compact('permission'));
    }
    public function update(Request $request, $id)
    {
        $this->authorize('edit-permissions');
        $this->validate($request, ['name' => 'required']);

        $permission = Permission::findOrFail($id);
        $permission->update($request->all());

        return redirect('admin/permissions')->with('flash_message', 'Permission updated!');
    }
    public function destroy($id)
    {
        $this->authorize('delete-permissions');
        Permission::destroy($id);

        return ['flash_message' => 'Permission deleted!'];
    }
}
