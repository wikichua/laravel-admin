<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Permission;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $permissions = Permission::get();
            return datatables($permissions)->addColumn('action', function ($permissions) {
                return '
                <a href="'.route('permissions.show',$permissions->id).'" title="View Permission" class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                <a href="'.route('permissions.edit',$permissions->id).'" title="Edit Permission" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                <a href="'.route('permissions.destroy', $permissions->id).'" title="Delete Permission" class="deleteBtn btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                ';
            })
            ->toJson();
        }

        return view('admin.permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required']);

        Permission::create($request->all());

        return redirect('admin/permissions')->with('flash_message', 'Permission added!');
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
        $permission = Permission::findOrFail($id);

        return view('admin.permissions.show', compact('permission'));
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
        $permission = Permission::findOrFail($id);

        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return void
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, ['name' => 'required']);

        $permission = Permission::findOrFail($id);
        $permission->update($request->all());

        return redirect('admin/permissions')->with('flash_message', 'Permission updated!');
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
        Permission::destroy($id);

        return redirect('admin/permissions')->with('flash_message', 'Permission deleted!');
    }
}
