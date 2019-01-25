<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $settings = Setting::get();
            return datatables($settings)->addColumn('action', function ($settings) {
                return '
                <a href="'.route('settings.show',$settings->id).'" title="View Setting" class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                <a href="'.route('settings.edit',$settings->id).'" title="Edit Setting" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                <a href="'.route('settings.destroy', $settings->id).'" title="Delete Setting" class="deleteBtn btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                ';
            })
            ->toJson();
        }
        return view('admin.settings.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.settings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $setting = Setting::findOrFail($id);

        return view('admin.settings.show', compact('setting'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $setting = Setting::findOrFail($id);

        return view('admin.settings.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Setting::destroy($id);

        return redirect('admin/settings')->with('flash_message', 'Setting deleted!');
    }
}
