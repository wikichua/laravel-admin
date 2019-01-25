<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use App\Permission;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $roles = Role::get();
            return datatables($roles)->addColumn('action', function ($roles) {
                return '
                <a href="'.route('roles.show',$roles->id).'" title="View Role" class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                <a href="'.route('roles.edit',$roles->id).'" title="Edit Role" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                <a href="'.route('roles.destroy', $roles->id).'" title="Delete Role" class="deleteBtn btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                ';
            })
            ->toJson();
        }

        return view('admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        $permissions = Permission::select('id', 'name', 'label')->get()->pluck('label', 'name');

        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function store(Request $request)
    {
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);

        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::select('id', 'name', 'label')->get()->pluck('label', 'name');

        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return void
     */
    public function update(Request $request, $id)
    {
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function destroy($id)
    {
        Role::destroy($id);

        return ['flash_message' => 'Role deleted!'];
    }
}
