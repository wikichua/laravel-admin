<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;

class ActivityLogsController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('browse-activitylogs');
        if($request->ajax()){
            $activities = Activity::get();
            return datatables($activities)
                ->addColumn('causer', function ($activities) {
                    return $item->causer? '<a href="'.route('users.show', $activities->causer->id).'">{{ $activities->causer->name }}</a>':'-';
                })
                ->addColumn('action', function ($activities) {
                    if (auth()->user()->can('read-activitylogs')) {
                        $act[] = '<a href="'.route('activitylogs.show',$activitylogs->id).'" title="View Activity" class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                    }
                    if (auth()->user()->can('delete-activitylogs')) {
                        $act[] = '<a href="'.route('activitylogs.destroy', $activitylogs->id).'" title="Delete Activity" class="deleteBtn btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
                    }
                    return implode("\n", $act);
                })
                ->toJson();
        }

        return view('admin.activitylogs.index', compact('activitylogs'));
    }
    public function show($id)
    {
        $this->authorize('read-activitylogs');
        $activitylog = Activity::findOrFail($id);

        return view('admin.activitylogs.show', compact('activitylog'));
    }
    public function destroy($id)
    {
        $this->authorize('delete-activitylogs');
        Activity::destroy($id);

        return ['flash_message' => 'Activity deleted!'];
    }
}
