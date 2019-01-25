<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;

class ActivityLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $activities = Activity::get();
            return datatables($activities)
                ->addColumn('causer', function ($activities) {
                    return $item->causer? '<a href="'.route('users.show', $activities->causer->id).'">{{ $activities->causer->name }}</a>':'-';
                })
                ->addColumn('action', function ($activities) {
                    return '
                    <a href="'.route('activities.show',$activities->id).'" title="View Activity" class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    ';
                })
                ->toJson();
        }

        return view('admin.activitylogs.index', compact('activitylogs'));
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
        $activitylog = Activity::findOrFail($id);

        return view('admin.activitylogs.show', compact('activitylog'));
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
        Activity::destroy($id);

        return redirect('admin/activitylogs')->with('flash_message', 'Activity deleted!');
    }
}
