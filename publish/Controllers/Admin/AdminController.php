<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        $this->authorize('browse-admin');
        return view('admin.dashboard');
    }
}
