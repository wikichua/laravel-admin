<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('browse-settings');
        if($request->ajax()){
            $settings = Setting::get();
            return datatables($settings)->addColumn('action', function ($settings) {
                if (auth()->user()->can('read-settings')) {
                    $act[] = '<a href="'.route('settings.show',$settings->id).'" title="View Setting" class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                }
                if (auth()->user()->can('edit-settings')) {
                    $act[] = '<a href="'.route('settings.edit',$settings->id).'" title="Edit Setting" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                }
                if (auth()->user()->can('delete-settings')) {
                    $act[] = '<a href="'.route('settings.destroy', $settings->id).'" title="Delete Setting" class="deleteBtn btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
                }
                return implode("\n", $act);
            })
            ->toJson();
        }
        return view('admin.settings.index');
    }
    public function create()
    {
        $this->authorize('add-settings');
        return view('admin.settings.create');
    }
    public function store(Request $request)
    {
        $this->authorize('add-settings');
        $this->validate(
            $request,
            [
                'key' => 'required|string|unique:settings',
                'value' => 'required'
            ]
        );

        $requestData = $request->all();

        Setting::create($requestData);

        return redirect('admin/settings')->with('flash_message', 'Setting added!');
    }
    public function show($id)
    {
        $this->authorize('read-settings');
        $setting = Setting::findOrFail($id);

        return view('admin.settings.show', compact('setting'));
    }
    public function edit($id)
    {
        $this->authorize('edit-settings');
        $setting = Setting::findOrFail($id);

        return view('admin.settings.edit', compact('setting'));
    }
    public function update(Request $request, $id)
    {
        $this->authorize('edit-settings');
        $this->validate(
            $request,
            [
                'key' => 'required|string|unique:settings,key,' . $id,
                'value' => 'required'
            ]
        );
        $requestData = $request->all();

        $setting = Setting::findOrFail($id);
        $setting->update($requestData);

        return redirect('admin/settings')->with('flash_message', 'Setting updated!');
    }
    public function destroy($id)
    {
        $this->authorize('delete-settings');
        Setting::destroy($id);

        return ['flash_message' => 'Setting deleted!'];
    }
}
